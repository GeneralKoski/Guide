<?php
include ('../php/config.php');  // Connessione al database

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);

    $mapId = isset($data['id']) ? intval($data['id']) : 0;

    if ($mapId > 0) {
        // Ottieni il nome dell'immagine dalla mappa nel database
        $sql = "SELECT image FROM Maps WHERE id = $mapId";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            $mappa = $result->fetch_assoc();
            $imagePath = './uploads/' . $mappa['image'];  // Percorso dell'immagine

            // Rimuovi il file immagine, se esiste
            if (file_exists($imagePath)) {
                unlink($imagePath);  // Elimina il file fisico
            }

            // Ora elimina la mappa dal database
            $deleteSql = "DELETE FROM Maps WHERE id = $mapId";
            $res = $conn->query($deleteSql);

            if ($res) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => $conn->error]);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Mappa non trovata']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'ID mappa non valido']);
    }
}