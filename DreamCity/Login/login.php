<?php
session_start();
include('../config.php');  // Connessione al database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recupera i dati dal modulo
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query per trovare l'utente nel database
    $sql = "SELECT * FROM Utenti u WHERE u.Username = '$username'";
    $res = $conn->query($sql);

    if (!$res) {
        echo $conn->error . '<br>';
        return;
    }
    $user = $res->fetch_assoc();

    if (!$user) {
        echo "  <script>
                    alert('Username o Password errati!');
                    window.location.href='loginPage.html';
                </script>
            ";
    }

    if (password_verify(
        $password,
        $user['Password']
    )) {
        $_SESSION['username'] = $user['Username'];
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
