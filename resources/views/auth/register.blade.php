@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto bg-white shadow rounded p-6">
    <h2 class="text-xl font-semibold mb-4">S'inscrire</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <label class="block text-sm text-gray-600 mb-1">Nom</label>
        <input name="name" type="text" value="{{ old('name') }}" class="w-full border p-2 rounded mb-3" required autofocus>

        <label class="block text-sm text-gray-600 mb-1">Email</label>
        <input name="email" type="email" value="{{ old('email') }}" class="w-full border p-2 rounded mb-3" required>

        <label class="block text-sm text-gray-600 mb-1">Mot de passe</label>
        <input name="password" type="password" class="w-full border p-2 rounded mb-3" required>

        <label class="block text-sm text-gray-600 mb-1">Confirmer le mot de passe</label>
        <input name="password_confirmation" type="password" class="w-full border p-2 rounded mb-3" required>

        <button class="w-full bg-indigo-600 text-white px-4 py-2 rounded">Créer un compte</button>
    </form>
</div>
@endsection