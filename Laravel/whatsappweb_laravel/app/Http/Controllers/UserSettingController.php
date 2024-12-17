<?php

namespace App\Http\Controllers;

use App\Http\Requests\checkChatID;
use App\Http\Requests\checkUserID;
use App\Models\Message;
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

    public function usersSettings(checkUserID $request)
    {
        $user_id = $request->input('user_id');

        $userAuth = Auth::user();
        if ($userAuth->id != $user_id) {
            return response()->json(['message' => 'Hai il log-in con il profilo sbagliato'], 401);
        }

        $usersSettings = DB::table('ChatUsers as cu')
            ->select(
                'cu.user_id',
                'us.setting_name',
                'u.username',
                DB::raw("MAX(us.setting_value) AS setting_value, MAX(cu.chat_id) AS chat_id")
            )
            ->join('UserSettings as us', 'cu.user_id', '=', 'us.user_id')
            ->join('Users as u', 'u.id', '=', 'us.user_id')
            ->join('Chats as c', 'c.id', '=', 'cu.chat_id')
            ->whereIn('cu.chat_id', function ($query) use ($user_id) {
                $query->select('cu2.chat_id')
                    ->from('ChatUsers as cu2')
                    ->where('cu2.user_id', $user_id);
            })
            ->where('c.type', '=', 'single')
            ->groupBy('us.setting_name', 'cu.user_id', 'u.username')
            ->orderBy('cu.chat_id')
            ->orderBy('u.id')
            ->get();

        return response()->json($usersSettings);
    }

    public function chatSettings(checkChatID $request)
    {
        $chat_id = $request->input('chat_id');

        $extraParams = array_diff_key($request->all(), ['chat_id' => null]);

        if (!empty($extraParams)) {
            return response()->json(['error' => 'Qualcosa non va coi parametri'], 400);
        }

        $user_id = Auth::user()->id;
        $isThere = Message::hasChatId($chat_id, $user_id);
        if (!$isThere) {
            return response()->json(['message' => 'Non puoi vedere i settings di questa chat perchè non ci appartieni'], 401);
        }

        $chatsSettings = DB::table('UserSettings as us')->select('us.user_id', 'us.setting_name', 'us.setting_value', 'u.username')
            ->join('Users as u', 'u.id', '=', 'us.user_id')
            ->join('ChatUsers as cu', 'u.id', '=', 'cu.user_id')
            ->join('Chats as c', 'c.id', '=', 'cu.chat_id')
            ->where('c.type', '=', "single")
            ->where('cu.chat_id', '=', $chat_id)
            ->get();

        return response()->json($chatsSettings);
    }
}