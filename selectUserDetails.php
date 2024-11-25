<?php
header("Access-Control-Allow-Origin: *");
require_once 'connection.php';
function selectUserDetails(mysqli $conn)
{
    // Query per prendere i dettagli dello user (o degli users in caso di chat di gruppo) nella chat selezionata
    $chat_id = isset($_GET['chat_id']) ? $_GET['chat_id'] : '';
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
    $sql = "SELECT u.username, u.icon, IF(c.type = 'group', NULL, u.last_access) AS last_access, IF (c.type = 'group', c.name, '') as name, c.type
            FROM Users u, ChatUsers cu, Chats c
            WHERE u.id = cu.user_id AND c.id = cu.chat_id AND cu.user_id != $user_id AND cu.chat_id = $chat_id";
    $res = $conn->query($sql);

    if (!$res) {
        echo $conn->error . '<br>';
        return;
    }

    $results = [];
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            $results[] = $row;  // Salvo i risultati
        }
    } else {
        echo "Nessun risultato trovato.<br>";
    }

    echo json_encode($results);  // Contverto i risultati in JSON
}

selectUserDetails($mysqli);