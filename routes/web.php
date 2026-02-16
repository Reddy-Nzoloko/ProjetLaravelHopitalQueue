<?php

use Illuminate\Support\Facades\Route;
// route pour hopital
use App\Http\Controllers\HopitalController;

Route::prefix('admin')->group(function () {
    Route::get('/hopitaux', [HopitalController::class, 'index'])->name('hopitaux.index');
    Route::get('/hopitaux/creer', [HopitalController::class, 'create'])->name('hopitaux.create');
    Route::post('/hopitaux', [HopitalController::class, 'store'])->name('hopitaux.store');
});

// route pour guichet
use App\Http\Controllers\TicketController;
Route::post('/ticket/generer', [TicketController::class, 'store'])->name('ticket.store');


Route::get('/', function () {
    return view('welcome');
});
