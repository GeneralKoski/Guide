<?php
session_start();
include ('../php/config.php');

$userId = 3;

$sql = "SELECT me.title, me.content, me.type, (SELECT u.username FROM Users u WHERE u.id = me.sender_id) as sender,
        (SELECT u.username FROM Users u WHERE u.id = me.receiver_id) as receiver, me.seen FROM Messages me WHERE me.receiver_id = $userId";
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