<?php
include_once (__DIR__ . '/../Models/UserModel.php');

class UserPresenter
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // Metodo per registrare un nuovo utente
    public function registerUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $password = password_hash($password, PASSWORD_ARGON2I);

            if (isset($_FILES['avatar'])) {
                if ($_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                    $fileTmpPath = $_FILES['avatar']['tmp_name'];
                    $fileName = $_FILES['avatar']['name'];
                    $fileNameCmps = explode('.', $fileName);
                    $fileExtension = strtolower(end($fileNameCmps));

                    // Estensioni consentite
                    $allowedfileExtensions = array('jpg', 'jpeg', 'png');
                    if (in_array($fileExtension, $allowedfileExtensions)) {
                        $uploadFileDir = realpath(__DIR__ . '/../../uploads/') . '/';

                        $newFileName = $username . '_' . time() . '.' . $fileExtension;
                        $dest_path = $uploadFileDir . $newFileName;

                        // Carica il file
                        if (move_uploaded_file($fileTmpPath, $dest_path)) {
                            $avatarPath = $newFileName;
                        } else {
                            echo "<script>alert('Errore nel caricamento del file. Controlla i permessi della cartella.'); window.location.href = '/registration';</script>";
                            exit;
                        }
                    } else {
                        echo "<script>alert('Tipo di file non valido. Solo JPG, JPEG e PNG sono permessi.'); window.location.href = '/registration';</script>";
                        exit;
                    }
                } else {
                    // Mostra l'errore specifico legato al caricamento
                    echo 'Errore nel caricamento del file: ' . $_FILES['avatar']['error'];
                    echo " <script>window.location.href = '/registration';</script>";
                    exit;
                }
            }

            // Query SQL per inserire i dati nel database
            $registeredUser = $this->userModel->createUser($username, $password, $avatarPath);
            if ($registeredUser) {
                echo "<script>alert('Utente registrato con successo!'); window.location.href='/';</script>";
            } else {
                echo "<script>alert('Errore nella registrazione!');";
            }
        }
    }

    // Metodo per effettuare il login di un utente
    public function loginUser()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $found = $this->userModel->authenticateUser($username, $password);
            if ($found) {
                // Se il login è avvenuto con successo, reindirizza alla pagina successiva
                echo "<script>window.location.href = '/mapChoice';</script>";
                exit();  // Assicurati di uscire dopo il reindirizzamento
            } else {
                // In caso di errore, reindirizza alla pagina di login con un messaggio di errore
                echo "<script>alert('Username o Password errati!'); window.location.href = '/';</script>";
                exit();
            }
        }
    }

    // Metodo per effettuare il logout di un utente
    public function logoutUser()
    {
        session_start();
        session_unset();
        session_destroy();
        echo "<script>window.location.href = '/';</script>";
    }

    // Metodo per visualizzare tutti gli utenti
    public function showUsers()
    {
        // Recupera gli utenti dal Model
        $users = $this->userModel->getUsers();
        echo json_encode(['success' => true, 'users' => $users]);
    }
}
