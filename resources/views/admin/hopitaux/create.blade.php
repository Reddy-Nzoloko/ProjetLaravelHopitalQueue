<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Hôpital</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 via-white to-blue-50 min-h-screen flex items-center justify-center p-6">

    <div class="max-w-2xl w-full bg-white p-10 rounded-2xl shadow-xl border border-gray-200">
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-extrabold text-gray-800 tracking-tight">Nouvel Établissement</h1>
            <a href="{{ route('hopitaux.index') }}"
               class="text-blue-600 font-semibold hover:text-blue-800 transition duration-200 flex items-center gap-1">
               ← Retour
            </a>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Formulaire -->
        <form action="{{ route('hopitaux.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nom de l'hôpital -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom de l'hôpital</label>
                <input type="text" name="nom" value="{{ old('nom') }}" required
                    class="w-full p-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200"
                    placeholder="Ex: Clinique Espoir">
            </div>

            <!-- Adresse complète -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Adresse complète</label>
                <textarea name="adresse" rows="4" required
                    class="w-full p-3 border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition duration-200"
                    placeholder="N°12, Avenue du Commerce...">{{ old('adresse') }}</textarea>
            </div>

            <!-- Bouton -->
            <button type="submit"
                class="w-full py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-xl shadow-md hover:from-blue-600 hover:to-blue-700 transition duration-300">
                Enregistrer l'Hôpital
            </button>
        </form>
    </div>

</body>
</html>