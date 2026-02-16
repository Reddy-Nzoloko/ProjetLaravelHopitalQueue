<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TicketController extends Controller
{
    /**
     * Cette fonction va créer un ticket pour un patient
     */
    public function store(Request $request)
    {
        // 1. On vérifie que le service_id est bien envoyé
        $request->validate([
            'service_id' => 'required|exists:services,id',
        ]);

        // 2. On récupère les infos du service (pour avoir le préfixe comme "PED")
        $service = Service::findOrFail($request->service_id);

        // 3. On calcule le numéro : On compte les tickets du jour pour ce service + 1
        $count = Ticket::where('service_id', $service->id)
                       ->whereDate('created_at', Carbon::today())
                       ->count();

        $numeroSuivant = $count + 1;

        // 4. On crée le numéro formaté (ex: PED-001)
        // str_pad ajoute les zéros pour faire "001" au lieu de "1"
        $numeroTicket = $service->prefixe . '-' . str_pad($numeroSuivant, 3, '0', STR_PAD_LEFT);

        // 5. Enregistrement dans la base de données
        $ticket = Ticket::create([
            'hopital_id'    => $service->hopital_id,
            'service_id'    => $service->id,
            'numero_ticket' => $numeroTicket,
            'priorite'      => $request->priorite ?? 'normale',
            'statut'        => 'en_attente',
            'heure_arrivee' => now(),
        ]);

        // 6. On retourne une réponse (pour l'instant en texte, plus tard vers une vue)
        return "Ticket généré avec succès : " . $ticket->numero_ticket;
    }
}
