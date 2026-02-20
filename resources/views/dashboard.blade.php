<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tableau de Bord') }} -
                <span class="text-blue-600">
                    {{ auth()->user()->role == 'admin_global' ? 'Super Admin' : 'Admin Hôpital' }}
                </span>
            </h2>
            <div class="text-sm text-gray-500">
                Bienvenue, {{ auth()->user()->name }}
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

                @if(auth()->user()->role === 'admin_global')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-b-4 border-blue-500 p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-100 rounded-full text-blue-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase font-bold">Hôpitaux</p>
                            <p class="text-2xl font-black">{{ $stats['total_hopitaux'] }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-b-4 border-green-500 p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-100 rounded-full text-green-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase font-bold">Services</p>
                            <p class="text-2xl font-black">{{ $stats['total_services'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-b-4 border-purple-500 p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-100 rounded-full text-purple-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 005.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase font-bold">{{ auth()->user()->role == 'admin_global' ? 'Agents' : 'Médecins' }}</p>
                            <p class="text-2xl font-black">{{ auth()->user()->role == 'admin_global' ? $stats['total_users'] : $stats['total_medecins'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border-b-4 border-red-500 p-6">
                    <div class="flex items-center">
                        <div class="p-3 bg-red-100 rounded-full text-red-600 mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 uppercase font-bold">Tickets</p>
                            <p class="text-2xl font-black">{{ $stats['total_tickets'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="font-bold text-lg mb-4 text-gray-700">Gestion Système</h3>
                    <div class="space-y-3">
                        @if(auth()->user()->role === 'admin_global')
                            <a href="{{ route('hopitaux.create') }}" class="flex items-center p-3 bg-gray-50 rounded hover:bg-blue-50 transition border border-gray-200">
                                <span class="text-blue-600 mr-3">➕</span>
                                <span>Ajouter un nouvel hôpital</span>
                            </a>
                        @endif
                        <a href="{{ route('services.create') }}" class="flex items-center p-3 bg-gray-50 rounded hover:bg-green-50 transition border border-gray-200">
                            <span class="text-green-600 mr-3">💼</span>
                            <span>Créer un nouveau service</span>
                        </a>
                        <a href="{{ route('register') }}" class="flex items-center p-3 bg-gray-50 rounded hover:bg-purple-50 transition border border-gray-200">
                            <span class="text-purple-600 mr-3">👤</span>
                            <span>Enregistrer un nouvel agent</span>
                        </a>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm">
                    <h3 class="font-bold text-lg mb-4 text-gray-700">Aperçu Récent</h3>
                    <div class="text-sm text-gray-500 italic">
                        @if(auth()->user()->role === 'admin_global')
                            Derniers hôpitaux enregistrés s'afficheront ici.
                        @else
                            Dernière activité de l'hôpital.
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
