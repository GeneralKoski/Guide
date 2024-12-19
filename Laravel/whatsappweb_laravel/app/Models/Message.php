<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['chat_id', 'user_id', 'type', 'content', 'sent_at', 'seen'];
    public $timestamps = false;

    public function users()
    {
        return $this->hasOne(User::class);
    }

    public function groupmessages()
    {
        return $this->hasMany(GroupChatMessage::class);
    }

    public function medias()
    {
        return $this->hasOne(Media::class);
    }

    public function chats()
    {
        return $this->hasOne(Chat::class);
    }

    public static function hasChatId($chat_id, $user_id)
    {
        $chatUser = ChatUser::select('chat_id')->where('user_id', '=', $user_id)->where('chat_id', '=', $chat_id)->get();
        return $chatUser;
    }
}