<?php
session_start();
include('../php/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['building_type']) && isset($data['x']) && isset($data['y'])) {
        $mapid = 1;
        $buildingType = $data['building_type'];
        $x = $data['x'];
        $y = $data['y'];

        $sql = "SELECT id FROM Buildings WHERE name = '$buildingType'";
        $res = $conn->query($sql);
        if ($res) {
            $id = $res->fetch_assoc();
            $buildingId = $id['id'];

            $sql = "INSERT INTO MapBuildings (MBmap_id, MBbuilding_id, x_coordinate, y_coordinate) 
                    VALUES ($mapid, '$buildingId', $x, $y)";
            $res = $conn->query($sql);

            if ($res) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => $conn->error]);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Tipo di edificio non trovato']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Parametri mancanti']);
    }
}