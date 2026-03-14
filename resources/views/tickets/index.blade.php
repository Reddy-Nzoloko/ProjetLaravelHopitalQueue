<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Appels</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-100 flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                            <div>
                                <div class="font-mono font-bold text-lg">{{ $ticket->numero_ticket }}</div>
                                <div class="text-sm text-gray-600">
                                    {{ $ticket->patient_nom }} · {{ $ticket->patient_age }} ans · {{ $ticket->patient_sexe }}
                                    @if($ticket->priorite)
                                        <span class="ml-2 text-xs font-bold text-red-600">PRIORITÉ</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('ticket.call', $ticket) }}">
                                    @csrf
                                    <button type="submit" class="bg-indigo-600 text-white text-xs px-3 py-1 rounded-md hover:bg-indigo-700">Appeler</button>
                                </form>
                            </div>
                        </div>
                    @endforeach

                    @if($ticketsAttente->isEmpty())
                        <div class="p-4 bg-green-50 text-green-800 rounded-lg">
                            Aucun ticket en attente pour le moment.
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-200">
                <h2 class="font-bold text-green-600 mb-4 flex items-center">
                    <span class="w-3 h-3 bg-green-600 rounded-full mr-2 animate-pulse"></span> Au guichet
                </h2>
                <div class="text-sm text-gray-600">
                    @if(isset($guichet))
                        Guichet : <strong>{{ $guichet->nom }}</strong><br>
                        Temps d'attente avant appel automatique : <strong>{{ $delaiAppel }}s</strong>
                    @else
                        Aucun guichet associé.
                    @endif
                </div>
                @if(isset($guichet))
                    <form id="next-ticket" method="POST" action="{{ route('ticket.next') }}" class="mt-4">
                        @csrf
                        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700">Appeler suivant</button>
                    </form>
                @endif
            </div>

            <div class="bg-indigo-900 text-white p-6 rounded-xl shadow-lg">
                <h2 class="font-bold mb-4">Résumé du jour</h2>
                <p class="text-3xl font-black">{{ $totalTickets ?? 0 }}</p>
                <p class="text-indigo-300 text-sm">Tickets générés aujourd'hui</p>
            </div>
        </div>
    </div>

    @if(isset($delaiAppel) && $delaiAppel > 0)
        <script>
            const delaySeconds = {{ $delaiAppel }};
            const nextTicketForm = document.getElementById('next-ticket');

            if (nextTicketForm) {
                window.setTimeout(() => {
                    nextTicketForm.submit();
                }, delaySeconds * 1000);
            }
        </script>
    @endif
</body>
</html>
