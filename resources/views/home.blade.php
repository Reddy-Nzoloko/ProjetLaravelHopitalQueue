<!DOCTYPE html>
<html>
<head>
    <title>Hospital Queue System</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

    <div class="min-h-screen flex flex-col items-center justify-center">
        
        <h1 class="text-4xl font-bold text-blue-600 mb-4">
            Bienvenue au Hospital Queue System
        </h1>

        <p class="mb-6 text-gray-600">
            Gérez les files d'attente des patients facilement.
        </p>

        <div class="flex gap-4">
            <a href="{{ route('login') }}" 
               class="px-6 py-2 bg-blue-600 text-white rounded">
               Se connecter
            </a>

            <a href="{{ route('register') }}" 
               class="px-6 py-2 bg-green-600 text-white rounded">
               S'inscrire
            </a>
        </div>

    </div>

</body>
</html>