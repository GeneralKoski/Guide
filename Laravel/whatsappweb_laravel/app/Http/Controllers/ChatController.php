<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChatResource;
use App\Http\Resources\MessageResource;
use App\Models\Chat;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function prova()
    {
        //
    }

    public function allChats()
    {
        $user = Auth::user();

        if ($user instanceof User) {
            $chats = $user->chats()->with(['lastMessage', 'users'])->get();

            $chats = ChatResource::collection($chats);
            $chats = collect($chats->toArray(request()))->sortByDesc('sent_at')->values();

            return response()->json($chats);
        } else {
            return response()->json(['message' => 'Utente non trovato'], 404);
        }
    }
}