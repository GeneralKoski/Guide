<?php
session_start();
include ('../Config/config.php');

$userId = $_SESSION['id'];

$sql = "SELECT me.id, me.title, me.content, me.type, (SELECT u.username FROM Users u WHERE u.id = me.sender_id) as sender, me.sender_id,
        (SELECT u.username FROM Users u WHERE u.id = me.receiver_id) as receiver, me.Mmap_id as mapID FROM Messages me WHERE me.receiver_id = $userId";
$res = $conn->query($sql);

if (!$res) {
    echo $conn->error . '<br>';
    return;
}

$messages = [];

while ($row = $res->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);
