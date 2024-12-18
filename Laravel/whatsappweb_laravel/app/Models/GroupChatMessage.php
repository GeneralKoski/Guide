<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupChatMessage extends Model
{
    protected $table = 'groupchatmessages';
    protected $fillable = ['chat_id', 'message_id', 'seen_by_user', 'seen'];

    public function messages()
    {
        return $this->hasOne(Message::class);
    }

    public function chats()
    {
        return $this->hasOne(Chat::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}