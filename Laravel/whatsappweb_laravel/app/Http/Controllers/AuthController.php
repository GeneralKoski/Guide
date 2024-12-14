<?php

namespace App\Http\Controllers;

use App\Http\Requests\loginUser;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginUser(loginUser $request)
    {
        $user = User::where('username', '=', $request->username)->first();

        if (!$user || !password_verify($request->password, $user->password)) {
            return response()->json(['message' => 'Credenziali errate'], 401);
        } else {
            $token = $user->createToken($user->username);

            return response()->json([
                'id' => $user->id,
                'username' => $user->username,
                'icon' => $user->icon,
                'token' => $token->plainTextToken,
            ]);
        }
    }

    public function logoutUser(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Log out eseguito con successo']);
    }
}