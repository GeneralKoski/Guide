<?php
session_start();
include('../php/config.php');  // Connessione al database

$userId = $_SESSION['id'];
$username = $_SESSION['username'];
$mapid = 1; // Diventerà l'id della mappa dove sono entrato

$sql = "SELECT r.name, d.budget FROM Roles r, Departments d WHERE r.id = d.Drole_id AND d.user_id = $userId AND d.Dmap_id = $mapid";
$res = $conn->query($sql);

if (!$res) {
    echo $conn->error . '<br>';
    return;
}
$role = $res->fetch_assoc();

$response = [
    'role' => $role['name'],
    'budget' => $role['budget'],
    'username' => $username,
];

echo json_encode($response);