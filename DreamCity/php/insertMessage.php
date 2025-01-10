<?php
session_start();
include ('../Config/config.php');

$data = json_decode(file_get_contents('php://input'), true);

$userId = $_SESSION['id'];
$type = $data['type'];
$receiver = $data['receiver'];
$title = $data['title'];
$content = $data['content'];
$mapId = $data['mapId'];

if (empty($type) || empty($receiver) || empty($title) || empty($content) || empty($mapId) || empty($userId)) {
    echo json_encode([
        'success' => false,
        'message' => 'Errore: Tutti i campi devono essere compilati.'
    ]);
    return;
}

$sql = "INSERT INTO Messages (title, content, type, sender_id, receiver_id, Mmap_id) VALUES ('$title', '$content', '$type', $userId, $receiver, $mapId)";
$res = $pdo->query($sql);

if (!$res) {
    echo json_encode([
        'success' => false,
        'message' => 'Errore nella query: ' . $pdo
    ]);
} else {
    echo json_encode([
        'success' => true,
        'message' => 'Messaggio inserito con successo'
    ]);
}
