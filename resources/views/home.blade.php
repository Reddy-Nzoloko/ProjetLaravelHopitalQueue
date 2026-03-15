<!DOCTYPE html>
<html>
<head>
    <title>Hospital Queue System</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

    <div class="min-h-screen flex flex-col items-center justify-center px-4">
        <div class="max-w-2xl w-full">
            <h1 class="text-4xl font-bold text-blue-600 mb-4 text-center">
                Bienvenue au Hospital Queue System
            </h1>

            <p class="mb-6 text-gray-600 text-center">
                Gérez les files d'attente des patients facilement.
            </p>

            <div class="flex justify-center gap-4 mb-6">
                <a href="{{ route('home', ['mode' => 'login']) }}" class="px-6 py-2 rounded font-semibold whitespace-nowrap {{ request('mode') !== 'register' ? 'bg-blue-600 text-white' : 'bg-white text-slate-700 border border-slate-300' }}">
                    Se connecter
                </a>
                <a href="{{ route('home', ['mode' => 'register']) }}" class="px-6 py-2 rounded font-semibold whitespace-nowrap {{ request('mode') === 'register' ? 'bg-green-600 text-white' : 'bg-white text-slate-700 border border-slate-300' }}">
                    S'inscrire
                </a>
            </div>

            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-slate-200">
                <div class="p-6">
                    @if(auth('patient')->check())
                        <div class="text-center">
                            <p class="text-lg font-semibold">Vous êtes connecté en tant que : {{ auth('patient')->user()->name }}</p>
                            <p class="text-sm text-slate-600 mt-2">Hôpital : {{ auth('patient')->user()->hopital->nom ?? '–' }}</p>
                            <p class="text-sm text-slate-600">Service : {{ auth('patient')->user()->service->nom ?? '–' }}</p>
                            <p class="text-sm text-slate-600">Guichet : {{ auth('patient')->user()->guichet->nom ?? '–' }}</p>

                            <div class="mt-6 flex justify-center gap-3">
                                <a href="{{ route('patient.dashboard') }}" class="px-6 py-2 bg-blue-600 text-white rounded">Mon espace</a>
                                <form method="POST" action="{{ route('patient.logout') }}">
                                    @csrf
                                    <button type="submit" class="px-6 py-2 bg-slate-700 text-white rounded">Déconnexion</button>
                                </form>
                            </div>
                        </div>
                    @else
                        @if(request('mode') === 'register')
                            <h2 class="text-2xl font-bold text-slate-800 mb-4 text-center">Inscription Patient</h2>
                            <form method="POST" action="{{ route('patient.register') }}" class="space-y-4">
                                @csrf

                                <div>
                                    <label for="name" class="block text-sm font-medium text-slate-700">Nom complet</label>
                                    <input id="name" name="name" value="{{ old('name') }}" type="text" required class="mt-1 block w-full rounded-md border border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                                    @error('name')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                                    <input id="email" name="email" value="{{ old('email') }}" type="email" required class="mt-1 block w-full rounded-md border border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                                    @error('email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-slate-700">Téléphone (optionnel)</label>
                                    <input id="phone" name="phone" value="{{ old('phone') }}" type="text" class="mt-1 block w-full rounded-md border border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                                    @error('phone')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="hopital_id" class="block text-sm font-medium text-slate-700">Hôpital</label>
                                    <select id="hopital_id" name="hopital_id" required class="mt-1 block w-full rounded-md border border-slate-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">-- Choisir un hôpital --</option>
                                        @foreach($hopitaux as $hopital)
                                            <option value="{{ $hopital->id }}" {{ old('hopital_id') == $hopital->id ? 'selected' : '' }}>{{ $hopital->nom }}</option>
                                        @endforeach
                                    </select>
                                    @error('hopital_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="service_id" class="block text-sm font-medium text-slate-700">Service</label>
                                    <select id="service_id" name="service_id" required class="mt-1 block w-full rounded-md border border-slate-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">-- Choisir un service --</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}" data-hopital="{{ $service->hopital_id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->nom }}</option>
                                        @endforeach
                                    </select>
                                    @error('service_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="guichet_id" class="block text-sm font-medium text-slate-700">Guichet</label>
                                    <select id="guichet_id" name="guichet_id" required class="mt-1 block w-full rounded-md border border-slate-300 bg-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">-- Choisir un guichet --</option>
                                        @foreach($guichets as $guichet)
                                            <option value="{{ $guichet->id }}" data-hopital="{{ $guichet->hopital_id }}" data-service="{{ $guichet->service_id }}" {{ old('guichet_id') == $guichet->id ? 'selected' : '' }}>{{ $guichet->nom }}</option>
                                        @endforeach
                                    </select>
                                    @error('guichet_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="password" class="block text-sm font-medium text-slate-700">Mot de passe</label>
                                        <input id="password" name="password" type="password" required class="mt-1 block w-full rounded-md border border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                                        @error('password')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                    </div>

                                    <div>
                                        <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirmation</label>
                                        <input id="password_confirmation" name="password_confirmation" type="password" required class="mt-1 block w-full rounded-md border border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <button type="submit" class="w-full px-6 py-3 bg-green-600 text-white rounded-xl font-semibold hover:bg-green-700">
                                        Créer mon compte patient
                                    </button>
                                </div>
                            </form>
                        @else
                            <h2 class="text-2xl font-bold text-slate-800 mb-4 text-center">Connexion Patient</h2>
                            <form method="POST" action="{{ route('patient.login') }}" class="space-y-4">
                                @csrf
                                <div>
                                    <label for="email" class="block text-sm font-medium text-slate-700">Email</label>
                                    <input id="email" name="email" value="{{ old('email') }}" type="email" required class="mt-1 block w-full rounded-md border border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                                    @error('email')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-slate-700">Mot de passe</label>
                                    <input id="password" name="password" type="password" required class="mt-1 block w-full rounded-md border border-slate-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                                    @error('password')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                                </div>

                                <div class="flex items-center justify-between">
                                    <label class="inline-flex items-center gap-2 text-sm text-slate-600">
                                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500" />
                                        Se souvenir de moi
                                    </label>

                                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                                        Mot de passe oublié ?
                                    </a>
                                </div>

                                <div class="mt-6">
                                    <button type="submit" class="w-full px-6 py-3 bg-blue-600 text-white rounded-xl font-semibold hover:bg-blue-700">
                                        Se connecter
                                    </button>
                                </div>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function filterOptions() {
            const hopitalSelect = document.getElementById('hopital_id');
            const serviceSelect = document.getElementById('service_id');
            const guichetSelect = document.getElementById('guichet_id');
            const selectedHopital = hopitalSelect?.value;
            const selectedService = serviceSelect?.value;

            if (serviceSelect) {
                Array.from(serviceSelect.options).forEach(opt => {
                    if (!opt.value) return;
                    const matches = !selectedHopital || opt.dataset.hopital === selectedHopital;
                    opt.hidden = !matches;
                });
                // Reset service if it doesn't match
                if (serviceSelect.value && serviceSelect.selectedOptions[0].hidden) {
                    serviceSelect.value = '';
                }
            }

            if (guichetSelect) {
                Array.from(guichetSelect.options).forEach(opt => {
                    if (!opt.value) return;
                    const matchesHopital = !selectedHopital || opt.dataset.hopital === selectedHopital;
                    const matchesService = !selectedService || opt.dataset.service === selectedService;
                    opt.hidden = !(matchesHopital && matchesService);
                });
                // Reset guichet if it doesn't match
                if (guichetSelect.value && guichetSelect.selectedOptions[0].hidden) {
                    guichetSelect.value = '';
                }
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const hopitalSelect = document.getElementById('hopital_id');
            const serviceSelect = document.getElementById('service_id');
            if (hopitalSelect) {
                hopitalSelect.addEventListener('change', filterOptions);
            }
            if (serviceSelect) {
                serviceSelect.addEventListener('change', filterOptions);
            }
            filterOptions();
        });
    </script>
</body>
</html>
