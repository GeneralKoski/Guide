<?php

class UserModel
{
    private $conn;

    public function __construct()
    {
        include_once (__DIR__ . '/../../Config/config.php');

        $this->conn = $conn;

        if ($this->conn->connect_error) {
            die('Connessione fallita: ' . $this->conn->connect_error);
        }
    }

    // Crea un nuovo utente
    public function createUser($username, $password, $avatarPath)
    {
        $sql = "INSERT INTO Users (username, password, avatar) VALUES ('$username', '$password', '$avatarPath')";
        $res = $this->conn->query($sql);

        if (!$res) {
            echo $this->conn->error . '<br>';
            return;
        }

        return true;
    }

    // Verifica le credenziali dell'utente per il login
    public function authenticateUser($username, $password)
    {
        $sql = "SELECT * FROM Users WHERE username = '$username'";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            // Verifica la password
            if (password_verify($password, $user['password'])) {
                // Impostiamo la sessione utente
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                return $user;  // Ritorna l'utente per una gestione successiva nel presenter
            }
        }
        return null;  // Se non troviamo l'utente o la password non è corretta
    }

    // Recupera un elenco di utenti
    public function getUsers()
    {
        $userId = $_SESSION['id'];

        $sql = "SELECT * FROM Users WHERE id != $userId";
        $result = $this->conn->query($sql);
        $users = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
        }

        return json_encode($users);
    }
}