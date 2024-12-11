<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chats = Chat::all();
        return view('chats.index', ['chats' => $chats]);
    }

    public function allChats(Request $request)
    {
        $user_id = $request->input('user_id');

        $chats = DB::select("SELECT c.id as chat_id, c.type as chat_type,
       CASE
           WHEN c.type = 'single' THEN (
               SELECT u.icon
               FROM ChatUsers cu
               JOIN Users u ON u.id = cu.user_id
               WHERE cu.chat_id = c.id AND cu.user_id != $user_id
               LIMIT 1
           )
       END AS icon,
        CASE
            WHEN c.type = 'single' THEN (
                SELECT u.username
                FROM ChatUsers cu
                JOIN Users u ON u.id = cu.user_id
                WHERE cu.chat_id = c.id AND cu.user_id != $user_id
                LIMIT 1
            )
           ELSE c.name
        END AS chat_name, m1.content AS last_message_content, m1.type as message_type, m1.sent_at, m1.user_id AS last_message_sender_id, m1.seen
        FROM Chats c
        JOIN ChatUsers cu ON c.id = cu.chat_id
        JOIN Users u ON u.id = cu.user_id
        LEFT JOIN (
            SELECT m1.id, m1.chat_id, m1.content, m1.sent_at, m1.user_id, m1.seen, m1.type
            FROM Messages m1
            JOIN (
                SELECT chat_id, MAX(sent_at) AS last_message_time
                FROM Messages
                GROUP BY chat_id
            ) m2 ON m1.chat_id = m2.chat_id AND m1.sent_at = m2.last_message_time
        ) m1 ON c.id = m1.chat_id
        WHERE cu.user_id = $user_id
        ORDER BY m1.sent_at DESC;");

        return response()->json($chats);
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