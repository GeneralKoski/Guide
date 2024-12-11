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

    // public function lastMessage()
    // {
    //     return $this->hasOne(Message::class)->where("date" >);
    // }
}