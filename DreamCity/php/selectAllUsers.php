<?php
session_start();
include ('../php/config.php');

$userId = $_SESSION['id'];
$sql = "SELECT u.id, u.username FROM Users u WHERE id != $userId";
$result = $conn->query($sql);

$users = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

echo json_encode($users);