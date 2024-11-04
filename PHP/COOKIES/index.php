<?php
if(!isset($_COOKIE['numberOfVisits'])) {
    setcookie('numberOfVisits', 1);
} else {
    $total = $_COOKIE['numberOfVisits'] + 1;
    setcookie('numberOfVisits', $total);
}