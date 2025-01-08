<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = ['name', 'type', 'created_at'];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'ChatUsers', 'chat_id', 'user_id');
    }

    public function groupmessages()
    {
        return $this->hasMany(GroupChatMessage::class);
    }
}
