<?php
session_start();
include ('../Config/config.php');

$mapId = isset($_GET['mapId']) ? $_GET['mapId'] : '';

$sql = "SELECT r.name FROM Roles r WHERE r.id NOT IN (SELECT Drole_id FROM Departments d WHERE Dmap_id = $mapId)";
$result = $pdo->query($sql);

$roles = [];
if ($result->rowCount() > 0) {
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $roles[] = $row['name'];
    }
} else {
    echo "  <script>
                alert('Questa mappa è già piena!'); 
                window.location.href='/MapChoices/mapChoice.html';
            </script>";
}

header('Content-Type: application/json');
echo json_encode($roles);
