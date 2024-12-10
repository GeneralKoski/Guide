<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatUser extends Model
{
    protected $table = 'chatusers';
    protected $fillable = ['user_id', 'chat_id', 'added_at'];
}