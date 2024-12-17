<?php

namespace App\Http\Controllers;

use App\Events\NewMessageSent;
use App\Http\Requests\checkUserChatIDS;
use App\Http\Requests\checkUserID;
use App\Http\Requests\InsertMessage;
use App\Http\Requests\updateSeen;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
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
        $user_id = $request->input('user_id');
        $chat_id = $request->input('chat_id');
        $chatType = $request->input('chat_type');

        $userAuth = Auth::user();
        if ($userAuth->id != $user_id) {
            return response()->json(['message' => 'Hai il log-in con il profilo sbagliato'], 401);
        }

        $isThere = Message::hasChatId($chat_id, $user_id);
        if (!$isThere) {
            return response()->json(['message' => 'Non puoi aggiornare i non visualizzati perchè non appartieni a questa chat'], 401);
        }

        if ($chatType == "single") {
            $this->updateSeenSingle($user_id, $chat_id);
        } else {
            $this->updateSeenGroup($user_id, $chat_id);
        }
    }

    public function updateSeenSingle($user_id, $chat_id)
    {
        $updatesSingle = DB::table('Messages')
            ->where('chat_id', '=', $chat_id)
            ->where('user_id', '!=', $user_id)
            ->where('seen', '=', 'no')
            ->update(['seen' => 'yes']);

        return $updatesSingle ? "Cambiato" : "No bono";
    }
    public function updateSeenGroup($user_id, $chat_id)
    {
        $updatesGroup = DB::table('GroupChatMessages')
            ->where('chat_id', '=', $chat_id)
            ->where('seen_by_user', '=', $user_id)
            ->where('seen', '=', 'no')
            ->update(['seen' => 'yes']);
        return $updatesGroup ? "Cambiato" : "No bono";
    }
    public function selectLastSingleMessage(checkUserChatIDS $request)
    {
        $chat_id = $request->input('chat_id');
        $user_id = $request->input('user_id');

        $singleMessages = DB::table('Messages AS m')
            ->select(
                'u.id',
                'u.username',
                'm.sent_at',
                'cu.added_at',
                DB::raw("m.type AS message_type, m.content AS media_content, c.type AS chat_type,
                           CASE WHEN m.type = 'media' THEN (
                                    SELECT media.file_path
                                    FROM Media media
                                    WHERE media.message_id = m.id
                                    LIMIT 1
                                )
                                ELSE m.content
                            END AS content,
                            IF (m.user_id = $user_id AND sent_at < (SELECT MAX(m1.sent_at) FROM Messages m1 WHERE user_id != $user_id AND chat_id = $chat_id), 'yes', seen) AS seen")
            )
            ->join('Users AS u', 'u.id', '=', 'm.user_id')
            ->join('Chats AS c', 'm.chat_id', '=', 'c.id')
            ->leftJoin('ChatUsers AS cu', function ($join) {
                $join->on('cu.user_id', '=', 'u.id')
                    ->on('cu.chat_id', '=', 'c.id');
            })
            ->where('c.type', '=', 'single')
            ->where('m.chat_id', '=', $chat_id)
            ->where('m.sent_at', '>', function ($query) use ($chat_id, $user_id) {
                $query->select('cu2.added_at')
                    ->from('ChatUsers AS cu2')
                    ->where('cu2.chat_id', '=', $chat_id)
                    ->where('cu2.user_id', '=', $user_id);
            })
            ->orderBy('m.sent_at', 'DESC')
            ->limit(1)
            ->get();

        return response()->json($singleMessages);
    }
    public function selectSingleMessages(checkUserChatIDS $request)
    {
        $chat_id = $request->input('chat_id');
        $user_id = $request->input('user_id');

        $isThere = Message::hasChatId($chat_id, $user_id);
        if (!$isThere) {
            return response()->json(['message' => 'Non puoi vedere i messaggi perchè non appartieni a questa chat'], 401);
        }

        $userAuth = Auth::user();
        if ($userAuth->id != $user_id) {
            return response()->json(['message' => 'Hai il log-in con il profilo sbagliato'], 401);
        }

        $singleMessages = DB::table('Messages AS m')
            ->select(
                'u.id',
                'u.username',
                'm.sent_at',
                'cu.added_at',
                DB::raw("m.type AS message_type, m.content AS media_content, c.type AS chat_type,
                           CASE WHEN m.type = 'media' THEN (
                                    SELECT media.file_path
                                    FROM Media media
                                    WHERE media.message_id = m.id
                                    LIMIT 1
                                )
                                ELSE m.content
                            END AS content,
                            IF (m.user_id = $user_id AND sent_at < (SELECT MAX(m1.sent_at) FROM Messages m1 WHERE user_id != $user_id AND chat_id = $chat_id), 'yes', seen) AS seen")
            )
            ->join('Users AS u', 'u.id', '=', 'm.user_id')
            ->join('Chats AS c', 'm.chat_id', '=', 'c.id')
            ->leftJoin('ChatUsers AS cu', function ($join) {
                $join->on('cu.user_id', '=', 'u.id')
                    ->on('cu.chat_id', '=', 'c.id');
            })
            ->where('c.type', '=', 'single')
            ->where('m.chat_id', '=', $chat_id)
            ->where('m.sent_at', '>', function ($query) use ($chat_id, $user_id) {
                $query->select('cu2.added_at')
                    ->from('ChatUsers AS cu2')
                    ->where('cu2.chat_id', '=', $chat_id)
                    ->where('cu2.user_id', '=', $user_id);
            })
            ->orderBy('m.sent_at', 'ASC')
            ->get();

        return response()->json($singleMessages);
    }

    public function selectGroupMessages(checkUserChatIDS $request)
    {
        $chat_id = $request->input('chat_id');
        $user_id = $request->input('user_id');

        $userAuth = Auth::user();
        if ($userAuth->id != $user_id) {
            return response()->json(['message' => 'Hai il log-in con il profilo sbagliato'], 401);
        }

        $isThere = Message::hasChatId($chat_id, $user_id);
        if (!$isThere) {
            return response()->json(['message' => 'Non puoi vedere i messaggi perchè non appartieni a questa chat'], 401);
        }

        $groupMessages = DB::table('Messages AS m')
            ->select(
                'u.id',
                'u.username',
                'm.sent_at',
                'cu.added_at',
                'm.id',
                DB::raw("m.type AS message_type, m.content AS media_content, c.type AS chat_type,
            CASE WHEN m.type = 'media' THEN (
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
            ) AS seen")
            )
            ->join('Users AS u', 'u.id', '=', 'm.user_id')
            ->join('Chats AS c', 'm.chat_id', '=', 'c.id')
            ->leftJoin('ChatUsers AS cu', function ($join) {
                $join->on('cu.user_id', '=', 'u.id')
                    ->on('cu.chat_id', '=', 'c.id');
            })
            ->where('m.chat_id', '=', $chat_id)
            ->where('m.sent_at', '>', function ($query) use ($chat_id, $user_id) {
                $query->select('cu2.added_at')
                    ->from('ChatUsers as cu2')
                    ->where('cu2.chat_id', '=', $chat_id)
                    ->where('cu2.user_id', '=', $user_id);
            })
            ->orderBy('m.sent_at', 'ASC')
            ->get();

        return response()->json($groupMessages);
    }

    public function insertMessage(InsertMessage $request)
    {
        $chat_id = $request->input('chat_id');
        $user_id = $request->input('user_id');
        $content = $request->input('content');

        $userAuth = Auth::user();
        if ($userAuth->id != $user_id) {
            return response()->json(['message' => 'Hai il log-in con il profilo sbagliato'], 401);
        }

        $isThere = Message::hasChatId($chat_id, $user_id);
        if (!$isThere) {
            return response()->json(['message' => 'Non puoi mandare il messaggio perchè non appartieni a questa chat'], 401);
        }

        try {
            $request->user()->messages()->create([
                'chat_id' => $chat_id,
                'user_id' => $user_id,
                'type' => 'message',
                'content' => $content,
                'sent_at' => now(),
                'seen' => 'no',
            ]);

            return $this->selectLastSingleMessage(new checkUserChatIDS([
                'chat_id' => $chat_id,
                'user_id' => $user_id,
            ]));
        } catch (\Exception $e) {
            return response('Errore nell\'inserimento del messaggio: ' . $e->getMessage(), 500);
        }
    }

    public function notSeenMessages(checkUserID $request)
    {
        $user_id = $request->input('user_id');

        $userAuth = Auth::user();
        if ($userAuth->id != $user_id) {
            return response()->json(['message' => 'Hai il log-in con il profilo sbagliato'], 401);
        }

        $singleChats = DB::table('Chats')
            ->select('id')
            ->where('type', '=', 'single');
        $userChats = DB::table('ChatUsers')
            ->select('chat_id')
            ->where('user_id', '=', $user_id);

        $notSeenMessages = DB::table('Messages')
            ->select('chat_id', DB::raw('COUNT(*) AS non_letti'))
            ->where('seen', '=', 'no')
            ->whereIn('chat_id', $singleChats)
            ->whereIn('chat_id', $userChats)
            ->where('user_id', '!=', $user_id)
            ->groupBy('chat_id');

        $notSeenGCM = DB::table('GroupChatMessages')
            ->select('chat_id', DB::raw('COUNT(*) AS non_letti'))
            ->where('seen_by_user', '=', $user_id)
            ->where('seen', '=', 'no')
            ->unionAll($notSeenMessages)
            ->groupBy('chat_id')
            ->get();

        return response()->json($notSeenGCM);
    }
}