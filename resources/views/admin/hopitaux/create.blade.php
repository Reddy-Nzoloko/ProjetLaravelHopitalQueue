<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Hôpital</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

    <div class="max-w-2xl mx-auto bg-white p-8 rounded-xl shadow-md">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Nouvel Établissement</h1>
            <a href="{{ route('hopitaux.index') }}" class="text-blue-500 hover:underline">← Retour</a>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('hopitaux.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nom de l'hôpital</label>
                <input type="text" name="nom" value="{{ old('nom') }}" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Ex: Clinique Espoir">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700">Adresse complète</label>
                <textarea name="adresse" rows="3" required
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="N°12, Avenue du Commerce..."></textarea>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white font-bold py-3 px-4 rounded-md hover:bg-blue-700 transition duration-200">
                Enregistrer l'Hôpital
            </button>
        </form>
    </div>

</body>
</html>
