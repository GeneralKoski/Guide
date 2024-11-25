<?php
header("Access-Control-Allow-Origin: *");
require_once 'connection.php';
function selectAllChats(mysqli $conn)
{
    // Query per trovare tutte le chat alle quali appartiene l'utente loggato
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
    $sql = "SELECT c.id as chat_id, c.type as chat_type, 
    -- Se la chat è 'single', mi prendo l'icona dell'utente, se no (fatto in react) ha la default icon
       CASE 
           WHEN c.type = 'single' THEN (
               SELECT u.icon 
               FROM ChatUsers cu
               JOIN Users u ON u.id = cu.user_id 
               WHERE cu.chat_id = c.id AND cu.user_id != $user_id
               LIMIT 1
           )
       END AS icon,
       
    -- Se la chat è 'single', prendo lo username dalla tabella Users della chat specifica, se no è di tipo 'group' e prendo il nome definito nella tabella Chats
        CASE 
            WHEN c.type = 'single' THEN (
                SELECT u.username
                FROM ChatUsers cu
                JOIN Users u ON u.id = cu.user_id 
                WHERE cu.chat_id = c.id AND cu.user_id != $user_id
                LIMIT 1
            )
           ELSE c.name
        END AS chat_name, m1.content AS last_message_content, m1.type as message_type, m1.sent_at, m1.user_id AS last_message_sender_id, m1.seen
        FROM Chats c
        JOIN ChatUsers cu ON c.id = cu.chat_id
        JOIN Users u ON u.id = cu.user_id

        -- Trovo l'ultimo messaggio che mi serve per la preview del messaggio in Laterale.tsx
        LEFT JOIN (
            SELECT m1.id, m1.chat_id, m1.content, m1.sent_at, m1.user_id, m1.seen, m1.type
            FROM Messages m1
            JOIN (
                SELECT chat_id, MAX(sent_at) AS last_message_time
                FROM Messages
                GROUP BY chat_id
            ) m2 ON m1.chat_id = m2.chat_id AND m1.sent_at = m2.last_message_time
        ) m1 ON c.id = m1.chat_id
        WHERE cu.user_id = $user_id
        ORDER BY m1.sent_at DESC;
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
    } else {
        echo "Nessun risultato trovato.<br>";
    }

    $results = json_encode($results);  // Contverto i risultati in JSON
    echo $results;
}

selectAllChats($mysqli);