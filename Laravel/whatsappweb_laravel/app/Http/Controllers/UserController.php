<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatUserIDS;
use App\Models\User;
use Illuminate\Http\Request;
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

    public function userDetails(ChatUserIDS $request)
    {
        $chatId = $request->input('chat_id');
        $userId = $request->input('user_id');

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
            ->where('cu.user_id', '!=', $userId)
            ->where('cu.chat_id', '=', $chatId)
            ->get();
        return response()->json($details);
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
    public function show(User $user)
    {
        return view('users.show', ['user' => $user]);
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