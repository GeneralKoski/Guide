<?php

namespace App\Http\Controllers;

use App\Events\NewAccess;
use App\Http\Requests\loginUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginUser(loginUser $request)
    {
        $user = User::where('username', '=', $request->username)->first();

        if (!$user || !password_verify($request->password, $user->password)) {
            return response()->json(['message' => 'Credenziali errate'], 401);
        } else {
            $token = $user->createToken($user->username);

            event(new NewAccess($user));

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

    public function verifyToken()
    {
        $user = Auth::user();

        if ($user instanceof User) {
            event(new NewAccess($user));
            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'icon' => $user->icon,
                ],
                'message' => 'Utente autenticato con successo',
            ]);
        } else {
            return response()->json(['message' => 'Erorre'], 401);
        }
    }
}
