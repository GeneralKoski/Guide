<?php
session_start();
include ('../Config/config.php');  // Connessione al database

$mapId = isset($_GET['mapId']) ? $_GET['mapId'] : '';
$userId = $_SESSION['id'];  // ID dell'utente loggato
$budget = isset($_GET['budget']) ? $_GET['budget'] : '';
$selectedUser = isset($_GET['selectedUser']) ? $_GET['selectedUser'] : '';  // Controllo se esiste un utente selezionato

// Se esiste un utente selezionato, aggiorna anche il suo budget
if ($selectedUser) {
    // Ottieni l'attuale budget dell'utente selezionato
    $getBudgetSql = "SELECT budget FROM Departments d WHERE d.Dmap_id = $mapId AND d.user_id = $selectedUser";
    $budgetResult = $pdo->query($getBudgetSql);

    if ($budgetResult->rowCount() > 0) {
        $row = $budgetResult->fetch(PDO::FETCH_ASSOC);
        $newBudget = $row['budget'] + $budget;  // Aggiungi il valore passato al budget attuale

        // Aggiorna il budget dell'utente selezionato
        $updateSelectedUserSql = "UPDATE Departments SET budget = $newBudget WHERE Dmap_id = $mapId AND user_id = $selectedUser";
        $updateSelectedUserRes = $pdo->query($updateSelectedUserSql);

        if (!$updateSelectedUserRes) {
            echo "Errore nell'aggiornamento del budget dell'utente selezionato: " . $pdo . '<br>';
            return;
        }
    } else {
        echo 'Utente selezionato non trovato o errore nel recupero del budget.<br>';
        return;
    }
} else {
    // Aggiorna il budget dell'utente loggato
    $sql = "UPDATE Departments SET budget = $budget WHERE Dmap_id = $mapId AND user_id = $userId";
    $res = $pdo->query($sql);

    if (!$res) {
        echo "Errore nell'aggiornamento del budget dell'utente loggato: " . $pdo . '<br>';
        return;
    }
}

echo 'Budget aggiornato con successo.';
