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

Route::get('/', function () {
    return view('welcome');
});

Route::resource('chatadmin', ChatAdminController::class);
Route::resource('chat', ChatController::class);
Route::resource('chatuser', ChatUserController::class);
Route::resource('groupchatmessage', GroupChatMessageController::class);
Route::resource('media', MediaController::class);
Route::resource('message', MessageController::class);
Route::resource('user', UserController::class);
Route::resource('usersetting', UserSettingController::class);

Route::middleware([CorsMiddleware::class])->get('/is-chat-admin', [ChatAdminController::class, 'checkIfAdmin']);
Route::middleware([CorsMiddleware::class])->get('/select-all-single-messages', [MessageController::class, 'selectSingleMessages']); // DA TRASFORMARE
Route::middleware([CorsMiddleware::class])->get('/select-all-group-messages', [MessageController::class, 'selectGroupMessages']); // DA TRASFORMARE
Route::middleware([CorsMiddleware::class])->get('/select-user-details', [UserController::class, 'userDetails']);
Route::middleware([CorsMiddleware::class])->get('/get-chat-settings', [UserSettingController::class, 'chatSettings']);
// Route::middleware([CorsMiddleware::class])->post('/insert-message', [MessageController::class, 'insertMessage']); // METODO POST DA VEDERE
Route::middleware([CorsMiddleware::class])->get('/select-all-chats', [ChatController::class, 'allChats']); // DA TRASFORMARE
Route::middleware([CorsMiddleware::class])->get('/not-seen-messages-per-chat', [MessageController::class, 'notSeenMessages']);
Route::middleware([CorsMiddleware::class])->get('/get-users-settings', [UserSettingController::class, 'usersSettings']); // DA FARE
// Route::middleware([CorsMiddleware::class])->get('/update-seen-messages', [MessageController::class, 'updateSeen']); // METODO PATCH DA VEDERE



// Da gestire con gli aiuti che esistono già in laravel: RIGUARDA IL TUTORIAL SU YOUTUBE
// http: //localhost:3000/checkSession.php METODO GET
// http: //localhost:3000/loginUser.php METODO POST
// http://localhost:3000/logoutUser.php METODO POST