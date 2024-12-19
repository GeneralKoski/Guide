<?php

use App\Events\NewAccess;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatAdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSettingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('/login-user', [AuthController::class, 'loginUser'])->name('login');

Route::get('/chats/{user}', [ChatController::class, 'allChats']);
// Route::get('/chats/{chat}', [ChatController::class, 'chatDetail']);
Route::get('/chats/{chat}/messages', [ChatController::class, 'chatMessages']);
Route::get('/chats/{chat}/messages/{message}', [ChatController::class, 'chatMessage'])->scopeBindings();;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/select-all-messages', [MessageController::class, 'selectMessages']);
    Route::get('/not-seen-messages-per-chat', [MessageController::class, 'notSeenMessages']);
    Route::get('/is-chat-admin', [ChatAdminController::class, 'checkIfAdmin']);
    Route::get('/select-user-details', [UserController::class, 'userDetails']);
    Route::get('/get-chat-settings', [UserSettingController::class, 'chatSettings']);
    Route::get('/get-users-settings', [UserSettingController::class, 'usersSettings']);
    Route::get('/select-all-chats', [ChatController::class, 'allChats']);

    Route::post('/insert-message', [MessageController::class, 'insertMessage']);
    Route::post('/logout-user', [AuthController::class, 'logoutUser']);

    Route::put('/update-seen-messages', [MessageController::class, 'updateSeen']);

    Route::get('/verify-token', function () {
        $user = Auth::user();

        if ($user instanceof \App\Models\User) {
            event(new NewAccess($user));
            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'icon' => $user->icon,
                ],
                'message' => 'Utente autenticato con successo',
            ]);
        } else {
            return response()->json(['message' => 'Erorre'], 401);
        }
    });
});