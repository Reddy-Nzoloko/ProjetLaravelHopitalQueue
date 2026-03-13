<x-app-layout>
    <div class="flex min-h-screen bg-gray-100">

        {{-- SIDEBAR --}}
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

                @if(auth()->user()->role === 'medecin')
                <a href="{{ route('services.index') }}" class="block py-2 px-4 rounded hover:bg-gray-800">
                    💼 Mon service
                </a>

                <a href="{{ route('guichets.index') }}" class="block py-2 px-4 rounded hover:bg-gray-800">
                    🏪 Mes guichets
                </a>

                <a href="#" class="block py-2 px-4 rounded hover:bg-gray-800">
                    🎟️ Mes tickets
                </a>
                @else
                <a href="{{ route('services.index') }}" class="block py-2 px-4 rounded hover:bg-gray-800">
                    💼 Services
                </a>

                <a href="{{ route('guichets.index') }}" class="block py-2 px-4 rounded hover:bg-gray-800">
                    🏪 Guichets
                </a>

                <a href="#" class="block py-2 px-4 rounded hover:bg-gray-800">
                    🎟️ Tickets
                </a>
                @endif


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

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-800">Se déconnecter</button>
                    </form>
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
                    @if(auth()->user()->role === 'medecin' && auth()->user()->service)
                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition col-span-full">
                        <h3 class="text-gray-500 text-sm">Mon Service</h3>
                        <p class="text-xl font-bold text-green-600">{{ auth()->user()->service->nom }}</p>
                    </div>
                    @endif

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

                    @if(auth()->user()->role === 'medecin')
                    @if($guichet)
                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition col-span-full">
                        <h3 class="text-gray-500 text-sm">Mon Guichet</h3>
                        <p class="text-xl font-bold {{ $guichet->est_ouvert ? 'text-green-600' : 'text-red-600' }}">
                            {{ $guichet->nom }} - {{ $guichet->est_ouvert ? 'Ouvert' : 'Fermé' }}
                        </p>
                        <p class="text-sm text-gray-600">Personnes en attente: {{ $tickets_en_attente }}</p>
                        @if($guichet->est_ouvert)
                        <form method="POST" action="{{ route('guichets.update', $guichet) }}" class="mt-2">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="est_ouvert" value="0">
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Fermer le guichet</button>
                        </form>
                        @else
                        <form method="POST" action="{{ route('guichets.update', $guichet) }}" class="mt-2">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="est_ouvert" value="1">
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Ouvrir le guichet</button>
                        </form>
                        @endif
                    </div>
                    @else
                    <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition col-span-full">
                        <h3 class="text-gray-500 text-sm">Mon Guichet</h3>
                        <p class="text-lg text-gray-600">Aucun guichet créé pour votre service.</p>
                        <a href="{{ route('guichets.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 inline-block mt-2">Créer un guichet</a>
                    </div>
                    @endif
                    @endif
                </div>
                <!-- gestion de utilisateur -->
                {{-- SECTION AGENTS/UTILISATEURS --}}
                @if(auth()->user()->role === 'admin_global')
                <div class="bg-white p-6 rounded-xl shadow mt-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-700">
                            Gestion des Utilisateurs & Admins
                        </h2>

                        <a href="{{ route('hopitaux.index') }}"
                            class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                            🏥 Gérer les Hôpitaux
                        </a>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <a href="{{ route('hopitaux.index') }}" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                            🏥 Gérer les Hôpitaux
                        </a>
                        <a href="#" class="p-4 border rounded-lg hover:bg-gray-50 transition flex items-center">
                            🔐 Gérer les rôles et permissions
                        </a>
                    </div>
                </div>
                @elseif(auth()->user()->role === 'admin_hopital')
                <div class="bg-white p-6 rounded-xl shadow mt-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-700">
                            Gestion du personnel & Services
                        </h2>

                        <a href="{{ route('register.medecin', auth()->user()->hopital) }}"
                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                            ➕ Ajouter un Médecin
                        </a>
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <a href="{{ route('register.medecin', auth()->user()->hopital) }}" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                            ➕ Ajouter un Médecin
                        </a>
                        <a href="{{ route('services.create', ['hopital_id' => auth()->user()->hopital_id]) }}" class="p-4 border rounded-lg hover:bg-gray-50 transition flex items-center">
                            ➕ Ajouter un Service
                        </a>
                        <a href="{{ route('guichets.create') }}" class="p-4 border rounded-lg hover:bg-gray-50 transition flex items-center">
                            🎫 Ajouter un Guichet
                        </a>
                    </div>
                </div>
                @elseif(auth()->user()->role === 'medecin')
                <div class="bg-white p-6 rounded-xl shadow mt-8">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-bold text-gray-700">
                            Mes guichets
                        </h2>
                        <a href="{{ route('guichets.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
                            ➕ Créer un Guichet
                        </a>
                    </div>
                    <div class="p-4">
                        <a href="{{ route('guichets.index') }}" class="text-blue-600 hover:underline">
                            Liste des guichets de mon hôpital
                        </a>
                    </div>
                </div>
                @endif
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