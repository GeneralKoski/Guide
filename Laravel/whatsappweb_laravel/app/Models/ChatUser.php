<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatUser extends Model
{
    protected $table = 'chatusers';
    protected $fillable = ['user_id', 'chat_id', 'added_at'];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function chatadmins()
    {
        return $this->hasMany(ChatAdmin::class);
    }
}