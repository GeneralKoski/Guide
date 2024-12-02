<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
require_once 'connection.php';

$putData = file_get_contents('php://input');
$data = json_decode($putData, true);
var_dump($data);

$user_id = isset($data['user_id']) ? $data['user_id'] : '';
$chat_id = isset($data['chat_id']) ? $data['chat_id'] : '';
$chat_type = isset($data['chat_type']) ? $data['chat_type'] : '';

if ($user_id && $chat_id && $chat_type) {
    echo "Parametri ricevuti: user_id = $user_id, chat_id = $chat_id, chat_type = $chat_type\n";
    if ($chat_type == "single") {
        updateSeenMessagesSingle($user_id, $chat_id, $mysqli);
    } else {
        updateSeenMessagesGroup($user_id, $chat_id, $mysqli);
    }
    echo "\nVisualizzazione aggiornata a yes";
} else {
    echo "Parametri mancanti. user_id: $user_id, chat_id: $chat_id, chat_type: $chat_type";
}

function updateSeenMessagesSingle($user_id, $chat_id, mysqli $conn)
{
    $sql = "UPDATE Messages SET seen = 'yes' WHERE chat_id = $chat_id AND user_id != $user_id AND seen = 'no'";
    $res = $conn->query($sql);

    if (!$res) {
        echo $conn->error . '<br>';
        return;
    }
}

function updateSeenMessagesGroup($user_id, $chat_id, mysqli $conn)
{
    $sql = "UPDATE GroupChatMessages SET seen = 'yes' WHERE chat_id = $chat_id AND seen_by_user = $user_id AND seen = 'no'";
    $res = $conn->query($sql);

    if (!$res) {
        echo $conn->error . '<br>';
        return;
    }
}