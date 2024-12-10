<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $fillable = ['user_id', 'setting_name', 'setting_value', 'updated_at'];
}