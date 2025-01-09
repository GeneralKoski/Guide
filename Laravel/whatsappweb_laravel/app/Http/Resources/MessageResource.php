<?php

namespace App\Http\Resources;

use App\Models\Chat;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'content' => $this->content,
            'message_type' => $this->type,
            'seen' => $this->seen,
            'sent_at' => $this->sent_at,
            'id' => $this->id,
            'chat_id' => $this->chat_id,
            'media' => $this->type !== 'media' ? $this->content : Media::where('message_id', '=', $this->id)->pluck('file_path'),
            'chat_type' => $this->chat_type,
            'username' => $this->username,
        ];
    }
}