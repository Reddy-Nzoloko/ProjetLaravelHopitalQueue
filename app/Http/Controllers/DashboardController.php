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
    $user = auth()->user();

    // Stats de base
    $stats = [
        'total_hopitaux' => \App\Models\Hopital::count(),
        'total_services' => \App\Models\Service::count(),
        'total_users'    => \App\Models\User::count(),
        'total_tickets'  => \App\Models\Ticket::count(),
    ];

    // On récupère TOUS les hôpitaux pour l'Admin Global
    $hopitaux = \App\Models\Hopital::withCount('services')->get();

    return view('dashboard', compact('stats', 'hopitaux'));
}
}
