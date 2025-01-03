<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatAdmin extends Model
{
    protected $table = 'chatadmins';
    protected $fillable = ['Achat_id', 'Auser_id'];

    public function chatusers()
    {
        return $this->hasMany(ChatUser::class);
    }
}