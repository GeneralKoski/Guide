<?php

use App\Http\Controllers\ChatAdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatUserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSettingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/select-all-single-messages', [MessageController::class, 'selectSingleMessages']);
    Route::get('/not-seen-messages-per-chat', [MessageController::class, 'notSeenMessages']);
    Route::get('/select-all-group-messages', [MessageController::class, 'selectGroupMessages']);

    Route::get('/is-chat-admin', [ChatAdminController::class, 'checkIfAdmin']);

    Route::get('/select-user-details', [UserController::class, 'userDetails']);

    Route::get('/get-chat-settings', [UserSettingController::class, 'chatSettings']);
    Route::get('/get-users-settings', [UserSettingController::class, 'usersSettings']);

    Route::get('/select-all-chats', [ChatController::class, 'allChats']);
});