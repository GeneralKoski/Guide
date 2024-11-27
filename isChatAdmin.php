<?php
header("Access-Control-Allow-Origin: *");
require_once 'connection.php';

function getLoggedUserpfp(mysqli $conn)
{
    // Query per vedere se l'utente loggato è admin e, nel caso, dargli le impostazioni aggiuntive
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
    $chat_id = isset($_GET['chat_id']) ? $_GET['chat_id'] : '';
    $sql = "SELECT ca.Achat_id, ca.Auser_id FROM ChatAdmins ca WHERE ca.Achat_id = $chat_id AND ca.Auser_id = $user_id;";
    $res = $conn->query($sql);

    if ($res->num_rows > 0) {
        echo "true";
    } else {
        echo "false";
    }
}