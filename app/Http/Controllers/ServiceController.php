<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Hopital;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Liste des services
     */
    public function index()
    {
        $services = Service::with('hopital')->get();
        return view('admin.services.index', compact('services'));
    }

    /**
     * Formulaire de création (Gère aussi la sélection automatique via URL)
     */
    public function create(Request $request)
    {
        $hopitaux = Hopital::all();

        // On récupère l'ID passé dans l'URL (ex: ?hopital_id=2)
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
