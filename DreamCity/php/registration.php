<?php
session_start();
include('../php/config.php');  // Connessione al database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recupera i dati dal modulo
    $username = $_POST['username'];
    $password = $_POST['password'];

    $password = password_hash($password, PASSWORD_ARGON2I);
    // Query per trovare l'utente nel database
    $sql = "INSERT INTO Users (username, password) VALUES ('$username', '$password')";
    $res = $conn->query($sql);

    if (!$res) {
        echo $conn->error . '<br>';
        return;
    }

    echo "<script>alert('Utente registrato con successo!'); window.location.href='/Login/loginPage.html';</script>";
}