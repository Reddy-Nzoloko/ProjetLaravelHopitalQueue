<?php

use Illuminate\Support\Facades\Route;
// route pour guichet
use App\Http\Controllers\TicketController;
Route::post('/ticket/generer', [TicketController::class, 'store'])->name('ticket.store');

Route::get('/', function () {
    return view('welcome');
});
