<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\UserSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usersettings = UserSetting::all();
        return view('usersettings.index', ['usersettings' => $usersettings]);
    }

    public function usersSettings(Chat $chat)
    {
        $user_id = Auth::user()->id;

        $userAuth = Auth::user();
        if ($userAuth->id != $user_id) {
            return response()->json(['message' => 'Hai il log-in con il profilo sbagliato'], 401);
        }

        if (!$chat['id']) {
            // In questo caso trovo le impostazioni di tutte le chat
            $allChats = ChatUser::where('user_id', '=', $user_id)->groupBy('chat_id')->pluck('chat_id');

            $users = ChatUser::select('user_id')->whereIn('chat_id', $allChats)->distinct()->orderBy('user_id')->get();

            $usersSettings = UserSetting::select('setting_name', 'setting_value', 'u.username')
                ->join('Users as u', 'u.id', '=', 'user_id')
                ->whereIn('user_id', $users)
                ->get();
        } else {
            // In questo caso trovo le impostazioni di una chat specifica
            $chat_id = $chat['id'];

            $chat_users = ChatUser::where('chat_id', $chat_id)->pluck('user_id');
            $usersSettings = UserSetting::select('setting_name', 'setting_value', 'user_id')->whereIn('user_id', $chat_users)->get();
        }

        return response()->json($usersSettings);
    }
}
