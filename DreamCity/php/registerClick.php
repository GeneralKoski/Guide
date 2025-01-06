<?php
session_start();
include ('../Config/config.php');  // Connessione al database

$data = json_decode(file_get_contents('php://input'), true);
$mapId = $data['mapId'];
$userId = $_SESSION['id'];

$sql = "SELECT * FROM MapClicks WHERE Cmap_id = $mapId AND Cuser_id = $userId";
$res = $conn->query($sql);

if ($res->num_rows > 0) {
    // Il giocatore ha già cliccato
    echo json_encode(['success' => false, 'message' => 'Hai già votato per questa mappa!']);
} else {
    $sql = "SELECT * FROM Departments d WHERE d.Dmap_id = $mapId AND d.user_id = $userId";
    $res = $conn->query($sql);

    if ($res->num_rows > 0) {
        $sql = "INSERT INTO MapClicks (Cmap_id, Cuser_id) VALUES ($mapId, $userId)";
        $res = $conn->query($sql);

        if ($res) {
            echo json_encode(['success' => true, 'message' => 'Voto aggiunto con successo!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Errore nel registrare il voto']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Non hai un ruolo in questa mappa!']);
    }
}
