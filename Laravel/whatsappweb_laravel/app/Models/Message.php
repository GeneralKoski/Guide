<?php

namespace App\Models;

use App\Http\Requests\checkUserChatIDS;
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

    public static function hasChatId($chat_id, $user_id)
    {
        $chatusers = ChatUser::select('chat_id')->where('user_id', '=', $user_id)->get();
        $isThere = $chatusers->contains('chat_id', $chat_id);
        return $isThere ? true : false;
    }
}