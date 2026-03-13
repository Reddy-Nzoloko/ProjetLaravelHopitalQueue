<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Service;
use App\Models\Guichet;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Affiche l'interface de prise de ticket pour un hôpital précis
     */
    public function create($hopital_id)
    {
        // liste des services pour l'hôpital demandé (même si on utilise souvent le guichet)
        $services = Service::where('hopital_id', $hopital_id)->get();

        // si des guichets ouverts existent, on les montrera en priorité
        $guichets = Guichet::where('hopital_id', $hopital_id)
                             ->where('est_ouvert', true)
                             ->with('service')
                             ->get();

        return view('tickets.create', compact('services', 'guichets', 'hopital_id'));
    }

    /**
     * Génère le ticket en base de données
     */
    public function store(Request $request)
{
    $request->validate([
        'service_id'  => 'nullable|exists:services,id',
        'guichet_id'  => 'nullable|exists:guichets,id',
    ]);

    // déterminer le service sélectionné, en donnant priorité au guichet
    if ($request->filled('guichet_id')) {
        $guichet = Guichet::find($request->guichet_id);
        $service = $guichet->service ?? Service::find($request->service_id);
    } else {
        $service = Service::find($request->service_id);
    }

    if (! $service) {
        abort(400, 'Service non spécifié');
    }

    // numéro de ticket calculé par service
    $dernierTicketCount = Ticket::where('service_id', $service->id)
        ->whereDate('created_at', today())
        ->count();

    $numero = $dernierTicketCount + 1;
    $codeTicket = $service->prefixe . '-' . str_pad($numero, 3, '0', STR_PAD_LEFT);

    Ticket::create([
        'hopital_id'    => $service->hopital_id,
        'service_id'    => $service->id,
        'guichet_id'    => $request->guichet_id,
        'numero_ticket' => $codeTicket,
        'statut'        => 'en_attente',
        'heure_arrivee' => now(),
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
