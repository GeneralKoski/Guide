<?php
session_start();
include ('../php/config.php');  // Connessione al database

$sql = 'SELECT * FROM Maps m ORDER BY m.happiness DESC';
$res = $conn->query($sql);

if (!$res) {
    echo $conn->error . '<br>';
    return;
}
$map = [];

while ($row = $res->fetch_assoc()) {
    $map[] = $row;
}

echo json_encode($map);