<?php
session_start();
include ('../Config/config.php');  // Connessione al database

$userId = $_SESSION['id'];
$username = $_SESSION['username'];
$mapId = isset($_GET['mapId']) ? $_GET['mapId'] : '';

$sql = "SELECT (SELECT u.avatar FROM Users u WHERE u.id = $userId) as avatar, r.name, d.budget FROM Roles r, Departments d WHERE r.id = d.Drole_id AND d.user_id = $userId AND d.Dmap_id = $mapId";
$res = $conn->query($sql);

if (!$res) {
    echo $conn->error . '<br>';
    return;
}

$role = $res->fetch_assoc();

if (!$role) {
    echo json_encode([
        'error' => true,
        'message' => 'Nessun ruolo trovato per questa mappa. Seleziona un ruolo.',
        'redirect' => "/SelectRole/selectRole.html?userId=$userId&mapId=$mapId"
    ]);
    exit;
}

$response = [
    'role' => $role['name'],
    'budget' => $role['budget'],
    'username' => $username,
    'avatar' => $role['avatar'],
];

echo json_encode($response);
