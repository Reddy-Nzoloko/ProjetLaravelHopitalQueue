@extends('layouts.app')

@section('content')
    <div class="bg-white shadow rounded p-4">
        <h3 class="text-lg font-semibold mb-2">{{ $ticket->numero_ticket }} — {{ $ticket->service->nom ?? '' }}</h3>
        <div class="text-sm text-gray-600 mb-4">Statut : <strong>{{ $ticket->statut }}</strong></div>

        @if($ticket->consultation)
            <div class="p-3 bg-gray-50 rounded">
                <h4 class="font-semibold">Consultation</h4>
                <div class="mt-2 text-sm">{{ $ticket->consultation->diagnostic ?? '—' }}</div>
            </div>
        @else
            <form method="POST" action="{{ route('consultations.store') }}" class="mt-4">
                @csrf
                <input type="hidden" name="ticket_id" value="{{ $ticket->id }}">
                <label class="block text-sm text-gray-600">Symptômes</label>
                <textarea name="symptomes" class="w-full border p-2 rounded mb-2" rows="3"></textarea>

                <label class="block text-sm text-gray-600">Diagnostic</label>
                <textarea name="diagnostic" class="w-full border p-2 rounded mb-2" rows="3"></textarea>

                <label class="block text-sm text-gray-600">Ordonnance</label>
                <textarea name="ordonnance" class="w-full border p-2 rounded mb-2" rows="2"></textarea>

                <button class="bg-indigo-600 text-white px-4 py-2 rounded">Enregistrer la consultation</button>
            </form>
        @endif
    </div>
@endsection
