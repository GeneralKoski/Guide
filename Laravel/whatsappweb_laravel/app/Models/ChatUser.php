<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public static function utentichat(string $chat_id, string $user_id)
    {
        $IDutenti = DB::table('ChatUsers')->where('chat_id', $chat_id)->where('user_id', '!=', $user_id)->pluck('user_id');
        $nUtenti = $IDutenti->count();

        return ['IDutenti' => $IDutenti, 'nUtenti' => $nUtenti];
    }
}