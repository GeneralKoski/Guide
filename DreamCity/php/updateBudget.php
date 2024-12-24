<?php
session_start();
include('../php/config.php');  // Connessione al database

$mapid = 1; // Diventerà l'id della mappa dove sono entrato
$userId = $_SESSION['id'];
$budget = isset($_GET['budget']) ? $_GET['budget'] : '';

$sql = "UPDATE Departments SET budget = $budget WHERE Dmap_id = $mapid AND user_id = $userId";
$res = $conn->query($sql);

if (!$res) {
    echo $conn->error . '<br>';
    return;
}
$res->fetch_assoc();