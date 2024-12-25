<?php
session_start();
include ('../php/config.php');  // Connessione al database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recupera i dati dal form
    $nome = $_POST['nome'];
    $descrizione = $_POST['descrizione'];

    // Gestisci il caricamento dell'immagine
    if (isset($_FILES['immagine']) && $_FILES['immagine']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['immagine']['tmp_name'];
        $fileName = $_FILES['immagine']['name'];
        $fileNameCmps = explode('.', $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Estensioni consentite
        $allowedfileExtensions = array('jpg', 'jpeg', 'png');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $uploadFileDir = './uploads/';
            $newFileName = $nome . '_' . time() . '.' . $fileExtension;
            $dest_path = $uploadFileDir . $newFileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $imageUrl = $newFileName;  // Salva il nome del file
            } else {
                echo 'Errore nel caricamento del file immagine.';
                exit;
            }
        } else {
            echo 'Tipo di file immagine non valido. Solo JPG, JPEG e PNG sono permessi.';
            exit;
        }
    }

    // Inserisci i dati della mappa nel database
    $sql = "INSERT INTO Maps (name, description, image, happiness) VALUES ('$nome', '$descrizione', '$imageUrl', '0')";
    $res = $conn->query($sql);

    if (!$res) {
        echo 'Errore nel salvataggio della mappa: ' . $conn->error;
        exit;
    }

    // Reindirizza alla pagina di selezione delle mappe
    header('Location: /MapChoices/mapChoice.html');
    exit();
}
?>