<?php

namespace App\Http\Controllers;

use App\Http\Requests\checkChatID;
use App\Http\Requests\checkUserID;
use App\Models\UserSetting;
use Illuminate\Http\Request;
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

        $usersSettings = DB::select("SELECT us.setting_name, MAX(us.setting_value) AS setting_value, cu.user_id, u.username, MAX(cu.chat_id) AS chat_id
    FROM ChatUsers cu
    JOIN UserSettings us ON cu.user_id = us.user_id
    JOIN Users u ON u.id = us.user_id
    JOIN Chats c ON c.id = cu.chat_id

    WHERE
        cu.chat_id IN (
            SELECT cu2.chat_id
            FROM ChatUsers cu2
            WHERE cu2.user_id = $user_id
        )

    AND c.type = 'single'
    GROUP BY us.setting_name, cu.user_id, u.username
    ORDER BY cu.chat_id, u.id;");

        return response()->json($usersSettings);
    }

    public function chatSettings(checkChatID $request)
    {
        $chat_id = $request->input('chat_id');
        $chatsSettings = DB::table('UserSettings as us')->select('us.user_id', 'us.setting_name', 'us.setting_value', 'u.username')
            ->join('Users as u', 'u.id', '=', 'us.user_id')
            ->join('ChatUsers as cu', 'u.id', '=', 'cu.user_id')
            ->join('Chats as c', 'c.id', '=', 'cu.chat_id')
            ->where('c.type', '=', "single")
            ->where('cu.chat_id', '=', $chat_id)
            ->get();

        return response()->json($chatsSettings);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}