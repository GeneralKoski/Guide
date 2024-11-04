<?php
$colors = ['BLUE', 'RED', 'GREEN'];
$numbers = [25, 27, 29, 23, 26, 21, 20, 22, 28, 24];
var_dump(array_pop($colors)); // Toglie l'ultimo valore
var_dump($colors);

array_push($colors,'GREEN', 'YELLOW'); // Aggiunge un valore in fondo
var_dump($colors);

var_dump(array_shift($colors)); // Toglie il primo valore
var_dump($colors);

array_unshift($colors,'BLUE'); // Aggiunge all'inizio
var_dump($colors);

sort($numbers); // Riordina l'array
var_dump($numbers);