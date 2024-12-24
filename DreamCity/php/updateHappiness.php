<?php
session_start();
include('../php/config.php');  // Connessione al database

$mapid = 1; // Diventerà l'id della mappa dove sono entrato
$value = isset($_GET['value']) ? $_GET['value'] : '';

$sql = "UPDATE Maps SET happiness = $value WHERE id = $mapid";
$res = $conn->query($sql);

if (!$res) {
    echo $conn->error . '<br>';
    return;
}
$res->fetch_assoc();