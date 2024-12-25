<?php
session_start();
include ('../php/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password = password_hash($password, PASSWORD_ARGON2I);

    if (isset($_FILES['avatar'])) {
        if ($_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['avatar']['tmp_name'];
            $fileName = $_FILES['avatar']['name'];
            $fileSize = $_FILES['avatar']['size'];
            $fileType = $_FILES['avatar']['type'];
            $fileNameCmps = explode('.', $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            // Estensioni consentite
            $allowedfileExtensions = array('jpg', 'jpeg', 'png');
            if (in_array($fileExtension, $allowedfileExtensions)) {
                $uploadFileDir = './uploads/';
                $newFileName = $username . '_' . time() . '.' . $fileExtension;
                $dest_path = $uploadFileDir . $newFileName;

                // Carica il file
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $avatarPath = $newFileName;
                } else {
                    echo 'Errore nel caricamento del file. Controlla i permessi della cartella.';
                    exit;
                }
            } else {
                echo 'Tipo di file non valido. Solo JPG, JPEG e PNG sono permessi.';
                exit;
            }
        } else {
            // Mostra l'errore specifico legato al caricamento
            echo 'Errore nel caricamento del file: ' . $_FILES['avatar']['error'];
            exit;
        }
    } else {
        echo 'Nessun file selezionato.';
        exit;
    }

    // Query SQL per inserire i dati nel database
    $sql = "INSERT INTO Users (username, password, avatar) VALUES ('$username', '$password', '$avatarPath')";
    $res = $conn->query($sql);

    if (!$res) {
        echo $conn->error . '<br>';
        return;
    }

    echo "<script>alert('Utente registrato con successo!'); window.location.href='/Login/loginPage.html';</script>";
}