<?php
include_once ('../App/Models/MapModel.php');
include_once ('../App/Presenters/MapPresenter.php');

// Crea l'istanza del presenter
$mapPresenter = new MapPresenter();

// Ottieni il percorso richiesto
$request = ltrim($_SERVER['REQUEST_URI'], '/Routes/MapRoutes.php');  // rimuove la parte iniziale dell'URI

switch ($request) {
    case 'createMap':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $mapPresenter->createMap();
        }
        break;
    case 'getMaps':
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $mapPresenter->showMaps();
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Route non trovata per Maps']);
        break;
}