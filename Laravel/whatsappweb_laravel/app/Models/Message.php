<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['chat_id', 'user_id', 'type', 'content', 'sent_at', 'seen'];
    public $timestamps = false;

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function groupmessages()
    {
        return $this->hasMany(GroupChatMessage::class);
    }

    public function medias()
    {
        return $this->hasMany(Media::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    // public function lastMessage()
    // {
    //     return $this->hasOne(Message::class)->where();
    // }
}