<?php
session_start();
include ('../Config/config.php');

$userId = $_SESSION['id'];
$mapId = isset($_GET['mapId']) ? $_GET['mapId'] : '';

$sql = "SELECT d.Drole_id as id FROM Departments d WHERE user_id = $userId AND Dmap_id = $mapId";
$res = $pdo->query($sql);
$userBuildings = [];
if ($res) {
    $roleId = $res->fetch(PDO::FETCH_ASSOC);
    $roleId = $roleId['id'];

    $sql = "SELECT b.name FROM Buildings b WHERE Brole_id = $roleId";
    $res = $pdo->query($sql);

    while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
        $userBuildings[] = [
            'name' => $row['name'],
        ];
    }
}

echo json_encode($userBuildings);
