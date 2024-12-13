<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware([CorsMiddleware::class])->get('/login-user', [AuthController::class, 'loginUser'])->name('login');

Route::get('/', function () {
    return "Ciao";
});