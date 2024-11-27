<?php
header("Access-Control-Allow-Origin: *");
require_once 'connection.php';
function notSeenMessagesPerChatGroup(mysqli $conn)
{
    $chat_id = isset($_GET['chat_id']) ? $_GET['chat_id'] : '';
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
    $sql = "SELECT COUNT(*) as tosee FROM `GroupChatMessages` gcm WHERE gcm.seen_by_user = $user_id AND gcm.chat_id = $chat_id AND gcm.seen = 'no'
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

notSeenMessagesPerChatGroup($mysqli);