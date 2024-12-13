<?php

use App\Http\Controllers\ChatAdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatUserController;
use App\Http\Controllers\GroupChatMessageController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSettingController;
use App\Http\Middleware\CorsMiddleware;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login-user', [AuthController::class, 'loginUser'])->name('login');
Route::get('/logout-user', [AuthController::class, 'logoutUser']);
Route::get('/is-chat-admin', [ChatAdminController::class, 'checkIfAdmin']);
Route::get('/select-all-single-messages', [MessageController::class, 'selectSingleMessages']); // DA TRASFORMARE
Route::get('/select-all-group-messages', [MessageController::class, 'selectGroupMessages']); // DA TRASFORMARE
Route::get('/select-user-details', [UserController::class, 'userDetails']);
Route::get('/get-chat-settings', [UserSettingController::class, 'chatSettings']);
Route::get('/insert-message', [MessageController::class, 'insertMessage']); // METODO POST DA VEDERE E DA SISTEMARE IL CREATE PENSO
Route::get('/select-all-chats', [ChatController::class, 'allChats']); // DA TRASFORMARE
Route::get('/not-seen-messages-per-chat', [MessageController::class, 'notSeenMessages']);
Route::get('/get-users-settings', [UserSettingController::class, 'usersSettings']); // DA TRASFORMARE
Route::get('/update-seen-messages', [MessageController::class, 'updateSeen']); // METODO PATCH DA VEDERE