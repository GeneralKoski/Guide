<?php
session_start();
include ('../php/config.php');  // Connessione al database

$mapId = isset($_GET['mapId']) ? $_GET['mapId'] : '';
$userId = $_SESSION['id'];
$budget = isset($_GET['budget']) ? $_GET['budget'] : '';

$sql = "UPDATE Departments SET budget = $budget WHERE Dmap_id = $mapId AND user_id = $userId";
$res = $conn->query($sql);

if (!$res) {
    echo $conn->error . '<br>';
    return;
}
$res->fetch_assoc();