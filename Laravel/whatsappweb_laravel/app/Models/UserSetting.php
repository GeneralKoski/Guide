<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSetting extends Model
{
    protected $table = 'usersettings';
    protected $fillable = ['user_id', 'setting_name', 'setting_value', 'updated_at'];

    public function users()
    {
        return $this->hasOne(User::class);
    }
}