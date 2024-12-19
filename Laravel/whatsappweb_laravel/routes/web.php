<?php

use App\Http\Controllers\ChatAdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSettingController;
use App\Models\ChatUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/test/{chat_id}', [MessageController::class, 'selectLastMessage']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/select-all-messages', [MessageController::class, 'selectMessages']);
    Route::get('/not-seen-messages-per-chat', [MessageController::class, 'notSeenMessages']);


    Route::get('/is-chat-admin', [ChatAdminController::class, 'checkIfAdmin']);

    Route::get('/select-user-details', [UserController::class, 'userDetails']);

    Route::get('/get-chat-settings', [UserSettingController::class, 'chatSettings']);
    Route::get('/get-users-settings', [UserSettingController::class, 'usersSettings']);

    Route::get('/select-all-chats', [ChatController::class, 'allChats']);
    Route::get('/long-polling', [ChatController::class, 'longPolling']);
});