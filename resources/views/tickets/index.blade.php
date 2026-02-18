<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Appels</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-6">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">File d'attente en temps réel</h1>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <h2 class="font-bold text-orange-600 mb-4 flex items-center">
                    <span class="w-3 h-3 bg-orange-600 rounded-full mr-2"></span> En attente
                </h2>
                <div class="space-y-3">
                    @foreach($ticketsAttente as $ticket)
                    <div class="p-3 bg-gray-50 rounded-lg border border-gray-100 flex justify-between items-center">
                        <span class="font-mono font-bold text-lg">{{ $ticket->code_ticket }}</span>
                        <button class="bg-indigo-600 text-white text-xs px-3 py-1 rounded-md hover:bg-indigo-700">Appeler</button>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <h2 class="font-bold text-green-600 mb-4 flex items-center">
                    <span class="w-3 h-3 bg-green-600 rounded-full mr-2 animate-pulse"></span> Au guichet
                </h2>
                </div>

            <div class="bg-indigo-900 text-white p-6 rounded-xl shadow-lg">
                <h2 class="font-bold mb-4">Résumé du jour</h2>
                <p class="text-3xl font-black">{{ $totalTickets ?? 0 }}</p>
                <p class="text-indigo-300 text-sm">Tickets générés aujourd'hui</p>
            </div>
        </div>
    </div>
</body>
</html>
