<?php
session_start();
include('../php/config.php');  // Connessione al database

$map = 1; // Diventerà l'id della mappa dove sono entrato

$sql = "SELECT m.name, m.happiness FROM Maps m";
$res = $conn->query($sql);

if (!$res) {
    echo $conn->error . '<br>';
    return;
}
$map = $res->fetch_assoc();

echo json_encode($map);