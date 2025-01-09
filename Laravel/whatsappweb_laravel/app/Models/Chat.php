<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Chat extends Model
{
    protected $fillable = ['name', 'type', 'created_at'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'ChatUsers', 'chat_id', 'user_id');
    }

    public function groupmessages()
    {
        return $this->hasMany(GroupChatMessage::class);
    }

    public static function otherUser(Chat $chat)
    {
        return $chat->users->filter(function ($user) {
            return $user->id != Auth::user()->id;
        });
    }
}