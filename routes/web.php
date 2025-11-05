<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tickets', [TicketController::class, 'index']);
Route::get('/tickets/open', [TicketController::class, 'open']);
Route::get('/tickets/close', [TicketController::class, 'closed']);
Route::get('/stats', [TicketController::class, 'stats']);
Route::get('/users/{user_email}/tickets', [TicketController::class, 'user_ticket'])->where('user_email', '.*');
