<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Hôpitaux</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-5xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Système Multi-Hôpitaux</h1>
            <a href="{{ route('hopitaux.create') }}" class="bg-green-600 text-white px-5 py-2 rounded-lg shadow hover:bg-green-700 transition font-semibold">
                + Ajouter un hôpital
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-xl rounded-xl overflow-hidden border border-gray-200">
            <table class="w-full text-left">
                <thead class="bg-gray-50 text-gray-600 uppercase text-xs font-bold tracking-wider border-b">
                    <tr>
                        <th class="px-6 py-4">Nom de l'établissement</th>
                        <th class="px-6 py-4">Code Unique</th>
                        <th class="px-6 py-4 text-center">Services</th>
                        <th class="px-6 py-4">Adresse</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($hopitaux as $hopital)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 font-bold text-gray-900">{{ $hopital->nom }}</td>
                        <td class="px-6 py-4">
                            <span class="text-blue-600 font-mono bg-blue-50 px-2 py-1 rounded text-sm border border-blue-100">
                                {{ $hopital->code_unique }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded-full border border-gray-300">
                                {{ $hopital->services->count() }} service(s)
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600 text-sm italic">{{ Str::limit($hopital->adresse, 30) }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('services.create', ['hopital_id' => $hopital->id]) }}"
                               class="inline-flex items-center text-xs bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 font-bold transition shadow-sm">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                                Ajouter Service
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
