<?php
header("Access-Control-Allow-Origin: *");
require_once 'connection.php';

function selectAllGroupMessages(mysqli $conn)
{
    // Query per trovare tutti i messaggi della chat specifica
    $chat_id = isset($_GET['chat_id']) ? $_GET['chat_id'] : '';
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
    $sql = "SELECT u.id, u.username, m.type as message_type, m.sent_at, m.content as media_content, c.type as chat_type, cu.added_at, m.id,
        -- Se il messaggio è di tipo 'media' ottengo il file_path dalla tabella Media, altrimenti restituisco il contenuto come un normale messaggio
        CASE 
            WHEN m.type = 'media' THEN (
                SELECT media.file_path 
                FROM Media media
                WHERE media.message_id = m.id
                LIMIT 1
            )
            ELSE m.content
        END AS content,
        -- Controllo se il messaggio è visualizzato da tutti o meno per mettere la spunta blu
        IF(
        (SELECT COUNT(*) FROM GroupChatMessages gcm WHERE gcm.seen = 'yes' AND gcm.message_id = m.id) = 
        (SELECT COUNT(*) FROM ChatUsers cu WHERE cu.chat_id = m.chat_id AND cu.user_id != m.user_id),
        'yes', 
        'no'
    ) as seen
        FROM Messages m
        JOIN Users u ON u.id = m.user_id
        JOIN Chats c ON m.chat_id = c.id
        LEFT JOIN ChatUsers cu ON cu.user_id = u.id AND cu.chat_id = c.id
        
        -- Impongo la condizione del vedere i messaggi dopo la data di aggiunta alla chat in caso di chat di gruppo
        WHERE m.chat_id = $chat_id AND m.sent_at > (SELECT cu2.added_at FROM ChatUsers cu2 WHERE cu2.chat_id = $chat_id AND cu2.user_id = $user_id)
        ORDER BY m.sent_at ASC;
";
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
    } else {
        echo "Nessun risultato trovato.<br>";
    }

    // print_r($results);
    echo json_encode($results);  // Contverto i risultati in JSON
}

selectAllGroupMessages($mysqli);