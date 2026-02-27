<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Service;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Affiche l'interface de prise de ticket pour un hôpital précis
     */
    public function create($hopital_id)
    {
        $services = Service::where('hopital_id', $hopital_id)->get();
        return view('tickets.create', compact('services', 'hopital_id'));
    }

    /**
     * Génère le ticket en base de données
     */
    public function store(Request $request)
{
    $request->validate([
        'service_id' => 'required|exists:services,id',
    ]);

    $service = Service::find($request->service_id);

    // 1. Calcul du numéro (Basé sur numero_ticket dans ton modèle)
    $dernierTicketCount = Ticket::where('service_id', $service->id)
        ->whereDate('created_at', today())
        ->count();

    $numero = $dernierTicketCount + 1;
    $codeTicket = $service->prefixe . '-' . str_pad($numero, 3, '0', STR_PAD_LEFT);

    // 2. Création avec les bons noms de colonnes de ton modèle
    Ticket::create([
        'hopital_id'    => $service->hopital_id, // Récupéré via le service
        'service_id'    => $service->id,
        'numero_ticket' => $codeTicket,          // Nom dans ton $fillable
        'statut'        => 'en_attente',
        'heure_arrivee' => now(),                // Pour tes casts datetime
    ]);

    return redirect()->back()->with('success_ticket', $codeTicket);
}
    //
    public function index()
{
    $user = auth()->user();

    $query = Ticket::where('statut', 'en_attente')
                   ->whereDate('created_at', today())
                   ->orderBy('created_at', 'asc');

    if ($user->role === 'admin_hopital') {
        $query->where('hopital_id', $user->hopital_id);
    } elseif ($user->role === 'medecin') {
        $query->where('service_id', $user->service_id);
    }

    $ticketsAttente = $query->get();
    $totalTickets = $query->count();

    return view('tickets.index', compact('ticketsAttente', 'totalTickets'));
}
}
