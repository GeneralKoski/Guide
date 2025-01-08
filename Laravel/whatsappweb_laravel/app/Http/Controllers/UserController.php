<?php

namespace App\Http\Controllers;

use App\Http\Requests\checkChatID;
use App\Http\Requests\checkUserChatIDS;
use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $type = Chat::find($chat_id)->type;

        $other_user_id = ChatUser::where('chat_id', '=', $chat_id)->where('user_id', '!=', $user_id)->get();

        $other_user_id = $other_user_id[0]['user_id'];

        $newDetails = [
            'type' => $type,
            'name' => $type === 'group' ? Chat::find($chat_id)->name : '',
            'icon' => User::find($other_user_id)->icon,
            'username' => User::find($other_user_id)->username,
            'last_access' => $type === 'single' ? User::find($other_user_id)->last_access : NULL,
        ];
        return response()->json($newDetails);
    }
}