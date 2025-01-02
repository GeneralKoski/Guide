<?php
session_start();
include ('../php/config.php');

$data = json_decode(file_get_contents('php://input'), true);

$userId = $_SESSION['id'];  // ID dell'utente che accetta
$mapID = $data['mapID'];  // ID della mappa
$sender_id = $data['sender_id'];  // ID dell'utente che ha inviato il messaggio
$messageID = $data['id'];  // ID del messaggio

// Controlla che tutti i campi necessari siano presenti
if (empty($mapID) || empty($sender_id) || empty($userId) || empty($messageID)) {
    echo json_encode([
        'success' => false,
        'message' => 'Errore: Tutti i campi devono essere compilati.'
    ]);
    return;
}

// Inizia una transazione per garantire la coerenza dei dati
$conn->begin_transaction();

try {
    // Recupera il Drole_id per l'utente loggato
    $stmt = $conn->prepare('SELECT Drole_id FROM Departments WHERE Dmap_id = ? AND user_id = ?');
    $stmt->bind_param('ii', $mapID, $userId);
    $stmt->execute();
    $stmt->bind_result($userRole);
    $stmt->fetch();
    $stmt->close();

    // Recupera il Drole_id per il sender
    $stmt = $conn->prepare('SELECT Drole_id FROM Departments WHERE Dmap_id = ? AND user_id = ?');
    $stmt->bind_param('ii', $mapID, $sender_id);
    $stmt->execute();
    $stmt->bind_result($senderRole);
    $stmt->fetch();
    $stmt->close();

    // Controlla se sono stati trovati i ruoli
    if (empty($userRole) || empty($senderRole)) {
        throw new Exception('Errore: Non è stato possibile trovare i ruoli degli utenti.');
    }

    // Scambia i ruoli aggiornando la tabella
    $stmt = $conn->prepare('UPDATE Departments SET Drole_id = ? WHERE Dmap_id = ? AND user_id = ?');

    // Imposta il ruolo del sender per l'utente loggato
    $stmt->bind_param('iii', $senderRole, $mapID, $userId);
    $stmt->execute();

    // Imposta il ruolo dell'utente loggato per il sender
    $stmt->bind_param('iii', $userRole, $mapID, $sender_id);
    $stmt->execute();

    $stmt->close();

    // Cancella il messaggio dalla tabella Messages
    $stmt = $conn->prepare('DELETE FROM Messages WHERE id = ?');
    $stmt->bind_param('i', $messageID);
    $stmt->execute();
    $stmt->close();

    // Conferma la transazione
    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Ruoli cambiati e messaggio cancellato con successo'
    ]);
} catch (Exception $e) {
    // In caso di errore, effettua il rollback della transazione
    $conn->rollback();

    echo json_encode([
        'success' => false,
        'message' => 'Errore: ' . $e->getMessage()
    ]);
}
?>