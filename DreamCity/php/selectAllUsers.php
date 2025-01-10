<?php
session_start();
include ('../Config/config.php');

$userId = $_SESSION['id'];
$sql = "SELECT u.id, u.username FROM Users u WHERE id != $userId";
$result = $pdo->query($sql);

$users = [];

if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $users[] = $row;
    }
}

echo json_encode($users);
