<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HopitalController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TicketController;

// --- GROUPE ADMIN ---
Route::prefix('admin')->group(function () {
    // Hôpitaux
    Route::get('/hopitaux', [HopitalController::class, 'index'])->name('hopitaux.index');
    Route::get('/hopitaux/creer', [HopitalController::class, 'create'])->name('hopitaux.create');
    Route::post('/hopitaux', [HopitalController::class, 'store'])->name('hopitaux.store');

    // Services
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/creer', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');

    // Liste des tickets (Gestion des Appels)
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
});

// --- PARTIE BORNE (PATIENTS) ---
Route::get('/borne/{hopital_id}', [TicketController::class, 'create'])->name('ticket.borne');
Route::post('/ticket/generer', [TicketController::class, 'store'])->name('ticket.store');

Route::get('/', function () { return view('welcome'); });
