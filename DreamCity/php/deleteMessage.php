<?php
session_start();
include ('../Config/config.php');

// Ricevi i dati inviati dal client
$data = json_decode(file_get_contents('php://input'), true);

$messageID = $data['id'];

// Controlla che l'ID del messaggio sia presente
if (empty($messageID)) {
    echo json_encode([
        'success' => false,
        'message' => 'Errore: ID del messaggio mancante.'
    ]);
    return;
}

try {
    // Cancella il messaggio dalla tabella Messages
    $stmt = $conn->prepare('DELETE FROM Messages WHERE id = ?');
    $stmt->bind_param('i', $messageID);
    $stmt->execute();
    $stmt->close();

    echo json_encode([
        'success' => true,
        'message' => 'Messaggio cancellato con successo'
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Errore: ' . $e->getMessage()
    ]);
}
