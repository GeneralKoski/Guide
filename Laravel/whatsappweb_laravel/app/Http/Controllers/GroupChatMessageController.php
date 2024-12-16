<?php

namespace App\Http\Controllers;

use App\Models\GroupChatMessage;
use Illuminate\Http\Request;

class GroupChatMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groupchatmessages = GroupChatMessage::all();
        return view('groupchatmessages.index', ['groupchatmessages' => $groupchatmessages]);
    }
}