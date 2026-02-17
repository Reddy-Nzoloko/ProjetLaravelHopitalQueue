<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un Service</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Ajouter un Nouveau Service</h1>

        <form action="{{ route('services.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Rattacher à l'Hôpital</label>
                <select name="hopital_id" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                    <option value="">-- Sélectionnez un établissement --</option>
                    @foreach($hopitaux as $hopital)
                        <option value="{{ $hopital->id }}">{{ $hopital->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nom du Service (ex: Pédiatrie)</label>
                <input type="text" name="nom" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Préfixe du Ticket (3 à 4 lettres)</label>
                <input type="text" name="prefixe" placeholder="Ex: PED, URG, CARD" maxlength="5" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 uppercase">
                <p class="text-xs text-gray-500 mt-1">C'est ce qui apparaîtra sur le ticket (ex: PED-001).</p>
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-md hover:bg-indigo-700">
                Créer le Service
            </button>
        </form>
    </div>
</body>
</html>
