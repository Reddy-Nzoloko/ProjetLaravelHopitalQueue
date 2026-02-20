<?php

namespace App\Http\Controllers;

use App\Models\Hopital;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HopitalController extends Controller
{
    /**
     * Liste tous les hôpitaux du système
     */
    public function index() {
    // Le "withCount" est magique : il compte les services sans charger toutes les données
    $hopitaux = Hopital::withCount('services')->get();
    return view('admin.hopitaux.index', compact('hopitaux'));
}

    /**
     * Formulaire de création
     */
   public function create()
{
    return view('admin.hopitaux.create');
}

    /**
     * Enregistrer l'hôpital
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string',
        ]);

        // Génération automatique d'un code unique (ex: CLINIQUE-ESPOIR-123)
        $codeUnique = Str::upper(Str::slug($request->nom)) . '-' . rand(100, 999);

        Hopital::create([
            'nom' => $request->nom,
            'adresse' => $request->adresse,
            'code_unique' => $codeUnique,
            'configuration' => ['theme' => 'blue', 'langue' => 'fr'], // Config par défaut
        ]);

        return redirect()->route('hopitaux.index')->with('success', 'Hôpital ajouté avec succès !');
    }
}
