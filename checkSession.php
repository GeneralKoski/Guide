<?php
header("Access-Control-Allow-Origin: http://localhost:3001");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

session_start();

if (isset($_SESSION['username'])) {
    echo json_encode([
        "id" => $_SESSION["id"],
        "username" => $_SESSION['username'],
        "icon" => $_SESSION["icon"],
    ]);
} else {
    echo json_encode(["message" => "Nessuna sessione attiva"]);
}