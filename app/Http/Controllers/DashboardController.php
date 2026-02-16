<?php

namespace App\Http\Controllers;

use App\Models\Ticket;

class DashboardController extends Controller
{
    public function index()
    {
        $total = Ticket::count();
        $enAttente = Ticket::enAttente()->count();
        $enConsultation = Ticket::where('statut', 'en_consultation')->count();
        $termine = Ticket::where('statut', 'terminé')->count();

        return view('dashboard', compact('total', 'enAttente', 'enConsultation', 'termine'));
    }
}
