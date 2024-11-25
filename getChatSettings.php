<?php
header("Access-Control-Allow-Origin: *");
require_once 'connection.php';

function getChatSettings(mysqli $conn)
{
    // Query per trovare le impostazioni della chat aperta
    $chat_id = isset($_GET['chat_id']) ? $_GET['chat_id'] : '';
    $sql = "SELECT us.user_id, u.username, us.setting_name, us.setting_value FROM UserSettings us, Users u, ChatUsers cu, Chats c
            WHERE us.user_id = u.id AND u.id = cu.user_id AND c.id = cu.chat_id AND c.type='single' AND cu.chat_id = $chat_id";
    $res = $conn->query($sql);

    if (!$res) {
        echo $conn->error . '<br>';
        return;
    }

    $results = [];
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $results[] = $row;  // Salvo i risultati in un array
        }
    }
    if (!empty($results)) {
        echo json_encode($results);  // Contverto i risultati in JSON
    } else {
        echo 0;
    }
}

getChatSettings($mysqli);