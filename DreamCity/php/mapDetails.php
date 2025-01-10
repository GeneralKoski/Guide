<?php
session_start();
include ('../Config/config.php');  // Connessione al database

$mapId = isset($_GET['mapId']) ? $_GET['mapId'] : '';

$sql = "SELECT m.name, m.happiness, m.citizens FROM Maps m WHERE m.id = $mapId";
$res = $pdo->query($sql);

if (!$res) {
    echo $pdo . '<br>';
    return;
}
$map = $res->fetch(PDO::FETCH_ASSOC);

echo json_encode($map);
