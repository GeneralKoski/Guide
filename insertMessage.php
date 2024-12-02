<?php
header("Access-Control-Allow-Origin: *");
require_once 'connection.php';

$chat_id = isset($_POST['chat_id']) ? $_POST['chat_id'] : '';
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
$content = isset($_POST['content']) ? $_POST['content'] : '';

// Verifica se i parametri sono settati correttamente
if ($chat_id && $user_id && $content) {
    echo "Parametri ricevuti: chat_id = $chat_id, user_id = $user_id, content = $content\n";

    // Prova a eseguire l'inserimento
    insertMessages($chat_id, $user_id, $content, $mysqli);
} else {
    echo "Parametri mancanti. chat_id: $chat_id, user_id: $user_id, content: $content";
}

function insertMessages($chat_id, $user_id, $content, mysqli $conn)
{
    if ($chat_id != 7 && $chat_id != 12) {
        $sql = 'INSERT INTO Messages (chat_id, user_id, type, content, sent_at, seen) VALUES ';
        $sql .= " ('$chat_id','$user_id', 'message' ,'$content', NOW(), 'no') ";
        $res = $conn->query($sql);
        if (!$res) {
            echo "Errore nella query SQL: " . $conn->error . "\n";
        }
        echo "Messaggio inserito con successo.";
    }
}
