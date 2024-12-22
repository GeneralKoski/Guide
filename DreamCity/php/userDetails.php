<?php
session_start();
include('../php/config.php');  // Connessione al database

if (isset($_SESSION['username'])) {
    echo $_SESSION['username'];
} else {
    echo 'Utente sconosciuto';  // Messaggio di fallback se non c'è la sessione
}