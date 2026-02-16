<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Prendre un Ticket</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg w-96 text-center">
        <h1 class="text-2xl font-bold mb-6 text-blue-600">Bienvenue à l'Hôpital</h1>
        <p class="mb-4 text-gray-600">Choisissez votre service :</p>

        <form action="{{ route('ticket.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                @foreach($services as $service)
                    <button type="submit" name="service_id" value="{{ $service->id }}"
                        class="w-full bg-blue-500 text-white py-3 rounded-md hover:bg-blue-700 transition">
                        {{ $service->nom }} ({{ $service->prefixe }})
                    </button>
                @endforeach
            </div>
        </form>
    </div>
</body>
</html>
