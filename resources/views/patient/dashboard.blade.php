@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4">Espace patient</h1>

    <div class="bg-white shadow rounded-lg p-6">
        <p class="text-lg font-semibold">Bonjour, {{ $patient->name }}.</p>
        <p class="text-sm text-slate-600">Vous êtes inscrit pour :</p>
        <ul class="mt-3 space-y-1 text-sm">
            <li><strong>Hôpital :</strong> {{ $patient->hopital->nom ?? '—' }}</li>
            <li><strong>Service :</strong> {{ $patient->service->nom ?? '—' }}</li>
            <li><strong>Guichet :</strong> {{ $patient->guichet->nom ?? '—' }}</li>
        </ul>

        <div class="mt-6 flex flex-col gap-3 sm:flex-row">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700">
                Retour à l'accueil
            </a>
            <form method="POST" action="{{ route('patient.logout') }}" class="inline">
                @csrf
                <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-slate-700 text-white rounded-lg shadow hover:bg-slate-800">
                    Se déconnecter
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
