<?php
session_start();
include ('../php/config.php');  // Connessione al database

$mapId = isset($_GET['mapId']) ? $_GET['mapId'] : '';
$x_coordinate = isset($_GET['x_coordinate']) ? $_GET['x_coordinate'] : '';
$y_coordinate = isset($_GET['y_coordinate']) ? $_GET['y_coordinate'] : '';

$sql = "DELETE FROM MapBuildings WHERE x_coordinate = $x_coordinate AND y_coordinate = $y_coordinate AND MBmap_id = $mapId";
$res = $conn->query($sql);

if (!$res) {
    echo $conn->error . '<br>';
    return;
}
$res->fetch_assoc();