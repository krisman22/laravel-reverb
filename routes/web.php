<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/message', [MessageController::class, 'index']);
Route::post('/message/send', [MessageController::class, 'sendMessage'])->name('sendMessage');
