<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupChatMessage extends Model
{
    protected $fillable = ['chat_id', 'message_id', 'seen_by_user', 'seen'];
}