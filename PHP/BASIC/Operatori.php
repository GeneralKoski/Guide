<?php

$a = 2;
$b = 3;

// Somma
$c = $a + $b;
echo "\n$c";

// Sottrazione
$c = $a - $b;
echo "\n$c";

// Moltiplicazione
$c = $a * $b;
echo "\n$c";

// Divisione
$c = $a / $b;
echo "\n$c";

// Resto
$c = $a % $b;
echo "\n$c";

// Elevazione
$c = $a ** $b;
$elevatissimo = $a ** $b ** $b; // Puoi elevare più volte sulla stessa riga in questo modo
// $c = pow($a, $b); Si potrebbe usare anche il pow in questo modo, pow(valore, esponente). E' meno efficiente se si devono fare più elevazioni in quanto ci vogliono più righe
echo "\n$c";
echo "\n$elevatissimo";

// Radice
$c = sqrt($b);
echo "\n$c";