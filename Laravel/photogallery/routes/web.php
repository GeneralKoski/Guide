<?php

use App\Http\Controllers\{AlbumsController, ProfileController};
use App\Models\{User, Album};
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/users', function () {
    return User::with('albums')->paginate(1);
});

// Route::get('/albums', [AlbumsController::class, 'index']);
Route::resource('albums', AlbumsController::class);
Route::delete('/albums/{album}', [AlbumsController::class, 'destroy']);
Route::get('/albums/{album}', [AlbumsController::class, 'show']);

require __DIR__ . '/auth.php';