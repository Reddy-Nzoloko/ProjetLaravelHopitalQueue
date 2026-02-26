<main class="flex flex-col items-center justify-center text-center p-10 bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-4 text-blue-600">
        Bienvenue au Système de Gestion d'Hôpital
    </h1>

    <p class="mb-6 text-gray-600">
        Gérez les patients, les médecins et les rendez-vous facilement.
    </p>

    <div class="flex gap-4">
        <a href="{{ route('login') }}" 
           class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Se connecter
        </a>

        <a href="{{ route('register') }}" 
           class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            S'inscrire
        </a>
    </div>
</main>