<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'HopitalQueue') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-black text-gray-100">
    <div class="futuristic-bg fixed inset-0 -z-10"></div>

    <header class="w-full bg-transparent backdrop-blur-md/10 border-b border-white/5 py-4">
        <div class="max-w-6xl mx-auto px-4 flex items-center justify-between gap-6">
            <a href="/" class="flex items-center gap-4">
                <div class="rounded-full bg-gradient-to-br from-indigo-600 to-teal-400 p-3 shadow-neon">
                    <i data-lucide="cross" class="w-7 h-7 text-white"></i>
                </div>
                <div>
                    <div class="font-semibold text-xl text-neon">{{ config('app.name', 'HopitalQueue') }}</div>
                    <div class="text-xs opacity-70">File d'attente & consultations — Monitoring en temps réel</div>
                </div>
            </a>

            <nav class="flex items-center gap-3 text-sm">
                @auth
                    <a href="{{ route('dashboard') }}" class="neon-btn px-4 py-2 rounded">Dashboard</a>
                    <a href="{{ route('tickets.index') }}" class="neon-btn px-4 py-2 rounded">Tickets</a>
                    <a href="{{ route('guichets.index') }}" class="neon-btn px-4 py-2 rounded">Guichets</a>

                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="neon-btn px-4 py-2 rounded">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="neon-btn px-4 py-2 rounded">Login</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="max-w-6xl mx-auto p-6">
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-50 text-green-800 border border-green-100 rounded">{{ session('success') }}</div>
        @endif

        @yield('content')
    </main>

    <!-- Lucide icons (CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest/dist/lucide.min.js"></script>
    <script>document.addEventListener('DOMContentLoaded', ()=>{ if(window.lucide) lucide.replace() })</script>
</body>
</html>
