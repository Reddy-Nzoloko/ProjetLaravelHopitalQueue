@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white shadow rounded p-6">
    <h2 class="text-xl font-semibold mb-4">Se connecter</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label class="block text-sm text-gray-600 mb-1">Email</label>
        <input name="email" type="email" value="{{ old('email') }}" class="w-full border p-2 rounded mb-3" required autofocus>

        <label class="block text-sm text-gray-600 mb-1">Mot de passe</label>
        <input name="password" type="password" class="w-full border p-2 rounded mb-3" required>

        <div class="flex items-center justify-between mb-3">
            <label class="inline-flex items-center text-sm"><input type="checkbox" name="remember" class="mr-2">Se souvenir</label>
            <a href="#" class="text-sm text-indigo-600">Mot de passe oublié ?</a>
        </div>

        <button class="w-full bg-indigo-600 text-white px-4 py-2 rounded">Connexion</button>
    </form>
</div>
@endsection