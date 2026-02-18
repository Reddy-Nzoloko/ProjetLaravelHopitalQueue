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

        // Logique pour calculer le numéro suivant (ex: PED-001, PED-002)
        $dernierTicket = Ticket::where('service_id', $service->id)
            ->whereDate('created_at', today())
            ->count();

        $numero = $dernierTicket + 1;
        $codeTicket = $service->prefixe . '-' . str_pad($numero, 3, '0', STR_PAD_LEFT);

        $ticket = Ticket::create([
            'service_id' => $service->id,
            'numero' => $numero,
            'code_ticket' => $codeTicket,
            'statut' => 'en_attente',
        ]);

        return redirect()->back()->with('success_ticket', $codeTicket);
    }
    //
    public function index()
{
    // On récupère les tickets qui attendent encore
    $ticketsAttente = Ticket::where('statut', 'en_attente')
                            ->whereDate('created_at', today())
                            ->orderBy('created_at', 'asc')
                            ->get();

    return view('tickets.index', compact('ticketsAttente'));
}
}
