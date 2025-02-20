<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatAdmin;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class ChatAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = ChatAdmin::all();
        return view('chatadmins.index', ['admins' => $admins]);
    }

    public function checkIfAdmin(Chat $chat)
    {
        $Achat_id = $chat['id'];
        $Auser_id = Auth::user()->id;

        if (!$Auser_id) {
            return response()->json(['message' => 'Hai il log-in con il profilo sbagliato'], 401);
        }

        $isThere = Message::hasChatId($Achat_id, $Auser_id);
        if (!$isThere) {
            return response()->json(['message' => 'Non puoi vedere gli admin perchè non appartieni a questa chat'], 401);
        }

        $isAdmin = ChatAdmin::where('Achat_id', '=', $Achat_id)
            ->where('Auser_id', '=', $Auser_id)
            ->exists();

        return $isAdmin ? ['isAdmin' => 'true'] : ['isAdmin' => 'false'];
    }
}