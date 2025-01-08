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
        $message = $chat->messages->find($message->id);

        return new MessageResource($message);
    }

    public function prova(User $user)
    {
        return $user->chats;
    }

    public function allChats(User $user)
    {
        $user_id = Auth::user()->id;

        if ($user->id !== $user_id) {
            return response()->json(['message' => 'Hai il log-in con il profilo sbagliato'], 401);
        }

        // Prima
        // $allChatsID = ChatUser::where('user_id', '=', $user_id)->pluck('chat_id');
        // $chats = Chat::whereIn('id', $allChatsID)->get();
        // Dopo
        $chats = $user->chats;

        // Formatto le chat per avere tutti i dati
        // $chats = $chats->map(function ($chat) use ($user_id) {
        //     $lastMessage = Message::selectLastMessage($chat->id);

        //     return [
        //         'chat_id' => $chat->id,
        //         'chat_name' => User::getChatName($chat->id, $chat->type, $user_id),
        //         'chat_type' => $chat->type,
        //         'icon' => User::getIcon($chat->id, $chat->type, $user_id),
        //         'last_message_content' => $lastMessage['content'],
        //         'last_message_sender_id' => $lastMessage['user_id'],
        //         'message_type' => $lastMessage['message_type'],
        //         'seen' => $lastMessage['seen'],
        //         'sent_at' => $lastMessage['sent_at'],
        //     ];
        // });
        $chats = ChatResource::collection($chats);
        $chats = $chats->sortByDesc('sent_at')->values();  // NON FUNZIONA, NON RIORDINA

        return response()->json($chats);
    }
}