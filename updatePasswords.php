<?php
header("Access-Control-Allow-Origin: *");
require_once 'connection.php';

function updateUsers(mysqli $conn)
{
    $sql = "SELECT u.id, u.password FROM Users u WHERE u.username != 'Profilo di prova'";
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

    for ($i = 1; $i < 13; $i++) {
        $id = $results[$i]['id'];
        $password = $results[$i]["password"];
        $password = password_hash($password, PASSWORD_ARGON2I);

        $updatesql = "UPDATE Users u SET u.password = '$password' WHERE u.id = $id";
        $res = $conn->query($updatesql);

        if (!$res) {
            echo $conn->error . "<br>";
            return;
        }
    }
}

// updateUsers($mysqli);