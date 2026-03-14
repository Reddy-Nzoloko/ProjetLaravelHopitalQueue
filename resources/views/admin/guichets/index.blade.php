<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Guichets</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        <aside class="w-64 bg-gray-900 text-white hidden md:block">
            <div class="p-6 text-2xl font-bold border-b border-gray-700">
                🏥 Hospital Queue
            </div>

            <nav class="mt-6 space-y-2 px-4">
                <a href="{{ route('dashboard') }}" class="block py-2 px-4 rounded hover:bg-gray-800">
                    📊 Dashboard
                </a>

                @if(auth()->user()->role === 'admin_global')
                <a href="{{ route('hopitaux.index') }}" class="block py-2 px-4 rounded hover:bg-gray-800">
                    🏥 Hôpitaux
                </a>
                @endif

                @if(auth()->user()->role === 'medecin')
                <a href="{{ route('services.index') }}" class="block py-2 px-4 rounded hover:bg-gray-800">
                    💼 Mon service
                </a>

                <a href="{{ route('guichets.index') }}" class="block py-2 px-4 rounded bg-gray-800">
                    🏪 Mes guichets
                </a>

                <a href="#" class="block py-2 px-4 rounded hover:bg-gray-800">
                    🎟️ Mes tickets
                </a>
                @else
                <a href="{{ route('services.index') }}" class="block py-2 px-4 rounded hover:bg-gray-800">
                    💼 Services
                </a>

                <a href="{{ route('guichets.index') }}" class="block py-2 px-4 rounded bg-gray-800">
                    🏪 Guichets
                </a>

                <a href="#" class="block py-2 px-4 rounded hover:bg-gray-800">
                    🎟️ Tickets
                </a>
                @endif

                <form method="POST" action="{{ route('logout') }}" class="mt-6 px-4">
                    @csrf
                    <button type="submit" class="w-full text-left py-2 px-4 rounded hover:bg-gray-800">🚪 Se déconnecter</button>
                </form>
            </nav>
        </aside>

        {{-- CONTENU --}}
        <div class="flex-1 p-10">
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
        </div>
    </div>
</body>
</html>