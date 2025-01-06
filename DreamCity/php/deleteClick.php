<?php
session_start();
include ('../php/config.php');  // Connessione al database

$data = json_decode(file_get_contents('php://input'), true);
$mapId = $data['mapId'];
$userId = $_SESSION['id'];

$sql = "SELECT * FROM MapClicks WHERE Cmap_id = $mapId AND Cuser_id = $userId";
$res = $conn->query($sql);

if ($res->num_rows > 0) {
    $sql = "DELETE FROM MapClicks WHERE Cmap_id = $mapId AND Cuser_id = $userId";
    $res = $conn->query($sql);
    if ($res) {
        echo json_encode(['success' => true, 'message' => 'Il tuo voto è stato eliminato!']);
    } else {
        echo json_encode(['success' => false, 'message' => "Errore durante l'eliminazione del voto!"]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Non hai votato in questa mappa!']);
}