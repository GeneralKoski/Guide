<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Http\Resources\MessageResource;
use App\Models\Chat;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class ChatController extends Controller
{
    public function chatDetail(Chat $chat)
    {
        // dd($id);
        dd($chat->getAttributes());
        // $chat = Chat::find($chat)->getAttributes();
        // dd($chat);
    }
    public function chatMessages(Chat $chat)
    {
        $messages = $chat->messages;
        $messages = MessageResource::collection($messages);
        return $messages;
        // dd($messages);
    }
    public function chatMessage(Chat $chat, Message $message)
    {
        return new MessageResource($message);
        // dd($message->toArray());
        // dd($id);
        // dd($chat->getAttributes());
        // $chat = Chat::find($chat)->getAttributes();
        // dd($chat);
    }



    public function allChats()
    {
        $user_id = Auth::user()->id;

        if (!$user_id) {
            return response()->json(['message' => 'Hai il log-in con il profilo sbagliato'], 401);
        }

        $chats = DB::table('Chats as c')
            ->select(
                DB::raw('c.id as chat_id'),
                DB::raw('c.type as chat_type'),
                DB::raw("CASE WHEN c.type = 'single' THEN (
                                                SELECT u.icon
                                                FROM ChatUsers cu
                                                JOIN Users u ON u.id = cu.user_id
                                                WHERE cu.chat_id = c.id AND cu.user_id != $user_id
                                                LIMIT 1
                                            )
                                        END AS icon"),
                DB::raw("CASE WHEN c.type = 'single' THEN (
                                                SELECT u.username
                                                FROM ChatUsers cu
                                                JOIN Users u ON u.id = cu.user_id
                                                WHERE cu.chat_id = c.id AND cu.user_id != $user_id
                                                LIMIT 1
                                            )
                                            ELSE c.name
                                        END AS chat_name"),
                DB::raw('m1.content AS last_message_content'),
                DB::raw('m1.type as message_type'),
                'm1.sent_at',
                DB::raw('m1.user_id AS last_message_sender_id'),
                'm1.seen'
            )
            ->join('ChatUsers as cu', 'c.id', '=', 'cu.chat_id')
            ->join('Users as u', 'u.id', '=', 'cu.user_id')
            ->leftJoin(DB::raw("(SELECT m1.id, m1.chat_id, m1.content, m1.sent_at, m1.user_id, m1.seen, m1.type
            FROM Messages m1
            JOIN (
                SELECT chat_id, MAX(sent_at) AS last_message_time
                FROM Messages
                GROUP BY chat_id
            ) m2 ON m1.chat_id = m2.chat_id AND m1.sent_at = m2.last_message_time
        ) as m1"), 'c.id', '=', 'm1.chat_id')
            ->where('cu.user_id', '=', $user_id)
            ->orderBy('m1.sent_at', 'DESC')
            ->get();

        return response()->json($chats);
    }
}