<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Guichets</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Gestion des Guichets</h1>
            <div class="space-x-2">
                <a href="{{ route('guichets.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700 transition">
                    + Nouveau Guichet
                </a>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-200">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600">Guichet</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600">Hôpital</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600">Service</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600">Ouvert</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($guichets as $guichet)
                    <tr>
                        <td class="px-6 py-4 text-gray-900 font-medium">{{ $guichet->nom }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $guichet->hopital?->nom }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $guichet->service?->nom ?? '—' }}</td>
                        <td class="px-6 py-4">
                            @if($guichet->est_ouvert)
                                <span class="text-green-600 font-bold">Oui</span>
                            @else
                                <span class="text-red-600 font-bold">Non</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">Aucun guichet créé pour le moment.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>