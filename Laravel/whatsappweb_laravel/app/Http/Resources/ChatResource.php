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
        $user_id = Auth::user()->id;
        $lastMessage = Message::selectLastMessage($this->id);

        return [
            'chat_id' => $this->id,
            'chat_name' => User::getChatName($this->id, $this->type, $user_id),
            'chat_type' => $this->type,
            'icon' => User::getIcon($this->id, $this->type, $user_id),
            'last_message_content' => $lastMessage['content'],
            'last_message_sender_id' => $lastMessage['user_id'],
            'message_type' => $lastMessage['message_type'],
            'seen' => $lastMessage['seen'],
            'sent_at' => $lastMessage['sent_at'],
        ];
    }
}
