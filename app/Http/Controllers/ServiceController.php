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
} else {
    // L'Admin d'Hôpital ou le Médecin ne voit que les services de SON hôpital
    $services = Service::where('hopital_id', $user->hopital_id)
                       ->with('hopital')
                       ->get();
    }

    return view('admin.services.index', compact('services'));
}

    /**
     * Formulaire de création (Gère aussi la sélection automatique via URL)
     */
    public function create(Request $request)
{
    $user = Auth::user();

    if ($user->role === 'super_admin') {
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
        $request->validate([
            'hopital_id' => 'required|exists:hopitaux,id',
            'nom' => 'required|string|max:255',
            'prefixe' => 'required|string|max:5|unique:services,prefixe',
        ]);

        Service::create($request->all());

        return redirect()->route('services.index')->with('success', 'Service créé avec succès !');
    }
}
