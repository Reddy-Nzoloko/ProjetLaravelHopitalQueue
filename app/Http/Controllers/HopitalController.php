<?php

namespace App\Http\Controllers;

use App\Models\Hopital;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class HopitalController extends Controller
{
    /**
     * Liste tous les hôpitaux du système
     */
    public function index() {
        $user = Auth::user();

        if ($user->role === 'admin_global') {
            // Le "withCount" est magique : il compte les services sans charger toutes les données
            $hopitaux = Hopital::withCount('services')->get();
        } else {
            // Admin d'hôpital ne voit que son propre établissement
            $hopitaux = Hopital::where('id', $user->hopital_id)
                               ->withCount('services')
                               ->get();
        }

        return view('admin.hopitaux.index', compact('hopitaux'));
}

    /**
     * Formulaire de création
     */
   public function create()
{
    if (Auth::user()->role !== 'admin_global') {
        abort(403, 'Autorisation requise');
    }

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
