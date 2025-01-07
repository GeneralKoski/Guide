<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Http\Resources\MessageResource;
use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function allChats(User $user)
    {
        $user['id'] ? $user_id = $user['id'] : $user_id = Auth::user()->id;

        $allChatsID = ChatUser::where('user_id', '=', $user_id)->pluck('chat_id');
        $chats = Chat::select('id', 'type')->whereIn('id', $allChatsID)->get();

        $chatDetails = $chats->map(function ($chat) use ($user_id) {
            $lastMessage = Message::selectLastMessage($chat->id);

            return [
                'chat_id' => $chat->id,
                'chat_name' => User::getChatName($chat->id, $chat->type, $user_id),
                'chat_type' => $chat->type,
                'icon' => User::getIcon($chat->id, $chat->type, $user_id),
                'last_message_content' => $lastMessage['content'],
                'last_message_sender_id' => $lastMessage['user_id'],
                'message_type' => $lastMessage['message_type'],
                'seen' => $lastMessage['seen'],
                'sent_at' => $lastMessage['sent_at'],
            ];
        });

        $chatDetails = $chatDetails->sortByDesc('sent_at')->values();

        return response()->json($chatDetails);
    }
}
