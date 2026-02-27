<?php

namespace App\Http\Controllers;

use App\Models\Hopital;
use App\Models\Service;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // on prépare le scope par défaut (global)
        $hopitaux = collect();

        if ($user->role === 'admin_global') {
            // Stats globales
            $stats = [
                'total_hopitaux' => Hopital::count(),
                'total_services' => Service::count(),
                'total_users'    => User::count(),
                'total_tickets'  => Ticket::count(),
            ];

            // Tous les hôpitaux
            $hopitaux = Hopital::withCount('services')->get();
        } elseif ($user->role === 'admin_hopital') {
            // Statistiques limitées à l'hôpital de l'utilisateur
            $hopital = $user->hopital;

            $stats = [
                'total_hopitaux' => $hopital ? 1 : 0,
                'total_services' => $hopital ? $hopital->services()->count() : 0,
                'total_users'    => $hopital ? $hopital->users()->count() : 0,
                'total_tickets'  => $hopital ? Ticket::whereIn('service_id', $hopital->services()->pluck('id'))->count() : 0,
            ];

            $hopitaux = $hopital ? collect([$hopital->loadCount('services')]) : collect();
        } else {
            // les autres rôles (medecin, etc.) voient très peu
            $stats = [
                'total_hopitaux' => 0,
                'total_services' => 0,
                'total_users'    => 0,
                'total_tickets'  => 0,
            ];
        }

        return view('dashboard', compact('stats', 'hopitaux'));
    }
}
