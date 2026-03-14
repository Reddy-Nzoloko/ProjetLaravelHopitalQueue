<?php

namespace App\Http\Controllers;

use App\Models\Guichet;
use App\Models\Hopital;
use App\Models\Service;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuichetController extends Controller
{
    /**
     * Liste tous les guichets accessibles à l'utilisateur.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin_global') {
            $guichets = Guichet::with(['hopital', 'service'])->get();
        } elseif ($user->role === 'admin_hopital') {
            // admin_hopital voit tous les guichets de son hôpital
            $guichets = Guichet::with('service')
                ->where('hopital_id', $user->hopital_id)
                ->get();
        } elseif ($user->role === 'medecin') {
            // medecin ne voit que les guichets de son service
            $guichets = Guichet::with('service')
                ->where('hopital_id', $user->hopital_id)
                ->where('service_id', $user->service_id)
                ->get();
        } else {
            $guichets = collect(); // autres rôles n'ont pas accès
        }

        return view('admin.guichets.index', compact('guichets'));
    }

    /**
     * Formulaire de création.
     */
    public function create()
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin_global', 'admin_hopital', 'medecin'])) {
            abort(403);
        }

        // si global on peut choisir l'hôpital et le service ; sinon on se restreint
        if ($user->role === 'admin_global') {
            $hopitaux = Hopital::all();
            $services = Service::all();
        } elseif ($user->role === 'admin_hopital') {
            $hopitaux = Hopital::where('id', $user->hopital_id)->get();
            $services = Service::where('hopital_id', $user->hopital_id)->get();
        } elseif ($user->role === 'medecin') {
            $hopitaux = Hopital::where('id', $user->hopital_id)->get();
            $services = Service::where('id', $user->service_id)->get(); // seulement son service
        }

        return view('admin.guichets.create', compact('hopitaux', 'services'));
    }

    /**
     * Enregistre un nouveau guichet.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin_global', 'admin_hopital', 'medecin'])) {
            abort(403);
        }

        $rules = [
            'nom' => 'required|string|max:255',
            'est_ouvert' => 'boolean',
        ];

        if ($user->role === 'admin_global') {
            $rules['hopital_id'] = 'required|exists:hopitaux,id';
            $rules['service_id'] = 'nullable|exists:services,id';
        } elseif ($user->role === 'admin_hopital') {
            $rules['service_id'] = 'nullable|exists:services,id';
        } elseif ($user->role === 'medecin') {
            // pas de service_id dans les règles, il sera forcé
        }

        $data = $request->validate($rules);

        if ($user->role !== 'admin_global') {
            $data['hopital_id'] = $user->hopital_id;
        }

        // Pour les médecins, forcer le service_id à leur service
        if ($user->role === 'medecin') {
            $data['service_id'] = $user->service_id;
        }

        Guichet::create($data);

        return redirect()->route('guichets.index')->with('success', 'Guichet créé !');
    }

    /**
     * Met à jour le statut du guichet (fermer/ouvrir).
     */
    public function update(Request $request, Guichet $guichet)
    {
        $user = Auth::user();

        // Vérifier les permissions
        if ($user->role === 'admin_global') {
            // peut modifier n'importe quel guichet
        } elseif ($user->role === 'admin_hopital') {
            if ($guichet->hopital_id !== $user->hopital_id) {
                abort(403);
            }
        } elseif ($user->role === 'medecin') {
            if ($guichet->hopital_id !== $user->hopital_id || $guichet->service_id !== $user->service_id) {
                abort(403);
            }
        } else {
            abort(403);
        }

        $request->validate([
            'est_ouvert' => 'required|boolean',
        ]);

        $guichet->update(['est_ouvert' => $request->est_ouvert]);

        // Si le guichet est fermé, les tickets en attente sont annulés
        if (! $request->est_ouvert) {
            Ticket::where('guichet_id', $guichet->id)
                ->where('statut', 'en_attente')
                ->update(['statut' => 'absent']);
        }

        return redirect()->back()->with('success', 'Statut du guichet mis à jour !');
    }
}
