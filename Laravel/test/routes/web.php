<?php

use App\Http\Controllers\UserDetail;
use App\Http\Controllers\UsersController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::resource('users', UsersController::class);
Route::get('users/{user}/details', UserDetail::class)->name('users.details');
Route::get('/', static fn() => view('welcome'));
// Route::redirect('/', 'users');

// Route::get('users', static function () {
//     return User::all();
// });

// Route::view('users/{name?}/{email?}/{age?}', 'users.userDetails')->whereAlpha('name')->whereAlpha('email')->whereNumber('age')->defaults('age', 0);

// Route::get('users/{user}', static function (User $user) {
//     return $user;
// })->whereNumber('user');


// Route::get('users/{name?}/{email?}/{age?}', static function (?string $name = '', ?string $email = '', ?int $age = 0) {
//     return "$name $email $age";
// })->whereAlpha('name')->whereAlpha('email')->whereNumber('age');