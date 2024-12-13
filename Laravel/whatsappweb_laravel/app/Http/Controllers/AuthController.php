<?php

namespace App\Http\Controllers;

use App\Http\Requests\loginUser;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginUser(loginUser $request)
    {

        $user = User::where('username', '=', $request->input('username'))->first();

        if (!$user || !password_verify($request->input('password'), $user->password)) {
            return response()->json(['message' => 'Credenziali errate'], 401);
        }

        // Auth::login($user);

        return response()->json([
            'id' => $user->id,
            'username' => $user->username,
            'icon' => $user->icon,
        ]);
    }

    public function logoutUser(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Log out eseguito con successo']);
    }
}