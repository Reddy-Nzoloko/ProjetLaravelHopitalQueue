@extends('layouts.app')

@section('content')
<h2 class="text-xl font-semibold mb-4">Guichets</h2>

<div class="grid gap-4 md:grid-cols-2">
    @foreach(\App\Models\Guichet::all() as $guichet)
        <div class="p-4 bg-white shadow rounded flex items-center justify-between">
            <div>
                <div class="font-semibold">{{ $guichet->nom }}</div>
                <div class="text-sm text-gray-500">{{ $guichet->est_ouvert ? 'Ouvert' : 'Fermé' }}</div>
            </div>
            <div class="space-x-2">
                @if($guichet->est_ouvert)
                    <form method="POST" action="{{ route('guichets.close', $guichet) }}">@csrf<button class="px-3 py-1 bg-red-100 rounded">Fermer</button></form>
                @else
                    <form method="POST" action="{{ route('guichets.open', $guichet) }}">@csrf<button class="px-3 py-1 bg-green-100 rounded">Ouvrir</button></form>
                @endif
            </div>
        </div>
    @endforeach
</div>
@endsection