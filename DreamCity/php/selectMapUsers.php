<?php
session_start();
include ('../Config/config.php');

$userId = $_SESSION['id'];
$mapId = isset($_GET['mapId']) ? $_GET['mapId'] : '';

$sql = "SELECT d.user_id as id, (SELECT u.username FROM Users u WHERE u.id = d.user_id) as username FROM Departments d WHERE d.user_id != $userId AND d.Dmap_id = $mapId";
$result = $conn->query($sql);

$users = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

echo json_encode($users);
