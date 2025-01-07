<?php

namespace App\Http\Controllers;

use App\Http\Requests\checkChatID;
use App\Http\Requests\checkUserChatIDS;
use App\Models\Chat;
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

        $details =
            DB::table('Users as u')
                ->select(
                    'u.username',
                    'u.icon',
                    DB::raw("IF(c.type = 'group', NULL, u.last_access) AS last_access"),
                    DB::raw("IF(c.type = 'group', c.name, '') AS name"),
                    'c.type'
                )
                ->join('ChatUsers as cu', 'u.id', '=', 'cu.user_id')
                ->join('Chats as c', 'c.id', '=', 'cu.chat_id')
                ->where('cu.user_id', '!=', $user_id)
                ->where('cu.chat_id', '=', $chat_id)
                ->get();
        return response()->json($details);
    }
}
