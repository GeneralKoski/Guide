<?php
include_once ('../App/Models/UserModel.php');
include_once ('../App/Presenters/UserPresenter.php');

// Crea l'istanza del presenter
$userPresenter = new UserPresenter();

// Ottieni il percorso richiesto
$request = ltrim($_SERVER['REQUEST_URI'], '/Routes/UserRoutes.php');  // rimuove la parte iniziale dell'URI

switch ($request) {
    case 'createUser':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userPresenter->registerUser();
        }
        break;
    case 'authenticateUser':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userPresenter->loginUser();
        }
        break;
    case 'deauthenticateUser':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userPresenter->logoutUser();
        }
        break;
    case 'getUsers':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $userPresenter->showUsers();
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Route non trovata per Users']);
        break;
}
