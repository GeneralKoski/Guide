<?php
// Aumento il valore del COOKIE ad ogni visita
$time = time() + 3600;
if(!isset($_COOKIE['numberOfVisits'])) {
    setcookie('numberOfVisits', 1, $time);
} else {
    $total = $_COOKIE['numberOfVisits'] + 1;
    setcookie('numberOfVisits', $total);
}

var_dump($_COOKIE['numberOfVisits']);