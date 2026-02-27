<x-guest-layout>
    <div class="min-h-screen bg-slate-900 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="text-center text-3xl font-extrabold text-white">Créer un Agent</h2>
            <p class="mt-2 text-center text-sm text-slate-400">Attribuer un administrateur à un hôpital</p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-slate-800 py-8 px-4 shadow-2xl sm:rounded-2xl sm:px-10 border border-slate-700">
                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Nom complet')" class="text-slate-300" />
                        <x-text-input id="name" class="block mt-1 w-full bg-slate-900 border-slate-700 text-white focus:border-emerald-500 focus:ring-emerald-500" type="text" name="name" :value="old('name')" required autofocus />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email Professionnel')" class="text-slate-300" />
                        <x-text-input id="email" class="block mt-1 w-full bg-slate-900 border-slate-700 text-white focus:border-emerald-500 focus:ring-emerald-500" type="email" name="email" :value="old('email')" required />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="role" :value="__('Rôle de l\'agent')" class="text-slate-300" />
                        <select name="role" id="role" class="block mt-1 w-full bg-slate-900 border-slate-700 text-white rounded-md shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="admin_hopital">Administrateur d'Hôpital</option>
                            <option value="medecin">Médecin / Praticien</option>
                            <option value="admin_global">Super Administrateur</option>
                        </select>
                    </div>

                    <div class="mt-4" id="hopital_selection">
                        <x-input-label for="hopital_id" :value="__('Affectation Hôpital')" class="text-slate-300" />
                        <select name="hopital_id" id="hopital_id" class="block mt-1 w-full bg-slate-900 border-slate-700 text-white rounded-md shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="">-- Sélectionner l'établissement --</option>
                            @foreach($hopitaux as $hopital)
                                <option value="{{ $hopital->id }}">{{ $hopital->nom }} ({{ $hopital->code_unique }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Mot de passe temporaire')" class="text-slate-300" />
                        <x-text-input id="password" class="block mt-1 w-full bg-slate-900 border-slate-700 text-white" type="password" name="password" required />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirmer mot de passe')" class="text-slate-300" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full bg-slate-900 border-slate-700 text-white" type="password" name="password_confirmation" required />
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <x-primary-button class="w-full justify-center bg-emerald-600 hover:bg-emerald-700 text-white py-3 rounded-xl transition font-bold shadow-lg shadow-emerald-900/20">
                            {{ __('Créer le compte Agent') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>