<?php
session_start();
include ('../Config/config.php');  // Connessione al database

$mapId = isset($_GET['mapId']) ? $_GET['mapId'] : '';
$citizens = isset($_GET['citizens']) ? $_GET['citizens'] : '';

$sql = "UPDATE Maps SET citizens = $citizens WHERE id = $mapId";
$res = $conn->query($sql);

if (!$res) {
    echo $conn->error . '<br>';
    return;
}
