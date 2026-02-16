@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    <div class="p-4 frost rounded-xl shadow-neon">
        <div class="text-sm opacity-60">Total tickets</div>
        <div class="text-3xl font-semibold text-neon">{{ $total }}</div>
    </div>

    <div class="p-4 frost rounded-xl shadow-neon">
        <div class="text-sm opacity-60">En attente</div>
        <div class="text-3xl font-semibold text-yellow-400">{{ $enAttente }}</div>
    </div>

    <div class="p-4 frost rounded-xl shadow-neon">
        <div class="text-sm opacity-60">En consultation</div>
        <div class="text-3xl font-semibold text-indigo-300">{{ $enConsultation }}</div>
    </div>

    <div class="p-4 frost rounded-xl shadow-neon">
        <div class="text-sm opacity-60">Terminés</div>
        <div class="text-3xl font-semibold text-green-300">{{ $termine }}</div>
    </div>
</div>

<div class="mt-6 grid md:grid-cols-2 gap-4">
    <div class="p-4 frost rounded-xl shadow-neon border border-white/6">
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center gap-3">
                <div class="p-2 rounded-md bg-gradient-to-br from-indigo-600 to-teal-400 shadow-neon">
                    <i data-lucide="activity" class="w-5 h-5 text-white"></i>
                </div>
                <div>
                    <div class="text-sm opacity-60">Tendance — 7 derniers jours</div>
                    <div class="card-title">Tickets par jour</div>
                </div>
            </div>
            <div class="text-sm text-gray-400">Temps réel</div>
        </div>
        <canvas id="waitingChart" height="120"></canvas>
        <script type="application/json" id="waiting-data">@json(['labels' => $labels ?? [], 'values' => $values ?? []])</script>
    </div>

    <div class="p-4 frost rounded-xl shadow-neon border border-white/6">
        <div class="flex items-center gap-3 mb-3">
            <div class="p-2 rounded-md bg-gradient-to-br from-indigo-600 to-teal-400 shadow-neon">
                <i data-lucide="pie-chart" class="w-5 h-5 text-white"></i>
            </div>
            <div>
                <div class="text-sm opacity-60">Composition de la file</div>
                <div class="card-title">Par service</div>
            </div>
        </div>
        <canvas id="compositionChart" height="120"></canvas>
        <script type="application/json" id="composition-data">@json(['labels' => $serviceLabels ?? [], 'values' => $serviceValues ?? []])</script>
    </div>
</div>

    <div class="mt-6">
    <h3 class="text-lg font-semibold mb-2">Derniers tickets</h3>
    <div class="frost rounded-lg overflow-hidden">
        <table class="w-full text-left table-dark">
            <thead>
                <tr>
                    <th class="p-3">#</th>
                    <th class="p-3">Ticket</th>
                    <th class="p-3">Service</th>
                    <th class="p-3">Statut</th>
                    <th class="p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach(\App\Models\Ticket::latest()->limit(8)->get() as $ticket)
                    <tr>
                        <td class="p-3">{{ $ticket->id }}</td>
                        <td class="p-3">{{ $ticket->numero_ticket }}</td>
                        <td class="p-3">{{ $ticket->service->nom ?? '-' }}</td>
                        <td class="p-3">{{ $ticket->statut }}</td>
                        <td class="p-3"><a href="{{ route('tickets.show', $ticket) }}" class="text-neon">Voir</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
