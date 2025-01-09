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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function hasChatId($chat_id, $user_id)
    {
        $chatUser = ChatUser::select('chat_id')->where('user_id', '=', $user_id)->where('chat_id', '=', $chat_id)->first();
        return $chatUser;
    }

    public static function selectLastMessage(int $chat_id)
    {
        $message = Message::where('chat_id', '=', $chat_id)->orderBy('sent_at', 'desc')->first();
        $message = [
            'id' => $message->id,
            'user_id' => $message->user_id,
            'username' => User::find($message->user_id)->username,
            'sent_at' => $message->sent_at ? $message->sent_at : 'no',
            'seen' => $message->seen,
            'message_type' => $message->type,
            'media_content' => $message->content,
            'chat_type' => Chat::find($message->chat_id)->type,
            'content' => $message->content,
        ];
        return $message;
    }
}