<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du Service</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-4xl mx-auto">
        <div class="mb-4">
            <a href="{{ route('services.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold flex items-center">
                ← Retour à la liste des services
            </a>
        </div>

        <div class="bg-white p-8 rounded-lg shadow-md">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Service : {{ $service->nom }}</h1>
            <p class="text-gray-600 mb-6">Hôpital : {{ $service->hopital->nom }}</p>

            <h2 class="text-xl font-semibold text-gray-700 mb-2">Médecins rattachés</h2>
            @if($medecins->isEmpty())
                <p class="text-gray-500">Aucun médecin assigné à ce service.</p>
            @else
                <ul class="list-disc list-inside">
                    @foreach($medecins as $medecin)
                        <li class="text-gray-800">{{ $medecin->name }} ({{ $medecin->email }})</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</body>
</html>
