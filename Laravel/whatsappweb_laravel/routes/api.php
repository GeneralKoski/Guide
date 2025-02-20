<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatAdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSettingController;
use Illuminate\Support\Facades\Route;

Route::get('/prova/{user}', [ChatController::class, 'prova'])->scopeBindings();;

Route::post('/login-user', [AuthController::class, 'loginUser'])->name('login');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/verify', [AuthController::class, 'verifyToken']);

    Route::get('/not-seen-messages', [MessageController::class, 'notSeenMessages']);
    Route::get('/users-settings', [UserSettingController::class, 'usersSettings']);
    Route::get('/all-chats/chatsOfUserID{user}', [ChatController::class, 'allChats'])->scopeBindings();

    Route::get('/select-all-messages/messagesChat{chat}', [MessageController::class, 'selectMessages'])->scopeBindings();
    Route::get('/is-chat-admin/adminChat{chat}', [ChatAdminController::class, 'checkIfAdmin'])->scopeBindings();;
    Route::get('/select-user-details/detailsChat{chat}', [UserController::class, 'userDetails'])->scopeBindings();;
    Route::get('/users-settings/settingsChat{chat}', [UserSettingController::class, 'usersSettings'])->scopeBindings();;

    Route::post('/insert-message', [MessageController::class, 'insertMessage']);
    Route::post('/logout', [AuthController::class, 'logoutUser']);

    Route::put('/update-seen-messages/updateSeenChat{id}', [MessageController::class, 'updateSeen']);
});