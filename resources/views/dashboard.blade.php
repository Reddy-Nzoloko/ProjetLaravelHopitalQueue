@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    <div class="p-4 bg-white shadow rounded">
        <div class="text-sm text-gray-500">Total tickets</div>
        <div class="text-2xl font-semibold">{{ $total }}</div>
    </div>

    <div class="p-4 bg-white shadow rounded">
        <div class="text-sm text-gray-500">En attente</div>
        <div class="text-2xl font-semibold text-yellow-600">{{ $enAttente }}</div>
    </div>

    <div class="p-4 bg-white shadow rounded">
        <div class="text-sm text-gray-500">En consultation</div>
        <div class="text-2xl font-semibold text-blue-600">{{ $enConsultation }}</div>
    </div>

    <div class="p-4 bg-white shadow rounded">
        <div class="text-sm text-gray-500">Terminés</div>
        <div class="text-2xl font-semibold text-green-600">{{ $termine }}</div>
    </div>
</div>

<div class="mt-6">
    <h3 class="text-lg font-semibold mb-2">Derniers tickets</h3>
    <div class="bg-white shadow rounded overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-gray-50">
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
                    <tr class="border-t">
                        <td class="p-3">{{ $ticket->id }}</td>
                        <td class="p-3">{{ $ticket->numero_ticket }}</td>
                        <td class="p-3">{{ $ticket->service->nom ?? '-' }}</td>
                        <td class="p-3">{{ $ticket->statut }}</td>
                        <td class="p-3"><a href="{{ route('tickets.show', $ticket) }}" class="text-indigo-600">Voir</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
