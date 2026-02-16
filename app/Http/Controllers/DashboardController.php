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

        // Data for charts (last 7 days ticket counts)
        $labels = [];
        $values = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $labels[] = now()->subDays($i)->format('d M');
            $values[] = Ticket::whereDate('created_at', $date)->count();
        }

        // Queue composition by service
        $serviceCounts = Ticket::join('services', 'tickets.service_id', 'services.id')
            ->selectRaw('services.nom, count(*) as total')
            ->groupBy('services.nom')
            ->pluck('total', 'nom')
            ->toArray();

        $serviceLabels = array_keys($serviceCounts);
        $serviceValues = array_values($serviceCounts);

        return view('dashboard', compact('total', 'enAttente', 'enConsultation', 'termine', 'labels', 'values', 'serviceLabels', 'serviceValues'));
    }
}
