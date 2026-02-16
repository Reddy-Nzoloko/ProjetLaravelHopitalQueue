<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'HopitalQueue') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white dark:bg-gray-900 text-gray-800">
    <header class="w-full bg-white/60 dark:bg-gray-800/60 shadow-sm border-b">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
            <a href="/" class="font-semibold">{{ config('app.name', 'HopitalQueue') }}</a>

            <nav class="flex items-center gap-3 text-sm">
                @auth
                    <a href="{{ route('dashboard') }}" class="px-3 py-1 rounded hover:bg-gray-100">Dashboard</a>
                    <a href="{{ route('tickets.index') }}" class="px-3 py-1 rounded hover:bg-gray-100">Tickets</a>
                    <a href="{{ route('guichets.index') }}" class="px-3 py-1 rounded hover:bg-gray-100">Guichets</a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="px-3 py-1 rounded hover:bg-gray-100">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-3 py-1 rounded hover:bg-gray-100">Login</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="max-w-6xl mx-auto p-4">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 text-green-800 border border-green-100 rounded">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>
</body>
</html>
