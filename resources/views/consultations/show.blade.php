@extends('layouts.app')

@section('content')
<div class="bg-white shadow rounded p-4">
    <h3 class="text-lg font-semibold">Consultation #{{ $consultation->id }}</h3>

    <div class="mt-3">
        <h4 class="font-semibold">Symptômes</h4>
        <div class="text-sm text-gray-700">{{ $consultation->symptomes ?? '—' }}</div>
    </div>

    <div class="mt-3">
        <h4 class="font-semibold">Diagnostic</h4>
        <div class="text-sm text-gray-700">{{ $consultation->diagnostic ?? '—' }}</div>
    </div>

    <div class="mt-3">
        <h4 class="font-semibold">Ordonnance</h4>
        <div class="text-sm text-gray-700">{{ $consultation->ordonnance ?? '—' }}</div>
    </div>
</div>
@endsection
