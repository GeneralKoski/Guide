<?php
header("Access-Control-Allow-Origin: *");
require_once 'connection.php';

function getUsersSettings(mysqli $conn)
{
    // Query per trovare i settings impostati da ogni utente per la gestione della spunta blu in "Laterale.tsx"
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
    $sql = "SELECT us.setting_name, MAX(us.setting_value) AS setting_value, cu.user_id, u.username, MAX(cu.chat_id) AS chat_id
    FROM ChatUsers cu
    JOIN UserSettings us ON cu.user_id = us.user_id
    JOIN Users u ON u.id = us.user_id
    JOIN Chats c ON c.id = cu.chat_id
    -- Controllo solo le chat dove lo user loggato è incluso
    WHERE 
        cu.chat_id IN (
            SELECT cu2.chat_id
            FROM ChatUsers cu2
            WHERE cu2.user_id = $user_id
        )
    -- Controllo solo nelle chat 'single' in quanto in quelle 'group' l'ultimo accesso non c'è e le spunte sono sempre blu se il messaggio è visualizzato da tutti, a prescindere dal 'conferma_letture'
    AND c.type = 'single'
    GROUP BY us.setting_name, cu.user_id, u.username
    ORDER BY cu.chat_id, u.id;";

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

getUsersSettings($mysqli);