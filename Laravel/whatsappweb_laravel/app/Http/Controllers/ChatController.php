<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatResource;
use App\Http\Resources\MessageResource;
use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function chatMessages(Chat $chat)
    {
        $messages = $chat->messages;
        return MessageResource::collection($messages);
    }

    public function chatMessage(Chat $chat, Message $message)
    {
        if ($message->chat_id !== $chat->id) {
            return response()->json(['error' => 'Message does not belong to the specified chat'], 403);
        }
        return new MessageResource($message);
    }

    public function allChats(User $user)
    {
        $user_id = Auth::user()->id;

        if ($user->id !== $user_id) {
            return 'Richiesta errata';
        }

        // Trovo gli ID delle chat alle quali l'utente partecipa
        $allChatsID = ChatUser::where('user_id', '=', $user_id)->pluck('chat_id');

        // Trovo i dettagli delle chat con ID contenuti nell'array trovato prima
        $chats = Chat::whereIn('id', $allChatsID)->get();

        $chats = ChatResource::collection($chats, $user_id);

        // Ritorno formattando
        return response()->json(ChatResource::collection($chats));

        // $chats = $chats->map(function ($chat) use ($user_id) {
        //     $lastMessage = Message::selectLastMessage($chat->id);

        // return [
        //     'chat_id' => $chat->id,
        //     'chat_name' => User::getChatName($chat->id, $chat->type, $user_id),
        //     'chat_type' => $chat->type,
        //     'icon' => User::getIcon($chat->id, $chat->type, $user_id),
        //     'last_message_content' => $lastMessage['content'],
        //     'last_message_sender_id' => $lastMessage['user_id'],
        //     'message_type' => $lastMessage['message_type'],
        //     'seen' => $lastMessage['seen'],
        //     'sent_at' => $lastMessage['sent_at'],
        // ];
        // });

        // $chats = $chats->sortByDesc('sent_at')->values();
    }
}