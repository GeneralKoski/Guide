<?php
header("Access-Control-Allow-Origin: *");
require_once 'connection.php';
function notSeenMessagesPerChatSingle(mysqli $conn)
{
    $chat_id = isset($_GET['chat_id']) ? $_GET['chat_id'] : '';
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
    $sql = "SELECT count(*) as tosee FROM Messages m WHERE m.user_id != $user_id AND chat_id = $chat_id
            -- Controllo se il messaggio da contare è stato mandato dopo l'ultimo messaggio inviato dall'utente loggato, se non ha messaggi li conto tutti (dopo la data definita in coalesce)
            AND m.sent_at > (SELECT COALESCE(MAX(m1.sent_at), '1900-01-01 00:00:00') FROM Messages m1 WHERE m1.user_id = $user_id AND m1.chat_id = $chat_id) AND m.seen = 'no'
        ";

    $res = $conn->query($sql);

    if (!$res) {
        echo $conn->error . '<br>';
        return;
    }

    $result = 0;

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $result = (int) $row['tosee'];
    } else {
        echo "Nessun risultato trovato.<br>";
    }

    echo $result;
}

notSeenMessagesPerChatSingle($mysqli);