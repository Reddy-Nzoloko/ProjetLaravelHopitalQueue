<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Services</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-5xl mx-auto">

        <div class="mb-4">
            <a href="{{ route('hopitaux.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold flex items-center">
                ← Retour à la liste des Hôpitaux
            </a>
        </div>

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Gestion des Services</h1>
            <div class="space-x-2">
                <a href="{{ route('services.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700 transition">
                    + Nouveau Service
                </a>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden border border-gray-200">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600">Service</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600">Préfixe</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600">Hôpital Parent</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600">Médecins</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($services as $service)
                    <tr>
                        <td class="px-6 py-4 text-gray-900 font-medium">
                            <a href="{{ route('services.show', $service) }}" class="hover:underline">
                                {{ $service->nom }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-bold uppercase">
                                {{ $service->prefixe }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600">{{ $service->hopital->nom }}</td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $service->medecins()->count() }} médecin(s)
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('ticket.borne', $service->hopital->id) }}"
                               target="_blank"
                               class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded hover:bg-green-200 font-bold">
                                Voir la Borne (Tickets)
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500">Aucun service créé pour le moment.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
