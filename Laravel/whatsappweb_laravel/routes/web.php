<?php

use App\Events\NewAccess;
use App\Events\NewMessageSent;
use App\Http\Controllers\ChatAdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSettingController;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/selectlastsinglemessage', [MessageController::class, 'selectLastSingleMessage']);

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