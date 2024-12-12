<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['username', 'password', 'icon', 'last_access'];
    public function usersettings()
    {
        return $this->hasMany(UserSetting::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function chatusers()
    {
        return $this->hasMany(ChatUser::class);
    }

    public function groupmessages()
    {
        return $this->hasMany(GroupChatMessage::class);
    }
};