<?php

namespace App\Http\Controllers;

use App\Models\Guichet;
use App\Models\Hopital;
use App\Models\Service;
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
        } else {
            // admin_hopital ou medecin (même hôpital)
            $guichets = Guichet::with('service')
                ->where('hopital_id', $user->hopital_id)
                ->get();
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
        } else {
            $hopitaux = Hopital::where('id', $user->hopital_id)->get();
            $services = Service::where('hopital_id', $user->hopital_id)->get();
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
        } else {
            $rules['service_id'] = 'nullable|exists:services,id';
        }

        $data = $request->validate($rules);

        if ($user->role !== 'admin_global') {
            $data['hopital_id'] = $user->hopital_id;
        }

        // Lorsqu'un médecin crée un guichet, rattacher automatiquement à son service si présent
        if ($user->role === 'medecin' && empty($data['service_id'])) {
            $data['service_id'] = $user->service_id;
        }

        Guichet::create($data);

        return redirect()->route('guichets.index')->with('success', 'Guichet créé !');
    }
}
