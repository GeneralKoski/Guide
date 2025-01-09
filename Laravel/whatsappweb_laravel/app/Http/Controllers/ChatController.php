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

        $chats = $user->chats;

        $chats = ChatResource::collection($chats);
        $chats = collect($chats->toArray(request()))->sortByDesc('sent_at')->values();

        return response()->json($chats);
    }
}