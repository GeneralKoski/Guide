<?php

use App\Http\Controllers\ChatAdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSettingController;
use App\Models\ChatUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/test/{chat_id}', [MessageController::class, 'selectLastMessage']);