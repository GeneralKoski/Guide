<?php
echo "Uguali, Diversi e cose:\n";
$a = 1; // Intero, imposta a = 1
$b = '1'; // Stringa, imposta b = '1'

var_dump($a == $b); // Confronta i valori, true

var_dump($a === $b); // Confronta i valori ed il tipo, false

var_dump($a != $b); // Confronta i valori, false

var_dump($a !== $b); // Confronta i valori ed il tipo, true



echo "\nMaggiori, Minori e cose:\n";
$c = 4;
$d = 4;

var_dump($c < $d); // Ritorna un booleano

var_dump($c <= $d); // Ritorna un booleano

var_dump($c > $d); // Ritorna un booleano

var_dump($c >= $d); // Ritorna un booleano

var_dump($c <=> $d); // Ritorna -1 se $c è minore di $d, 0 se $c è uguale a $d e 1 se $c è maggiore di $d

echo "\nArray:\n";
$arr = [1, 2, 'ciao'];
var_dump(in_array(2, $arr));  //in_array(intero, array) -> cerca un valore di tipo intero all'interno di un array e ritorna il booleano true in questo caso
var_dump(in_array(0, $arr));  //in_array(intero, array) -> cerca un valore di tipo intero all'interno di un array e ritorna il booleano false in questo caso
var_dump(in_array('ciao', $arr));  //in_array(stringa, array) -> cerca un valore di tipo string all'interno di un array e ritorna il booleano true in questo caso

echo "\nIF Statement:\n";
// $c = 3; // Togli il commento per vedere la stampa di if
$e = 'e'; // Imposta la variabile $e = qualsiasi stringa per vedere il risultato di else

if ($c === 4) {
    echo "La variabile c è un intero uguale a 4";
} elseif ($e === 'e') {
    echo "La variabile e è una stringa uguale a e";
} else {
    echo "Stampo il caso in cui non vada bene nulla";
}

echo "\nNULL Coalescing:\n";
// Ritorna il primo valore NOT NULL di una lista di variabili
$coalescing = null ?? null ?? null ?? 3 ?? 4 ?? 5;
var_dump($coalescing); // In questo caso stampa 3 perchè è il primo valore NOT NULL e scarta qualsiasi cosa successiva

echo "\nCondizione ternaria:\n"; // E' come fare una if ma più compatta, veloce e comoda. si usa solo se si ha un'espressione semplice. Se sono if annidate a tante else, usiamo l'if
echo $c === 4 ? "Se si, stampo questo" : "Se no stampo questo"; // Mettendo il confronto $c === 3 oppure $c === '4', stampa il "se no"


// Per controllare se una variabile è già stata dichiarata o meno si usa isset()
echo "\n\nIsset:\n";
if (isset($varnondichiarata)) {
    echo 'Esiste';
} else {
    echo 'La variabile $varnondichiarata non esiste';
}

// Per controllare se una variabile è vuota si usa empty(). Vuota si intente non dichiarata, stringa vuota, 0, 0.0, null. Insomma qualsiasi cosa sia false nel booleano
echo "\n\nEmpty:\n";
$emptyvar = 0;
// $variabileconvalore = 1;
if (empty($variabileconvalore)) {
    echo 'La variabile è vuota';
} else {
    echo "La variabile ha del contenuto: $variabileconvalore";
}