<?php

use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TicketStatsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/tickets', [TicketController::class, 'index']);
Route::get('/tickets/open', [TicketController::class, 'open']);
Route::get('/tickets/close', [TicketController::class, 'closed']);

Route::get('/users/{user_email}/tickets', [UserController::class, 'user_tickets'])->where('user_email', '.*');
Route::post('/users/{user_email}/create', [UserController::class, 'create_tickets']);

Route::get('/stats', [TicketStatsController::class, 'index']);


