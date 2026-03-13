<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GuichetController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
// Supprime ou commente cette ligne :
// Route::get('/dashboard', function () { return view('dashboard'); })->middleware(['auth', 'verified'])->name('dashboard');

// Et remplace-la par celle-ci :
use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
require __DIR__.'/auth.php';

use App\Http\Controllers\HopitalController;
use App\Http\Controllers\ServiceController;

// Routes protégées par l'authentification
Route::middleware(['auth'])->group(function () {

    // Ressources pour les hôpitaux (Seul l'admin global devrait y accéder idéalement)
    Route::resource('hopitaux', HopitalController::class);

    // Ressources pour les services
    Route::resource('services', ServiceController::class);
    // détail du service (médecins, etc.)
    Route::get('services/{service}/show', [ServiceController::class, 'show'])->name('services.show');

    // gestion des guichets (docteurs/administrateurs peuvent en créer)
    Route::resource('guichets', GuichetController::class)->only(['index','create','store','update']);

    // bornes et tickets
    Route::get('tickets/borne/{hopital}', [TicketController::class, 'create'])->name('ticket.borne');
    Route::post('tickets', [TicketController::class, 'store'])->name('ticket.store');
    Route::get('tickets', [TicketController::class, 'index'])->name('ticket.index');

});
