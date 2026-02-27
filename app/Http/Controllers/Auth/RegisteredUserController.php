<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Hopital;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
   public function create()
{
    // On récupère la liste des hôpitaux pour le menu déroulant
    $hopitaux = \App\Models\Hopital::all();
    return view('auth.register', compact('hopitaux'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        'role' => ['required', 'string'],
        'hopital_id' => ['nullable', 'exists:hopitaux,id'], // Nullable si c'est un autre Admin Global
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'hopital_id' => $request->hopital_id,
    ]);

    // Redirection vers le dashboard avec un message de succès
    return redirect()->route('dashboard')->with('success', 'Agent créé avec succès !');
}

/**
 * Formulaire de création d'un admin d'hôpital (depuis le dashboard)
 */
public function createAdmin(Hopital $hopital): View
{
    // Vérifier que l'utilisateur est admin global
    if (Auth::user()->role !== 'admin_global') {
        abort(403, 'Accès non autorisé');
    }

    return view('auth.register-admin', compact('hopital'));
}

/**
 * Enregistrer un admin d'hôpital depuis le dashboard
 */
public function storeAdmin(Request $request, Hopital $hopital): RedirectResponse
{
    // Vérifier que l'utilisateur est admin global
    if (Auth::user()->role !== 'admin_global') {
        abort(403, 'Accès non autorisé');
    }

    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'admin_hopital',
        'hopital_id' => $hopital->id,
    ]);

    return redirect()->route('hopitaux.index')
        ->with('success', "Administrateur '{$request->name}' ajouté(e) pour l'hôpital '{$hopital->nom}' !");
}
    /**
     * Formulaire d'ajout de médecin pour un hôpital donné
     */
    public function createMedecin(Hopital $hopital): View
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin_global', 'admin_hopital'])) {
            abort(403, 'Accès non autorisé');
        }
        // Si c'est un admin_hopital, s'assurer qu'il correspond à l'hôpital
        if ($user->role === 'admin_hopital' && $user->hopital_id !== $hopital->id) {
            abort(403, 'Accès non autorisé');
        }

        return view('auth.register-medecin', compact('hopital'));
    }

    public function storeMedecin(Request $request, Hopital $hopital): RedirectResponse
    {
        $user = Auth::user();
        if (!in_array($user->role, ['admin_global', 'admin_hopital'])) {
            abort(403, 'Accès non autorisé');
        }

        if ($user->role === 'admin_hopital' && $user->hopital_id !== $hopital->id) {
            abort(403, 'Accès non autorisé');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $new = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'medecin',
            'hopital_id' => $hopital->id,
        ]);

        return redirect()->route('dashboard')
            ->with('success', "Médecin '{\$request->name}' ajouté(e) pour l'hôpital '{\$hopital->nom}' !");
    }}
