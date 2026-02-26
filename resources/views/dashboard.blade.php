<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">

        {{-- SIDEBAR --}}
        <h1 style="color:red">TEST MODIFICATION</h1>
        <aside class="w-64 bg-gray-900 text-white hidden md:block">
            <div class="p-6 text-2xl font-bold border-b border-gray-700">
                🏥 Hospital Queue
            </div>

            <nav class="mt-6 space-y-2 px-4">
                <a href="#" class="block py-2 px-4 rounded bg-gray-800">
                    📊 Dashboard
                </a>

                @if(auth()->user()->role === 'admin_global')
                <a href="{{ route('hopitaux.index') }}" class="block py-2 px-4 rounded hover:bg-gray-800">
                    🏥 Hôpitaux
                </a>
                @endif

                <a href="{{ route('services.index') }}" class="block py-2 px-4 rounded hover:bg-gray-800">
                    💼 Services
                </a>

                <a href="#" class="block py-2 px-4 rounded hover:bg-gray-800">
                    🎟️ Tickets
                </a>

                <a href="#" class="block py-2 px-4 rounded hover:bg-gray-800">
                    👥 Utilisateurs
                </a>
            </nav>
        </aside>

        {{-- CONTENU --}}
        <div class="flex-1">

            {{-- TOPBAR --}}
            <header class="bg-white shadow p-4 flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-700">
                    Tableau de Bord
                </h1>

                <div class="flex items-center space-x-4">
                    <span class="text-gray-600">
                        👋 {{ auth()->user()->name }}
                    </span>

                    <span class="px-3 py-1 bg-blue-100 text-blue-600 rounded-full text-sm">
                        {{ auth()->user()->role }}
                    </span>
                </div>
            </header>

            {{-- STATS --}}
            <div class="p-6">

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="text-gray-500 text-sm">Hôpitaux</h3>
                        <p class="text-3xl font-bold text-blue-600">
                            {{ $stats['total_hopitaux'] ?? 0 }}
                        </p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="text-gray-500 text-sm">Services</h3>
                        <p class="text-3xl font-bold text-green-600">
                            {{ $stats['total_services'] ?? 0 }}
                        </p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="text-gray-500 text-sm">Utilisateurs</h3>
                        <p class="text-3xl font-bold text-purple-600">
                            {{ $stats['total_users'] ?? 0 }}
                        </p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition">
                        <h3 class="text-gray-500 text-sm">Tickets</h3>
                        <p class="text-3xl font-bold text-red-600">
                            {{ $stats['total_tickets'] ?? 0 }}
                        </p>
                    </div>
                </div>

                {{-- SECTION HOPITAUX --}}
                @if(auth()->user()->role === 'admin_global')
                <div class="bg-white p-6 rounded-xl shadow">

                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-700">
                            Gestion des Hôpitaux
                        </h2>

                        <a href="{{ route('hopitaux.create') }}"
                           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                            ➕ Ajouter un Hôpital
                        </a>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">

                        <a href="{{ route('hopitaux.index') }}"
                           class="p-4 border rounded-lg hover:bg-gray-50 transition">
                            📋 Voir tous les hôpitaux
                        </a>

                        <a href="#"
                           class="p-4 border rounded-lg hover:bg-gray-50 transition">
                            📊 Statistiques par hôpital
                        </a>

                        <a href="#"
                           class="p-4 border rounded-lg hover:bg-gray-50 transition">
                            ⚙️ Paramètres globaux
                        </a>

                        <a href="#"
                           class="p-4 border rounded-lg hover:bg-gray-50 transition">
                            🗂️ Export des données
                        </a>

                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>