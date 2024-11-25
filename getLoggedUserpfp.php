<?php
header("Access-Control-Allow-Origin: *");
require_once 'connection.php';

function getLoggedUserpfp(mysqli $conn)
{
    // Query per trovare la foto profilo dell'utente loggato per la Sidebar.tsx
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
    $sql = "SELECT u.icon FROM Users u WHERE u.id = $user_id";
    $res = $conn->query($sql);

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $icon = $row['icon'];
        echo $icon;
    }
}

getLoggedUserpfp($mysqli);