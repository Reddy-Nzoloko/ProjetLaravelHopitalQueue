<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un Guichet</title>
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

                <form method="POST" action="{{ route('logout') }}" class="mt-6 px-4">
                    @csrf
                    <button type="submit" class="w-full text-left py-2 px-4 rounded hover:bg-gray-800">🚪 Se déconnecter</button>
                </form>
            </nav>
        </aside>

        {{-- CONTENU --}}
        <div class="flex-1 p-10">
            <div class="max-w-3xl mx-auto">
                <div class="mb-4">
                    <a href="{{ route('guichets.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold flex items-center">
                        ← Retour à la liste des guichets
                    </a>
                </div>

                <h1 class="text-3xl font-bold text-gray-800 mb-6">Nouveau Guichet</h1>

                <form action="{{ route('guichets.store') }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            @if(auth()->user()->role === 'admin_global')
                <div class="mb-4">
                    <label class="block text-gray-700">Hôpital parent</label>
                    <select name="hopital_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- choisir --</option>
                        @foreach($hopitaux as $hopital)
                            <option value="{{ $hopital->id }}" {{ old('hopital_id') == $hopital->id ? 'selected' : '' }}>{{ $hopital->nom }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Service (facultatif)</label>
                    <select name="service_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- aucun --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->nom }}</option>
                        @endforeach
                    </select>
                </div>
            @else
                <!-- for admin_hopital or medecin we already know hopital_id -->
                @if(auth()->user()->role === 'medecin')
                <div class="mb-4">
                    <label class="block text-gray-700">Service</label>
                    <p class="text-gray-600">{{ $services->first()->nom ?? 'Aucun service' }}</p>
                </div>
                @else
                <div class="mb-4">
                    <label class="block text-gray-700">Service (facultatif)</label>
                    <select name="service_id" class="w-full border rounded px-3 py-2">
                        <option value="">-- aucun --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->nom }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
            @endif

            <div class="mb-4">
                <label class="block text-gray-700">Nom du guichet</label>
                <input type="text" name="nom" value="{{ old('nom') }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="est_ouvert" value="1" {{ old('est_ouvert') ? 'checked' : '' }} class="form-checkbox">
                    <span class="ml-2">Guichet ouvert</span>
                </label>
            </div>

            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Créer le guichet</button>
        </form>
            </div>
        </div>
    </div>
</body>
</html>