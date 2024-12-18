<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = ['message_id', 'media_type', 'file_path', 'file_size', 'uploaded_at'];

    public function messages()
    {
        return $this->hasOne(Message::class);
    }
}