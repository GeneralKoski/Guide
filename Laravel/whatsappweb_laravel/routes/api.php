<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::get('/verify-token', function () {
    $user = Auth::user();
    return response()->json([
        'success' => true,
        'user' => [
            'id' => $user->id,
            'username' => $user->username,
            'icon' => $user->icon,
        ],
    ]);
})->middleware('auth:sanctum');

Route::post('/login-user', [AuthController::class, 'loginUser'])->name('login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/insert-message', [MessageController::class, 'insertMessage']);

    Route::post('/logout-user', [AuthController::class, 'logoutUser']);

    Route::put('/update-seen-messages', [MessageController::class, 'updateSeen']);
});