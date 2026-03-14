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
            'service_id'      => 'nullable|exists:services,id',
            'guichet_id'      => 'nullable|exists:guichets,id',
            // informations du patient
            'patient_nom'     => 'required|string|max:255',
            'patient_telephone' => 'required|string|max:30',
            'patient_email'   => 'required|email|max:255',
            'patient_age'     => 'required|integer|min:0|max:150',
            'patient_sexe'    => 'required|in:M,F,X',
        ]);

        // déterminer le service sélectionné, en donnant priorité au guichet
        if ($request->filled('guichet_id')) {
            $guichet = Guichet::find($request->guichet_id);

            // impossible de prendre un ticket pour un guichet fermé
            if ($guichet && ! $guichet->est_ouvert) {
                return redirect()->back()->withErrors(['guichet_id' => 'Le guichet sélectionné est fermé.']);
            }

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

        // priorité automatique pour les très âgés
        $priorite = $request->patient_age >= 85 ? 1 : 0;

        Ticket::create([
            'hopital_id'       => $service->hopital_id,
            'service_id'       => $service->id,
            'guichet_id'       => $request->guichet_id,
            'numero_ticket'    => $codeTicket,
            'patient_nom'      => $request->patient_nom,
            'patient_telephone'=> $request->patient_telephone,
            'patient_email'    => $request->patient_email,
            'patient_age'      => $request->patient_age,
            'patient_sexe'     => $request->patient_sexe,
            'priorite'         => $priorite,
            'statut'           => 'en_attente',
            'heure_arrivee'    => now(),
        ]);

        return redirect()->back()->with('success_ticket', $codeTicket);
    }
    //
    public function index()
    {
        $user = auth()->user();

        $query = Ticket::where('statut', 'en_attente')
                       ->whereDate('created_at', today())
                       ->orderBy('priorite', 'desc')
                       ->orderBy('created_at', 'asc');

        $delaiAppel = 30;
        $guichet = null;

        if ($user->role === 'admin_hopital') {
            $query->where('hopital_id', $user->hopital_id);
        } elseif ($user->role === 'medecin') {
            $guichet = Guichet::where('service_id', $user->service_id)
                              ->where('hopital_id', $user->hopital_id)
                              ->first();

            if ($guichet) {
                $query->where('guichet_id', $guichet->id);
                $delaiAppel = $guichet->delai_appel ?? $delaiAppel;
            } else {
                $query->where('service_id', $user->service_id);
            }
        }

        $ticketsAttente = $query->get();
        $totalTickets = $query->count();

        return view('tickets.index', compact('ticketsAttente', 'totalTickets', 'guichet', 'delaiAppel'));
    }

    public function call(Ticket $ticket)
    {
        $user = auth()->user();

        // Seuls les médecins peuvent appeler les tickets de leur guichet
        if ($user->role === 'medecin') {
            $guichet = Guichet::where('service_id', $user->service_id)
                              ->where('hopital_id', $user->hopital_id)
                              ->first();

            if (! $guichet || $ticket->guichet_id !== $guichet->id) {
                abort(403);
            }
        }

        $ticket->update([
            'statut' => 'appelé',
            'heure_appel' => now(),
            'user_id' => $user->id,
        ]);

        return redirect()->back()->with('success', "Appel du ticket {$ticket->numero_ticket} enregistré.");
    }

    public function next()
    {
        $user = auth()->user();

        if ($user->role !== 'medecin') {
            abort(403);
        }

        $guichet = Guichet::where('service_id', $user->service_id)
                          ->where('hopital_id', $user->hopital_id)
                          ->first();

        if (! $guichet) {
            return redirect()->back()->with('warning', 'Aucun guichet configuré pour votre service.');
        }

        $ticket = Ticket::where('guichet_id', $guichet->id)
            ->where('statut', 'en_attente')
            ->whereDate('created_at', today())
            ->orderBy('priorite', 'desc')
            ->orderBy('created_at', 'asc')
            ->first();

        if (! $ticket) {
            return redirect()->back()->with('warning', 'Aucun ticket en attente.');
        }

        $ticket->update([
            'statut' => 'appelé',
            'heure_appel' => now(),
            'user_id' => $user->id,
        ]);

        return redirect()->back()->with('success', "Appel du ticket {$ticket->numero_ticket} enregistré.");
    }
}

