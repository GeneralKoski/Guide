<?php
header("Access-Control-Allow-Origin: http://localhost:3001"); // Specifica l'origine esatta
header("Access-Control-Allow-Credentials: true"); // Permette di inviare i cookie con la richiesta
header("Access-Control-Allow-Methods: GET, POST, OPTIONS"); // Aggiungi i metodi HTTP che desideri consentire
header("Access-Control-Allow-Headers: Content-Type"); // Aggiungi gli header che desideri consentire
session_start();
require_once 'connection.php';

$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($username && $password) {
    loginUser($username, $password, $mysqli);
} else {
    echo "Parametri mancanti. username: $username, password: $password";
}
function loginUser($username, $password, mysqli $conn)
{
    // Query per trovare se i dettagli inseriti nell'input quadrano con una combo username+password, così nel caso da farlo loggare
    $sql = "SELECT u.id, u.username, u.password, u.icon FROM Users u WHERE BINARY u.username = '$username'";

    $res = $conn->query($sql);

    if (!$res) {
        echo $conn->error . '<br>';
        return;
    }

    if ($res->num_rows > 0) {
        $user = $res->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['icon'] = $user['icon'];
            echo json_encode($user);
        } else {
            echo "Qualcosa è andato storto";
        }
    } else {
        echo "Nessun risultato trovato.<br>";
    }
}