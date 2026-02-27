<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Hôpitaux</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-blue-50 min-h-screen p-8">

    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8 gap-4">
            <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">Système Multi-Hôpitaux</h1>
            <a href="{{ route('hopitaux.create') }}"
               class="bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg hover:bg-green-600 transition font-semibold flex items-center gap-2">
               + Ajouter un hôpital 
               <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
               </svg>
            </a>
        </div>
        <!-- Navigation dans l'application -->
        <div class="mb-6">
            <a href="{{ route('dashboard') }}" class="text-blue-600 font-semibold hover:text-blue-800 transition duration-200 flex items-center gap-1">
                ← Tableau de bord
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-300 text-green-800 px-5 py-3 rounded-xl mb-6 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Table Card -->
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">
            <table class="w-full text-left min-w-[700px]">
                <thead class="bg-gray-50 text-gray-600 uppercase text-sm font-bold tracking-wider border-b">
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
                    <tr class="hover:bg-blue-50 transition duration-200">
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $hopital->nom }}</td>
                        <td class="px-6 py-4">
                            <span class="text-blue-700 font-mono bg-blue-100 px-2 py-1 rounded-full text-sm border border-blue-200">
                                {{ $hopital->code_unique }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-3 py-1 rounded-full border border-gray-300">
                                {{ $hopital->services->count() }} service(s)
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600 text-sm italic">{{ Str::limit($hopital->adresse, 35) }}</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex gap-2 justify-end">
                                <a href="{{ route('services.create', ['hopital_id' => $hopital->id]) }}"
                                   class="inline-flex items-center text-sm bg-indigo-500 text-white px-4 py-2 rounded-xl hover:bg-indigo-600 font-semibold shadow-sm transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Service
                                </a>
                                <a href="{{ route('register.admin', $hopital) }}"
                                   class="inline-flex items-center text-sm bg-purple-500 text-white px-4 py-2 rounded-xl hover:bg-purple-600 font-semibold shadow-sm transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Admin
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>