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
        <p class="mb-10 text-gray-400">Veuillez choisir votre service pour obtenir un ticket</p>

        @if(session('success_ticket'))
            <div class="bg-green-500 p-8 rounded-2xl mb-10 animate-bounce">
                <h2 class="text-2xl font-bold">VOTRE NUMÉRO :</h2>
                <span class="text-6xl font-black">{{ session('success_ticket') }}</span>
                <p class="mt-4">Veuillez patienter, on va vous appeler.</p>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-4">
            @foreach($services as $service)
                <form action="{{ route('ticket.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="service_id" value="{{ $service->id }}">
                    <button type="submit"
                        class="w-full bg-white text-slate-900 py-6 rounded-2xl text-2xl font-bold hover:bg-blue-500 hover:text-white transition-all transform active:scale-95 shadow-lg">
                        {{ $service->nom }}
                    </button>
                </form>
            @endforeach
        </div>
    </div>

</body>
</html>
