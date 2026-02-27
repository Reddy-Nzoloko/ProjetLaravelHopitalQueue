<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Hopital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Liste des services
     */
    public function index() {
    $user = Auth::user();

    // Remplace 'super_admin' par 'admin_global'
if ($user->role === 'admin_global') {
    $services = Service::with('hopital')->get();
} elseif ($user->role === 'admin_hopital') {
    $services = Service::where('hopital_id', $user->hopital_id)
                       ->with('hopital')
                       ->get();
} else {
    // médecin ou autre personnel : uniquement son service
    $services = Service::where('id', $user->service_id ?? 0)
                       ->with('hopital')
                       ->get();
}
}

    /**
     * Formulaire de création (Gère aussi la sélection automatique via URL)
     */
    public function create(Request $request)
{
    $user = Auth::user();
    // seuls admin_global et admin_hopital peuvent créer un service
    if (!in_array($user->role, ['admin_global', 'admin_hopital'])) {
        abort(403);
    }

    if ($user->role === 'admin_global') {
        $hopitaux = Hopital::all();
    } else {
        // Un Admin d'Hôpital ne peut voir QUE son propre hôpital dans le formulaire
        $hopitaux = Hopital::where('id', $user->hopital_id)->get();
    }

    $selectedHopitalId = $request->query('hopital_id');

    return view('admin.services.create', compact('hopitaux', 'selectedHopitalId'));
}
    /**
     * Enregistrement du service
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin_global', 'admin_hopital'])) {
            abort(403);
        }

        $request->validate([
            'hopital_id' => 'required|exists:hopitaux,id',
            'nom' => 'required|string|max:255',
            'prefixe' => 'required|string|max:5|unique:services,prefixe',
        ]);

        // si admin_hopital, forcer l'hôpital
        if ($user->role === 'admin_hopital') {
            $request->merge(['hopital_id' => $user->hopital_id]);
        }

        Service::create($request->all());

        // redirection différente selon le rôle
        if ($user->role === 'admin_hopital') {
            return redirect()->route('dashboard')->with('success', 'Service créé avec succès !');
        }

        return redirect()->route('services.index')->with('success', 'Service créé avec succès !');
    }

    /**
     * Affiche les détails d'un service (liste des médecins)
     */
    public function show(Service $service)
    {
        $user = Auth::user();
        // autorisation : admin_global, admin_hopital du même hopital, ou medecin du même service
        if ($user->role === 'admin_global') {
            // ok
        } elseif ($user->role === 'admin_hopital' && $user->hopital_id === $service->hopital_id) {
            // ok
        } elseif ($user->role === 'medecin' && $user->service_id === $service->id) {
            // ok
        } else {
            abort(403);
        }

        // charger les médecins attachés
        $medecins = $service->medecins()->get();
        return view('admin.services.show', compact('service', 'medecins'));
    }
}
