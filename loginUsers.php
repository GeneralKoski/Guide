<?php
header("Access-Control-Allow-Origin: *");
require_once 'connection.php';
function selectAllChats(mysqli $conn)
{
    // Query per trovare se i dettagli inseriti nell'input quadrano con una combo username+password, così nel caso da farlo loggare
    $username = isset($_GET['username']) ? $_GET['username'] : '';
    $password = isset($_GET['password']) ? $_GET['password'] : '';
    $sql = "SELECT u.id, u.username, u.password FROM Users u WHERE BINARY u.username = $username AND BINARY u.password = $password";

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