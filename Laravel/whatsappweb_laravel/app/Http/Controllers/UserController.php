<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', ['users' => $users]);
    }

    public function userDetails(Chat $chat)
    {
        $chat_id = $chat['id'];
        $user_id = Auth::user()->id;

        if (!$user_id) {
            return response()->json(['message' => 'Hai il log-in con il profilo sbagliato'], 401);
        }

        $isThere = Message::hasChatId($chat_id, $user_id);
        if (!$isThere) {
            return response()->json(['message' => "Non puoi vedere i dettagli dell'utente perchè non appartieni a questa chat"], 401);
        }

        $other_user = Chat::otherUser($chat);

        $newDetails = [
            'type' => $chat->type,
            'name' => $chat->type === 'group' ? Chat::find($chat_id)->name : '',
            'icon' => $other_user->icon,
            'username' => $other_user->username,
            'last_access' => $chat->type === 'single' ? $other_user->last_access : NULL,
        ];
        return response()->json($newDetails);
    }
}