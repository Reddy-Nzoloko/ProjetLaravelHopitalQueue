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

        // Stats de base
        $stats = [
            'total_hopitaux' => Hopital::count(),
            'total_services' => Service::count(),
            'total_users'    => User::count(),
            'total_tickets'  => Ticket::count(),
        ];

        // On récupère TOUS les hôpitaux pour l'Admin Global
        $hopitaux = Hopital::withCount('services')->get();

        return view('dashboard', compact('stats', 'hopitaux'));
    }
}
