<?php
$result = 2+2;

// STRINGHE E NUMERI
$name = "Martin";
$lastName = "Trajkovski";
$age = 18; // Intero
$email = 'mtrajkovski1@outlook.com';


// EOD permette la stampa su più righe. L'apertura è <<<EOD mentre la chiusura solo EOD. La chiusura (EOD) deve avere un'indentatura minore del testo da stampare
$pi = 3.1415;
$radius = 20;
$area = $pi * $radius * $radius;
echo <<<EOD
    Stampo a caso <br>
    <p>L'area è: $area</p> <br>
    <p>Il perimetro è: 2</p> <br>
    Tutto: $name $lastName $email

        //EOD; Messo qui non va bene 
                            //EOD; Messo qui non va bene 
    // EOD; Messo qui va bene
EOD; // Messo qui va bene
// Prova togliendo i commenti nelle varie posizioni per capire meglio

