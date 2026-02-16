<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Ticket;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function show(Consultation $consultation)
    {
        $consultation->load('ticket');

        return view('consultations.show', compact('consultation'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
            'symptomes' => 'nullable|string',
            'diagnostic' => 'nullable|string',
            'ordonnance' => 'nullable|string',
            'notes_privees' => 'nullable|string',
        ]);

        $consultation = Consultation::create($data);

        // marquer le ticket comme terminé si nécessaire
        $ticket = Ticket::find($data['ticket_id']);
        if ($ticket) {
            $ticket->finishConsultation();
        }

        return redirect()->route('tickets.show', $data['ticket_id'])->with('success', 'Consultation enregistrée');
    }
}
