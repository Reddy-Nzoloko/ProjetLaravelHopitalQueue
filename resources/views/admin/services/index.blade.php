<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Services</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Services par Établissement</h1>
            <a href="{{ route('services.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                + Nouveau Service
            </a>
        </div>

        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600">Service</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600">Préfixe</th>
                        <th class="px-6 py-3 text-sm font-semibold text-gray-600">Hôpital Parent</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($services as $service)
                    <tr>
                        <td class="px-6 py-4 text-gray-900 font-medium">{{ $service->nom }}</td>
                        <td class="px-6 py-4"><span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-bold">{{ $service->prefixe }}</span></td>
                        <td class="px-6 py-4 text-gray-600">{{ $service->hopital->nom }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-10 text-center text-gray-500">Aucun service créé pour le moment.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
