<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupChatMessage extends Model
{
    protected $table = 'groupchatmessages';
    protected $fillable = ['chat_id', 'message_id', 'seen_by_user', 'seen'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}