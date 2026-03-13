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
        } elseif ($user->role === 'medecin') {
            // Statistiques très limitées au service du médecin
            $service = $user->service;
            $stats = [
                'total_hopitaux' => $service ? 1 : 0,
                'total_services' => $service ? 1 : 0,
                'total_users'    => $service ? $service->medecins()->count() : 0,
                'total_tickets'  => $service ? Ticket::where('service_id', $service->id)->count() : 0,
            ];
            $hopitaux = $service && $service->hopital ? collect([$service->hopital->loadCount('services')]) : collect();

            // Infos sur le guichet du médecin
            $guichet = \App\Models\Guichet::where('service_id', $user->service_id)->first();
            $tickets_en_attente = $guichet ? Ticket::where('guichet_id', $guichet->id)->where('statut', 'en_attente')->count() : 0;
        } else {
            // autres rôles (réceptionnistes, etc.) affichage minimal
            $stats = [
                'total_hopitaux' => 0,
                'total_services' => 0,
                'total_users'    => 0,
                'total_tickets'  => 0,
            ];
            $guichet = null;
            $tickets_en_attente = 0;
        }

        return view('dashboard', compact('stats', 'hopitaux', 'guichet', 'tickets_en_attente'));
    }
}
