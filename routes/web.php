<?php

use Illuminate\Support\Facades\Route;
// route pour hopital
use App\Http\Controllers\HopitalController;

Route::prefix('admin')->group(function () {
    Route::get('/hopitaux', [HopitalController::class, 'index'])->name('hopitaux.index');
    Route::get('/hopitaux/creer', [HopitalController::class, 'create'])->name('hopitaux.create');
    Route::post('/hopitaux', [HopitalController::class, 'store'])->name('hopitaux.store');
});

// route des services
use App\Http\Controllers\ServiceController;

Route::prefix('admin')->group(function () {
    // ... tes routes hopitaux existantes ...

    // Routes pour les Services
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::get('/services/creer', [ServiceController::class, 'create'])->name('services.create');
    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
});

// route pour guichet
use App\Http\Controllers\TicketController;
Route::post('/ticket/generer', [TicketController::class, 'store'])->name('ticket.store');


Route::get('/', function () {
    return view('welcome');
});
