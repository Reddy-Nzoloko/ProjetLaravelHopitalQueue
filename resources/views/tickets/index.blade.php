@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h2 class="text-xl font-semibold">Tickets</h2>
</div>

<div class="grid md:grid-cols-3 gap-6">
    <div class="md:col-span-1 bg-white shadow rounded p-4">
        <form method="POST" action="{{ route('tickets.store') }}">
            @csrf
            <label class="block text-sm text-gray-600 mb-1">Service</label>
            <select name="service_id" class="w-full border p-2 rounded mb-3">
                @foreach($services as $service)
                    <option value="{{ $service->id }}">{{ $service->nom }}</option>
                @endforeach
            </select>

            <label class="block text-sm text-gray-600 mb-1">Priorité</label>
            <select name="priorite" class="w-full border p-2 rounded mb-3">
                <option value="0">Normal</option>
                <option value="1">Urgent</option>
            </select>

            <button class="w-full bg-indigo-600 text-white px-4 py-2 rounded">Générer un ticket</button>
        </form>
    </div>

    <div class="md:col-span-2">
        <div class="bg-white shadow rounded overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3">#</th>
                        <th class="p-3">Ticket</th>
                        <th class="p-3">Service</th>
                        <th class="p-3">Priorité</th>
                        <th class="p-3">Statut</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tickets as $ticket)
                        <tr class="border-t">
                            <td class="p-3">{{ $ticket->id }}</td>
                            <td class="p-3">{{ $ticket->numero_ticket }}</td>
                            <td class="p-3">{{ $ticket->service->nom ?? '-' }}</td>
                            <td class="p-3">{{ $ticket->priorite ? 'Urgent' : 'Normal' }}</td>
                            <td class="p-3">{{ $ticket->statut }}</td>
                            <td class="p-3 space-x-2">
                                <form method="POST" action="{{ route('tickets.call', $ticket) }}" class="inline">
                                    @csrf
                                    <button class="text-sm px-2 py-1 bg-yellow-100 rounded">Appeler</button>
                                </form>

                                <form method="POST" action="{{ route('tickets.start', $ticket) }}" class="inline">
                                    @csrf
                                    <button class="text-sm px-2 py-1 bg-blue-100 rounded">Commencer</button>
                                </form>

                                <form method="POST" action="{{ route('tickets.finish', $ticket) }}" class="inline">
                                    @csrf
                                    <button class="text-sm px-2 py-1 bg-green-100 rounded">Terminer</button>
                                </form>

                                <a class="text-sm text-indigo-600" href="{{ route('tickets.show', $ticket) }}">Détails</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $tickets->links() }}</div>
    </div>
</div>
@endsection
