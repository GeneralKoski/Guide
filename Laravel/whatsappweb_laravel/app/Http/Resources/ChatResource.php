<?php

namespace App\Http\Resources;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = Auth::user();

        $chatNameIcon = $this->type === 'group'
            ? ['username' => $this->name]
            : $this->users->filter(function ($chatUser) use ($user) {
                return $chatUser->id != $user->id;
            })->map(function ($chatUser) {
                return ['username' => $chatUser->username, 'icon' => $chatUser->icon];
            })->first();

        return [
            'chat_id' => $this->id,
            'chat_name' => $chatNameIcon['username'],
            'chat_type' => $this->type,
            'icon' => $chatNameIcon['icon'] ?? '',
            'last_message_content' => $this->lastMessage->content,
            'last_message_sender_id' => $this->lastMessage->user_id,
            'message_type' => $this->lastMessage->type,
            'seen' => $this->lastMessage->seen,
            'sent_at' => $this->lastMessage->sent_at,
        ];
    }
}