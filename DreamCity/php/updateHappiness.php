<?php
session_start();
include ('../Config/config.php');  // Connessione al database

$mapId = isset($_GET['mapId']) ? $_GET['mapId'] : '';
$value = isset($_GET['value']) ? $_GET['value'] : '';

$sql = "UPDATE Maps SET happiness = $value WHERE id = $mapId";
$res = $conn->query($sql);

if (!$res) {
    echo $conn->error . '<br>';
    return;
}
