<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Borne de Tickets</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white flex items-center justify-center min-h-screen">

    <div class="max-w-xl w-full p-6 text-center">
        {{-- retour sur la page service --}}
        <a href="{{ route('services.index') }}" class="absolute top-5 left-5 text-gray-500 hover:text-white text-xs">
            ← Quitter la borne
        </a>
        <h1 class="text-4xl font-black mb-8">BIENVENUE</h1>
        <p class="mb-10 text-gray-400">Veuillez renseigner vos informations et choisir un guichet ouvert.</p>

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-600 text-white rounded-lg text-left">
                <strong class="font-bold">Merci de corriger les erreurs suivantes :</strong>
                <ul class="mt-2 list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success_ticket'))
            <div class="bg-green-500 p-8 rounded-2xl mb-10 animate-bounce">
                <h2 class="text-2xl font-bold">VOTRE NUMÉRO :</h2>
                <span class="text-6xl font-black">{{ session('success_ticket') }}</span>
                <p class="mt-4">Veuillez patienter, on va vous appeler.</p>
            </div>
        @endif

        <form action="{{ route('ticket.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-left text-sm font-medium text-gray-200">Nom complet</label>
                    <input name="patient_nom" value="{{ old('patient_nom') }}" type="text" class="mt-1 w-full rounded-lg border-gray-300 text-slate-900" required>
                </div>
                <div>
                    <label class="block text-left text-sm font-medium text-gray-200">Téléphone</label>
                    <input name="patient_telephone" value="{{ old('patient_telephone') }}" type="text" class="mt-1 w-full rounded-lg border-gray-300 text-slate-900" required>
                </div>
                <div>
                    <label class="block text-left text-sm font-medium text-gray-200">Email</label>
                    <input name="patient_email" value="{{ old('patient_email') }}" type="email" class="mt-1 w-full rounded-lg border-gray-300 text-slate-900" required>
                </div>
                <div>
                    <label class="block text-left text-sm font-medium text-gray-200">Âge</label>
                    <input name="patient_age" value="{{ old('patient_age') }}" type="number" min="0" max="150" class="mt-1 w-full rounded-lg border-gray-300 text-slate-900" required>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-left text-sm font-medium text-gray-200">Sexe</label>
                    <select name="patient_sexe" class="mt-1 w-full rounded-lg border-gray-300 text-slate-900" required>
                        <option value="" disabled {{ old('patient_sexe') ? '' : 'selected' }}>Sélectionnez</option>
                        <option value="M" {{ old('patient_sexe') === 'M' ? 'selected' : '' }}>Homme</option>
                        <option value="F" {{ old('patient_sexe') === 'F' ? 'selected' : '' }}>Femme</option>
                        <option value="X" {{ old('patient_sexe') === 'X' ? 'selected' : '' }}>Autre</option>
                    </select>
                </div>
            </div>

            @if(!empty($guichets) && $guichets->count())
                <div class="text-left">
                    <p class="mb-4 text-gray-400">Choisissez le guichet où vous vous trouvez&nbsp;:</p>
                    <div class="space-y-2">
                        @foreach($guichets as $guichet)
                            <label class="flex items-center gap-3 p-3 border rounded-lg bg-white/10 hover:bg-white/20 cursor-pointer">
                                <input type="radio" name="guichet_id" value="{{ $guichet->id }}" class="h-4 w-4" {{ old('guichet_id') == $guichet->id ? 'checked' : ($loop->first && !old('guichet_id') ? 'checked' : '') }}>
                                <span class="text-left">
                                    <strong class="text-white">{{ $guichet->nom }}</strong>
                                    @if($guichet->service)
                                        <span class="text-gray-300">({{ $guichet->service->nom }})</span>
                                    @endif
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-left">
                    <p class="mb-4 text-gray-400">Choisissez un service :</p>
                    <div class="space-y-2">
                        @foreach($services as $service)
                            <label class="flex items-center gap-3 p-3 border rounded-lg bg-white/10 hover:bg-white/20 cursor-pointer">
                                <input type="radio" name="service_id" value="{{ $service->id }}" class="h-4 w-4" {{ old('service_id') == $service->id ? 'checked' : ($loop->first && !old('service_id') ? 'checked' : '') }}>
                                <span class="text-left">
                                    <strong class="text-white">{{ $service->nom }}</strong>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            <button type="submit" class="w-full bg-white text-slate-900 py-4 rounded-2xl text-2xl font-bold hover:bg-blue-500 hover:text-white transition-all transform active:scale-95 shadow-lg">
                Obtenir mon ticket
            </button>
        </form>
    </div>

</body>
</html>
