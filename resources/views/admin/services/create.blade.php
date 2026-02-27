<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un Service</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Ajouter un Nouveau Service
        </h1>

        {{-- afficher le contexte de l'hôpital si connu --}}
        @if($selectedHopitalId)
            @php
                $current = $hopitaux->firstWhere('id', $selectedHopitalId);
            @endphp
            <div class="mb-6">
                <p class="text-lg font-medium text-gray-700">
                    Hôpital sélectionné : 
                    <span class="font-semibold text-blue-600">{{ $current?->nom ?? 'N/A' }}</span>
                </p>
            </div>
        @endif

        <form action="{{ route('services.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Rattacher à l'Hôpital</label>
                <select name="hopital_id" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" @if($selectedHopitalId) disabled @endif>
                    <option value="">-- Sélectionnez un établissement --</option>
                    @foreach($hopitaux as $hopital)
                        <option value="{{ $hopital->id }}"
                            @if($selectedHopitalId && $selectedHopitalId == $hopital->id) selected @endif>
                            {{ $hopital->nom }}
                        </option>
                    @endforeach
                </select>
                @if($selectedHopitalId)
                    <input type="hidden" name="hopital_id" value="{{ $selectedHopitalId }}">
                @endif
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nom du Service (ex : Pédiatrie)</label>
                <input type="text" name="nom" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" placeholder="E.g. Pédiatrie, Urgences" />
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Préfixe du Ticket (3 à 4 lettres)</label>
                <input type="text" name="prefixe" placeholder="Ex : PED, URG, CARD" maxlength="5" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 uppercase">
                <p class="text-xs text-gray-500 mt-1">Ce préfixe apparaîtra sur le ticket (ex : PED‑001).</p>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-md hover:bg-indigo-700 transition">
                Créer le Service
            </button>
        </form>
    </div>
</body>
</html>
