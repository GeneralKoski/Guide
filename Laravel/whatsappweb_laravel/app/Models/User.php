<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

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

    public static function getOtherUserId($chat_id, $user_id)
    {
        $otherUser = ChatUser::select('user_id')->where('chat_id', '=', $chat_id)->where('user_id', '!=', $user_id)->get();
        return $otherUser[0]['user_id'];
    }

    public static function getChatName($chat_id, $chat_type, $user_id)
    {
        if ($chat_type === 'single') {
            $otherUser = User::getOtherUserId($chat_id, $user_id);

            $chat_name = User::select('username')->where('id', '=', $otherUser)->get();
            $chat_name = $chat_name[0]['username'];
        } else {
            $chat_name = Chat::select('name')->where('id', '=', $chat_id)->get();
            $chat_name = $chat_name[0]['name'];
        }

        return $chat_name;
    }

    public static function getIcon($chat_id, $chat_type, $user_id)
    {
        if ($chat_type === 'single') {
            $otherUser = User::getOtherUserId($chat_id, $user_id);

            $icon = User::select('icon')->where('id', '=', $otherUser)->get();
            $icon = $icon[0]['icon'];
        } else {
            $icon = null;
        }

        return $icon;
    }
};