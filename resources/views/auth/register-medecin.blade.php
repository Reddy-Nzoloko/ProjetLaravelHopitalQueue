<x-guest-layout>
    <div class="min-h-screen bg-slate-900 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="text-center text-3xl font-extrabold text-white">Ajouter un Médecin</h2>
            <p class="mt-2 text-center text-sm text-slate-400">Hôpital : {{ $hopital->nom }}</p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-slate-800 py-8 px-4 shadow-2xl sm:rounded-2xl sm:px-10 border border-slate-700">
                <form method="POST" action="{{ route('register.medecin.store', $hopital) }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Nom complet')" class="text-slate-300" />
                        <x-text-input id="name" class="block mt-1 w-full bg-slate-900 border-slate-700 text-white focus:border-emerald-500 focus:ring-emerald-500" type="text" name="name" :value="old('name')" required autofocus />
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-input-label for="email" :value="__('Email Professionnel')" class="text-slate-300" />
                        <x-text-input id="email" class="block mt-1 w-full bg-slate-900 border-slate-700 text-white focus:border-emerald-500 focus:ring-emerald-500" type="email" name="email" :value="old('email')" required />
                        @error('email')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-input-label for="service_id" :value="__('Service')" class="text-slate-300" />
                        <select name="service_id" id="service_id" required
                            class="block mt-1 w-full bg-slate-900 border-slate-700 text-white rounded-md shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="">-- Sélectionner un service --</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->nom }}</option>
                            @endforeach
                        </select>
                        @error('service_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Mot de passe')" class="text-slate-300" />
                        <x-text-input id="password" class="block mt-1 w-full bg-slate-900 border-slate-700 text-white focus:border-emerald-500 focus:ring-emerald-500" type="password" name="password" required />
                        @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="text-slate-300" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full bg-slate-900 border-slate-700 text-white focus:border-emerald-500 focus:ring-emerald-500" type="password" name="password_confirmation" required />
                        @error('password_confirmation')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between gap-4 mt-6">
                        <a href="{{ route('dashboard') }}" class="text-slate-400 hover:text-slate-300 transition">
                            ← Retour
                        </a>
                        <x-primary-button class="bg-emerald-600 hover:bg-emerald-700 text-white py-2 px-6 rounded-xl transition font-bold shadow-lg shadow-emerald-900/20">
                            {{ __('Créer le compte Médecin') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
