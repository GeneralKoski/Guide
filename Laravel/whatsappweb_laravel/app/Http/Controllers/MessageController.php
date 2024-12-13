<?php

namespace App\Http\Controllers;

use App\Http\Requests\checkUserChatIDS;
use App\Http\Requests\checkUserID;
use App\Http\Requests\InsertMessage;
use App\Http\Requests\updateSeen;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Message::all();
        return view('messages.index', ['messages' => $messages]);
    }

    public function updateSeen(updateSeen $request)
    {
        $userId = $request->input('user_id');
        $chatId = $request->input('chat_id');
        $chatType = $request->input('chat_type');

        if ($chatType == "single") {
            $this->updateSeenSingle($userId, $chatId);
        } else {
            $this->updateSeenGroup($userId, $chatId);
        }
    }

    public function updateSeenSingle($userId, $chatId)
    {
        $updatesSingle = DB::table('Messages')
            ->where('chat_id', '=', $chatId)
            ->where('user_id', '!=', $userId)
            ->where('seen', '=', 'no')
            ->update(['seen' => 'yes']);
    }
    public function updateSeenGroup($userId, $chatId)
    {
        $updatesGroup = DB::table('GroupChatMessages')
            ->where('chat_id', '=', $chatId)
            ->where('seen_by_user', '=', $userId)
            ->where('seen', '=', 'no')
            ->update(['seen' => 'yes']);
    }
    public function selectSingleMessages(checkUserChatIDS $request)
    {
        $chatId = $request->input('chat_id');
        $userId = $request->input('user_id');

        $singleMessagesRAW = DB::select("SELECT u.id, u.username, m.type as message_type, m.sent_at, m.content as media_content, c.type as chat_type, cu.added_at,

        CASE
            WHEN m.type = 'media' THEN (
                SELECT media.file_path
                FROM Media media
                WHERE media.message_id = m.id
                LIMIT 1
            )
            ELSE m.content
        END AS content,


        IF (m.user_id = $userId AND sent_at < (SELECT MAX(m1.sent_at) FROM Messages m1 WHERE user_id != $userId AND chat_id = $chatId), 'yes', seen) as seen
        FROM Messages m
        JOIN Users u ON u.id = m.user_id
        JOIN Chats c ON m.chat_id = c.id
        LEFT JOIN ChatUsers cu ON cu.user_id = u.id AND cu.chat_id = c.id

        WHERE c.type = 'single' AND m.chat_id = $chatId AND m.sent_at > (SELECT cu2.added_at FROM ChatUsers cu2 WHERE cu2.chat_id = $chatId AND cu2.user_id = $userId)
        ORDER BY m.sent_at ASC;");

        return response()->json($singleMessagesRAW);
    }

    public function selectGroupMessages(checkUserChatIDS $request)
    {
        $chatId = $request->input('chat_id');
        $userId = $request->input('user_id');

        $groupMessages = DB::select("SELECT u.id, u.username, m.type as message_type, m.sent_at, m.content as media_content, c.type as chat_type, cu.added_at, m.id,
        CASE
            WHEN m.type = 'media' THEN (
                SELECT media.file_path
                FROM Media media
                WHERE media.message_id = m.id
                LIMIT 1
            )
            ELSE m.content
        END AS content,

        IF(
        (SELECT COUNT(*) FROM GroupChatMessages gcm WHERE gcm.seen = 'yes' AND gcm.message_id = m.id) =
        (SELECT COUNT(*) FROM ChatUsers cu WHERE cu.chat_id = m.chat_id AND cu.user_id != m.user_id),
        'yes',
        'no'
    ) as seen
        FROM Messages m
        JOIN Users u ON u.id = m.user_id
        JOIN Chats c ON m.chat_id = c.id
        LEFT JOIN ChatUsers cu ON cu.user_id = u.id AND cu.chat_id = c.id

        WHERE m.chat_id = $chatId AND m.sent_at > (SELECT cu2.added_at FROM ChatUsers cu2 WHERE cu2.chat_id = $chatId AND cu2.user_id = $userId)
        ORDER BY m.sent_at ASC;");

        return response()->json($groupMessages);
    }

    public function insertMessage(InsertMessage $request)
    {
        $chat_id = $request->input('chat_id');
        $user_id = $request->input('user_id');
        $content = $request->input('content');

        try {
            Message::create([
                'chat_id' => $chat_id,
                'user_id' => $user_id,
                'type' => 'message',
                'content' => $content,
                'sent_at' => now(),
                'seen' => 'no',
            ]);
            return response('Messaggio inserito con successo.', 200);
        } catch (\Exception $e) {
            return response('Errore nell\'inserimento del messaggio: ' . $e->getMessage(), 500);
        }
    }

    public function notSeenMessages(checkUserID $request)
    {
        $user_id = $request->input('user_id');

        $singleChats = DB::table('Chats')
            ->select('id')
            ->where('type', '=', 'single');
        $userChats = DB::table('ChatUsers')
            ->select('chat_id')
            ->where('user_id', '=', $user_id);

        $notSeenMessages = DB::table('Messages')
            ->select('chat_id', DB::raw('COUNT(*) as non_letti'))
            ->where('seen', '=', 'no')
            ->whereIn('chat_id', $singleChats)
            ->whereIn('chat_id', $userChats)
            ->where('user_id', '!=', $user_id)
            ->groupBy('chat_id');

        $notSeenGCM = DB::table('GroupChatMessages')
            ->select('chat_id', DB::raw('COUNT(*) as non_letti'))
            ->where('seen_by_user', '=', $user_id)
            ->where('seen', '=', 'no')
            ->unionAll($notSeenMessages)
            ->groupBy('chat_id')
            ->get();

        return response()->json($notSeenGCM);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}