<?php

namespace App\Http\Controllers;

use App\Http\Requests\InsertMessage;
use App\Http\Requests\updateSeen;
use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\GroupChatMessage;
use App\Models\Message;
use App\Models\User;
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
        $user_id = Auth::user()->id;
        $chat_id = $request->input('chat_id');
        $chatType = $request->input('chat_type');

        if (!$user_id) {
            return response()->json(['message' => 'Hai il log-in con il profilo sbagliato'], 401);
        }

        $isThere = Message::hasChatId($chat_id, $user_id);
        if (!$isThere) {
            return response()->json(['message' => 'Non puoi aggiornare i non visualizzati perchè non appartieni a questa chat'], 401);
        }

        if ($chatType == 'single') {
            return $this->updateSeenSingle($user_id, $chat_id);
        } else {
            return $this->updateSeenGroup($user_id, $chat_id);
        }
    }

    public function updateSeenSingle($user_id, $chat_id)
    {
        $updateSingle = DB::table('Messages')
            ->where('chat_id', '=', $chat_id)
            ->where('user_id', '!=', $user_id)
            ->where('seen', '=', 'no')
            ->update(['seen' => 'yes']);

        return response()->json($updateSingle
            ? ['success' => true, 'message' => 'DB aggiornato per i messaggi non visualizzati']
            : ['success' => false, 'message' => 'I messaggi sono già tutti visualizzati']);
    }

    public function updateSeenGroup($user_id, $chat_id)
    {
        $updateGroup = DB::table('GroupChatMessages')
            ->where('chat_id', '=', $chat_id)
            ->where('seen_by_user', '=', $user_id)
            ->where('seen', '=', 'no')
            ->update(['seen' => 'yes']);

        return response()->json($updateGroup ? ['message' => 'DB aggiornato per i messaggi non visualizzati'] : ['message' => 'I messaggi sono già tutti visualizzati']);
    }

    public function selectMessages(Chat $chat)
    {
        $chat_id = $chat['id'];
        $user_id = Auth::user()->id;

        $isThere = Message::hasChatId($chat_id, $user_id);
        if (!$isThere) {
            return response()->json(['message' => 'Non puoi vedere i messaggi perchè non appartieni a questa chat'], 401);
        }

        if (!$user_id) {
            return response()->json(['message' => 'Hai il log-in con il profilo sbagliato'], 401);
        }

        $messages = DB::table('Messages AS m')
            ->select(
                'u.id',
                'u.username',
                'm.sent_at',
                'm.seen',
                DB::raw("m.type AS message_type, m.content AS media_content, c.type AS chat_type,
                       CASE WHEN m.type = 'media' THEN (
                                SELECT media.file_path
                                FROM Media media
                                WHERE media.message_id = m.id
                                LIMIT 1
                            )
                            ELSE m.content
                        END AS content
                        ")
            )
            ->join('Users AS u', 'u.id', '=', 'm.user_id')
            ->join('Chats AS c', 'm.chat_id', '=', 'c.id')
            ->leftJoin('ChatUsers AS cu', function ($join) {
                $join
                    ->on('cu.user_id', '=', 'u.id')
                    ->on('cu.chat_id', '=', 'c.id');
            })
            ->where('m.chat_id', '=', $chat_id)
            ->where('m.sent_at', '>', function ($query) use ($chat_id, $user_id) {
                $query
                    ->select('cu2.added_at')
                    ->from('ChatUsers AS cu2')
                    ->where('cu2.chat_id', '=', $chat_id)
                    ->where('cu2.user_id', '=', $user_id);
            })
            ->orderBy('m.sent_at', 'ASC')
            ->get();

        return response()->json($messages);
    }

    public function insertMessage(InsertMessage $request)
    {
        $user_id = Auth::user()->id;
        $chat_id = $request->safe()->input('chat_id');
        $content = $request->safe()->input('content');

        if (!$user_id) {
            return response()->json(['message' => 'Nessun utente loggato'], 401);
        }

        $isThere = Message::hasChatId($chat_id, $user_id);
        if (!$isThere) {
            return response()->json(['message' => 'Non puoi mandare il messaggio perchè non appartieni a questa chat'], 401);
        }

        try {
            $utentichat = ChatUser::utentichat($chat_id, $user_id);

            $request->user()->messages()->create([
                'chat_id' => $chat_id,
                'user_id' => $user_id,
                'type' => 'message',
                'content' => $content,
                'sent_at' => now(),
                'seen' => 'no',
            ]);

            if ($utentichat['nUtenti'] > 1) {
                $lastMessageID = DB::table('Messages')->select('id')->orderBy('sent_at', 'desc')->first();
                $lastMessageID = $lastMessageID->id;

                for ($i = 0; $i < $utentichat['nUtenti']; $i++) {
                    GroupChatMessage::create([
                        'chat_id' => $chat_id,
                        'message_id' => $lastMessageID,
                        'seen_by_user' => $utentichat['IDutenti'][$i],
                        'seen' => 'no',
                    ]);
                }
            }

            $message = Message::selectLastMessage($chat_id);
            return response()->json($message);
        } catch (\Exception $e) {
            return response("Errore nell'inserimento del messaggio: " . $e->getMessage(), 500);
        }
    }

    public function notSeenMessages()
    {
        $user_id = Auth::user()->id;

        $userAuth = Auth::user();
        if ($userAuth->id != $user_id) {
            return response()->json(['message' => 'Hai il log-in con il profilo sbagliato'], 401);
        }

        $notSeen = Message::select('chat_id', DB::raw('COUNT(*) as non_letti'))
            ->where('seen', '=', 'no')
            ->where('user_id', '!=', $user_id)
            ->groupBy('chat_id')
            ->get();

        $notSeen = $notSeen->filter(function ($chat) use ($user_id) {
            $userInChat = Message::hasChatId($chat->chat_id, $user_id);
            return $userInChat;
        });

        return response()->json($notSeen);
    }
}
