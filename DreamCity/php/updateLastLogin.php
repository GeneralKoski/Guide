<?php
include ('../Config/config.php');  // Connessione al database

$mapId = isset($_GET['mapId']) ? $_GET['mapId'] : '';

// Aggiorna la colonna lastlogin con la data corrente
$sql = "UPDATE Maps SET lastLogin = NOW() WHERE id = $mapId";
$res = $pdo->query($sql);

if (!$res) {
    echo $pdo . '<br>';
    return;
}
