<?php
session_start();
include('../php/config.php');  // Connessione al database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recupera i dati dal modulo
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query per trovare l'utente nel database
    $sql = "SELECT * FROM Users u WHERE u.username = '$username'";
    $res = $conn->query($sql);

    if (!$res) {
        echo $conn->error . '<br>';
        return;
    }
    $user = $res->fetch_assoc();

    if (!$user) {
        echo "  <script>
                    alert('Username o Password errati!');
                    window.location.href='/Login/loginPage.html';
                </script>
            ";
    }

    if (password_verify(
        $password,
        $user['password']
    )) {
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        echo $user;
        echo "  <script>
                    alert('Utente loggato con successo! Benvenut* $_SESSION[username]'); 
                    window.location.href='/Map/map.html';
                </script>
            ";
    } else {
        echo "  <script>
                    alert('Username o Password errati!');
                    window.location.href='/Login/loginPage.html';
                </script>
            ";
    }
}