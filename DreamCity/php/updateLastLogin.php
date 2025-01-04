<?php
include ('../php/config.php');  // Connessione al database

$mapId = isset($_GET['mapId']) ? $_GET['mapId'] : '';

// Aggiorna la colonna lastlogin con la data corrente
$sql = "UPDATE Maps SET lastLogin = NOW() WHERE id = $mapId";
$res = $conn->query($sql);

if (!$res) {
    echo $conn->error . '<br>';
    return;
}