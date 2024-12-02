<?php
header("Access-Control-Allow-Origin: *");
require_once 'connection.php';
function selectAllChats(mysqli $conn)
{
    // Query per trovare tutte le chat alle quali appartiene l'utente loggato
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
    $sql = "SELECT chat_id, non_letti 
            FROM (SELECT gcm.chat_id, COUNT(*) as non_letti FROM GroupChatMessages gcm WHERE gcm.seen_by_user = $user_id AND gcm.seen = 'no' GROUP BY gcm.chat_id UNION ALL
                SELECT m.chat_id, COUNT(*) as non_letti FROM Messages m WHERE m.seen = 'no' AND m.chat_id IN (SELECT c.id FROM Chats c WHERE c.type = 'single') AND
                       m.chat_id IN (SELECT cu.chat_id FROM ChatUsers cu WHERE user_id = $user_id) AND m.user_id != $user_id GROUP BY m.chat_id) as daVisualizzare 
                GROUP BY chat_id;
    ";

    $res = $conn->query($sql);

    if (!$res) {
        echo $conn->error . '<br>';
        return;
    }

    $results = [];
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $results[] = $row;
        }
    }

    $results = json_encode($results);  // Contverto i risultati in JSON
    echo $results;
}

selectAllChats($mysqli);