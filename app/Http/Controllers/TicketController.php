<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $tickets = Ticket::with(['service', 'guichet', 'medecin'])->latest()->paginate(20);
        $services = Service::all();

        return view('tickets.index', compact('tickets', 'services'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'service_id' => 'required|exists:services,id',
            'priorite' => 'nullable|in:0,1',
        ]);

        $service = Service::findOrFail($data['service_id']);
        $numero = Ticket::generateNumeroForService($service);

        $ticket = Ticket::create(array_merge($data, [
            'numero_ticket' => $numero,
            'hopital_id' => $service->hopital_id,
            'statut' => 'en_attente',
        ]));

        return redirect()->route('tickets.index')->with('success', "Ticket créé : {$ticket->numero_ticket}");
    }

    public function show(Ticket $ticket)
    {
        $ticket->load('service', 'consultation', 'guichet', 'medecin');

        return view('tickets.show', compact('ticket'));
    }

    public function call(Ticket $ticket)
    {
        $ticket->markAppel();

        return back()->with('success', "Ticket {$ticket->numero_ticket} appelé");
    }

    public function start(Ticket $ticket)
    {
        $ticket->startConsultation();

        return back()->with('success', "Consultation démarrée pour {$ticket->numero_ticket}");
    }

    public function finish(Ticket $ticket)
    {
        $ticket->finishConsultation();

        return back()->with('success', "Consultation terminée pour {$ticket->numero_ticket}");
    }
}
