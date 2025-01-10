<?php
session_start();
include ('../Config/config.php');

$userId = $_SESSION['id'];
$username = $_SESSION['username'];

$sql = 'SELECT b.name, b.color, b.width, b.height, b.happiness, b.cost FROM Buildings b';
$result = $pdo->query($sql);

$buildings = [];  // Inizializza un array vuoto

if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $buildings[] = [
            'name' => $row['name'],
            'color' => $row['color'],
            'width' => $row['width'],
            'height' => $row['height'],
            'happiness' => $row['happiness'],
            'cost' => $row['cost'],
        ];
    }
}

echo json_encode($buildings);
