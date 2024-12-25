<?php
session_start();
include ('../php/config.php');

$userId = $_SESSION['id'];
$mapId = isset($_GET['mapId']) ? $_GET['mapId'] : '';

$sql = "SELECT d.Drole_id as id FROM Departments d WHERE user_id = $userId AND Dmap_id = $mapId";
$res = $conn->query($sql);
$userBuildings = [];
if ($res) {
    $roleId = $res->fetch_assoc();
    $roleId = $roleId['id'];

    $sql = "SELECT b.name FROM Buildings b WHERE Brole_id = $roleId";
    $res = $conn->query($sql);

    while ($row = $res->fetch_assoc()) {
        $userBuildings[] = [
            'name' => $row['name'],
        ];
    }
}

echo json_encode($userBuildings);