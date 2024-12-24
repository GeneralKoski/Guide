<?php
session_start();
include('../php/config.php');  // Connessione al database

$userId = $_SESSION['id'];
$username = $_SESSION['username'];

$sql = "SELECT b.name, b.color, b.width, b.height, b.happiness FROM Buildings b";
$result = $conn->query($sql);

$buildings = [];  // Inizializza un array vuoto

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $buildings[] = [
            'name' => $row['name'],
            'color' => $row['color'],
            'width' => $row['width'],
            'height' => $row['height'],
            'happiness' => $row['happiness'],
        ];
    }
}

echo json_encode($buildings);