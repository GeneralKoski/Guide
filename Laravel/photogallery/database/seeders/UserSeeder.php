<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // for ($i = 0; $i < 30; $i++) {
        //     $sql = 'insert into users (name, email, email_verified_at, password, created_at) values (?, ?, ?, ?, ?)';
        //     $name = Str::random(10);
        //     DB::insert($sql, [$name, $name . '@gmail.com', Carbon::now(), Hash::make('password'), Carbon::now()]);
        // }
        // User::factory(30)->create();
    }
}