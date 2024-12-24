<?php
session_start();
include('../php/config.php');

$mapid = 1;

$sql = "SELECT (SELECT b.name FROM Buildings b WHERE b.id = mb.MBbuilding_id) as building_type, mb.x_coordinate, mb.y_coordinate, mb.rotated FROM MapBuildings mb WHERE mb.MBmap_id = $mapid";
$res = $conn->query($sql);

$buildings = [];

if ($res) {
    while ($row = $res->fetch_assoc()) {
        $buildings[] = $row;
    }
    echo json_encode($buildings);
} else {
    echo json_encode(['status' => 'error', 'message' => $conn->error]);
}