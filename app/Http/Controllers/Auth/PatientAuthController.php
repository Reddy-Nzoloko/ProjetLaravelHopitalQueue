<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Guichet;
use App\Models\Hopital;
use App\Models\Patient;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class PatientAuthController extends Controller
{
    /**
     * Affiche le formulaire d'inscription / connexion patient (inclus dans la page d'accueil).
     */
    public function showForm(Request $request): View
    {
        $hopitaux = Hopital::all();
        $services = Service::all();
        $guichets = Guichet::all();

        return view('home', [
            'hopitaux' => $hopitaux,
            'services' => $services,
            'guichets' => $guichets,
            'mode' => $request->query('mode'),
        ]);
    }

    /**
     * Enregistre un nouveau patient et le connecte.
     */
    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:patients,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'hopital_id' => ['required', 'exists:hopitaux,id'],
            'service_id' => ['required', 'exists:services,id'],
            'guichet_id' => ['required', 'exists:guichets,id'],
        ]);

        $patient = Patient::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'hopital_id' => $request->hopital_id,
            'service_id' => $request->service_id,
            'guichet_id' => $request->guichet_id,
        ]);

        Auth::guard('patient')->login($patient);

        return redirect()->route('patient.dashboard');
    }

    /**
     * Authentifie un patient.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('patient')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('patient.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Ces informations d’identification ne correspondent pas à nos enregistrements.',
        ])->onlyInput('email');
    }

    /**
     * Déconnecte le patient.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('patient')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Vous avez été déconnecté.');
    }
}
