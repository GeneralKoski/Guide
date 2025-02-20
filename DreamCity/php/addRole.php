<?php
session_start();
include ('../Config/config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = isset($_POST['userId']) ? intval($_POST['userId']) : null;
    $mapId = isset($_POST['mapId']) ? intval($_POST['mapId']) : null;
    $role = isset($_POST['role']) ? $_POST['role'] : null;

    if (!$userId || !$mapId || !$role) {
        echo 'Errore: Parametri mancanti';
        exit;
    }

    $sql = "SELECT r.id FROM Roles r WHERE r.name = '$role'";
    $res = $pdo->query($sql);

    $roleId = $res->fetch(PDO::FETCH_ASSOC);
    $roleId = $roleId['id'];

    $sql = "INSERT INTO Departments (user_id, Dmap_id, Drole_id, budget) VALUES ('$userId', '$mapId', '$roleId', 10000)";
    $res = $pdo->query($sql);

    if (!$res) {
        echo $pdo . '<br>';
        return;
    }

    header("Location: /Map/map.html?id=$mapId");
    exit();
}
?>