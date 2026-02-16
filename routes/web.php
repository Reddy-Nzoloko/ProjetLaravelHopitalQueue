<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ConsultationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuichetController;
use App\Http\Controllers\HopitalController;

Route::get('/', function () {
    return view('welcome');
});

// --- Auth (basic) ---
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('login', [LoginController::class, 'create'])->name('login');
Route::post('login', [LoginController::class, 'store']);
Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('register', [RegisteredUserController::class, 'store']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- Routes accessibles aux réceptionnistes (création + listing de tickets + appel) ---
    Route::middleware(['role:receptionniste,admin_hopital,admin_global'])->group(function () {
        Route::resource('tickets', TicketController::class)->only(['index','store','show']);
        Route::post('tickets/{ticket}/call', [TicketController::class, 'call'])->name('tickets.call');
    });

    // --- Routes pour médecins (démarrer / terminer consultations + gérer consultations) ---
    Route::middleware(['role:medecin,admin_hopital,admin_global'])->group(function () {
        Route::post('tickets/{ticket}/start', [TicketController::class, 'start'])->name('tickets.start');
        Route::post('tickets/{ticket}/finish', [TicketController::class, 'finish'])->name('tickets.finish');

        Route::resource('consultations', ConsultationController::class)->only(['show','store']);
    });

    // --- Administration hôpital (guichets / hopitaux) ---
    Route::middleware(['role:admin_hopital,admin_global'])->group(function () {
        Route::get('guichets', [GuichetController::class, 'index'])->name('guichets.index');
        Route::post('guichets/{guichet}/open', [GuichetController::class, 'open'])->name('guichets.open');
        Route::post('guichets/{guichet}/close', [GuichetController::class, 'close'])->name('guichets.close');

        Route::resource('hopitaux', HopitalController::class)->except(['destroy']);
    });
});
