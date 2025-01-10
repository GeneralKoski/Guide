<?php
include_once (__DIR__ . '/../Models/MapModel.php');

class MapPresenter
{
    private $mapModel;

    public function __construct()
    {
        $this->mapModel = new MapModel();
    }

    // Metodo per creare una nuova mappa
    public function createMap()
    {
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
                    $uploadFileDir = realpath(__DIR__ . '/../../uploads/') . '/';
                    $newFileName = $nome . '_' . time() . '.' . $fileExtension;
                    $dest_path = $uploadFileDir . $newFileName;

                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $avatarPath = $newFileName;  // Salva il nome del file
                    } else {
                        echo "<script>alert('Errore nel caricamento del file immagine.'); window.location.href='/createMap';</script>";
                        exit;
                    }
                } else {
                    echo "<script>alert('Tipo di file immagine non valido. Solo JPG, JPEG e PNG sono permessi.'); window.location.href='/createMap';</script>";
                    exit;
                }
            }

            // Query SQL per inserire la mappa nel database
            $map = $this->mapModel->createMap($nome, $descrizione, $avatarPath);
            if ($map) {
                // Reindirizza alla pagina di selezione delle mappe
                echo "<script>alert('Mappa creata con successo!'); window.location.href='/mapChoice';</script>";
            } else {
                echo "<script>alert('Errore nella creazione!');";
            }
        }
    }

    // Metodo per visualizzare tutte le mappe
    public function showMaps()
    {
        // Recupera le mappe dal Model
        $maps = $this->mapModel->getMaps();
        echo $maps;
    }
}
