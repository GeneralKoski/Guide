<?php

namespace App\Http\Controllers;

use App\Models\GroupChatMessage;

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