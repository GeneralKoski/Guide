<?php
$cities = ["Piacenza", "Milano", "Austin", "Tokyo"];
$accounts['accountnumber'] = 0;
$var = 1;

$arr = ['cities'];
$arr['cities'] = ['MILAN', "TURIN"];
echo $arr['cities'][1];
echo "\n";

$altroarray = [
    'name' => 'Martin',
    'city' => 'Piacenza',
    'lastName' => null
];
echo $altroarray['lastName'] ?? "N/A\n"; // Se il valore nella posizione 'lastName' è null, stampa N/A. Vedi meglio nel file "Confronto.php" riga 48

echo count($cities); // Conta il numero di oggetti che ci sono