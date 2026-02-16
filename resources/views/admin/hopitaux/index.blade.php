<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Hôpitaux</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold">Système Multi-Hôpitaux</h1>
            <a href="{{ route('hopitaux.create') }}" class="bg-green-500 text-white px-4 py-2 rounded shadow hover:bg-green-600">
                + Ajouter un hôpital
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-200 text-gray-700 uppercase text-sm">
                    <tr>
                        <th class="px-6 py-3">Nom</th>
                        <th class="px-6 py-3">Code Unique</th>
                        <th class="px-6 py-3">Adresse</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($hopitaux as $hopital)
                    <tr>
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $hopital->nom }}</td>
                        <td class="px-6 py-4 text-blue-600 font-mono">{{ $hopital->code_unique }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $hopital->adresse }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
