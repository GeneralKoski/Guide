<?php

use App\Http\Controllers\ChatAdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ChatUserController;
use App\Http\Controllers\GroupChatMessageController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSettingController;
use Illuminate\Support\Facades\Route;

Route::get('/');

Route::resource('chatadmin', ChatAdminController::class);
Route::resource('chat', ChatController::class);
Route::resource('chatuser', ChatUserController::class);
Route::resource('groupchatmessage', GroupChatMessageController::class);
Route::resource('media', MediaController::class);
Route::resource('message', MessageController::class);
Route::resource('user', UserController::class);
Route::resource('usersetting', UserSettingController::class);


Route::get('/chatadmin/chat_id/user_id', [ChatAdminController::class, 'index']);
// Tutte le fetch da gestire:
// http: //localhost:3000/isChatAdmin.php?chat_id=${selectedChat}&user_id=${idUserAttuale} METODO GET
// http: //localhost:3000/selectAllSingleMessages.php?chat_id=${selectedChat}&user_id=${idUserAttuale} METODO GET
// http: //localhost:3000/selectAllGroupMessages.php?chat_id=${selectedChat}&user_id=${idUserAttuale} METODO GET
// http: //localhost:3000/selectUserDetails.php?chat_id=${selectedChat}&user_id=${idUserAttuale} METODO GET
// http: //localhost:3000/getChatSettings.php?chat_id=${selectedChat} METODO GET
// http: //localhost:3000/insertMessage.php METODO POST
// http: //localhost:3000/selectAllChats.php?user_id=${idUserAttuale} METODO GET
// http: //localhost:3000/getUsersSettings.php?user_id=${idUserAttuale} METODO GET
// http: //localhost:3000/updateSeenMessages.php METODO PUT/PATCH
// http: //localhost:3000/notSeenMessagesPerChat.php?user_id=${idUserAttuale} METODO GET


// Da gestire con gli aiuti che esistono già in laravel: RIGUARDA IL TUTORIAL SU YOUTUBE
// http: //localhost:3000/checkSession.php METODO GET
// http: //localhost:3000/loginUser.php METODO POST
// http://localhost:3000/logoutUser.php METODO POST