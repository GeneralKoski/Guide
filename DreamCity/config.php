<?php
$servername = "127.0.0.1";
$dbname = "dreamcity";
$username = "root";
$password = "";

// Crea la connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Controlla la connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
