<?php
session_start();
include ('../php/config.php');  // Connessione al database

$mapId = isset($_GET['mapId']) ? $_GET['mapId'] : '';

$sql = "SELECT m.name, m.happiness FROM Maps m WHERE m.id = $mapId";
$res = $conn->query($sql);

if (!$res) {
    echo $conn->error . '<br>';
    return;
}
$map = $res->fetch_assoc();

echo json_encode($map);