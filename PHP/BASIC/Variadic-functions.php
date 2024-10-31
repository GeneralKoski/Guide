<?php
declare (strict_types= 1);
// Funzione che riceve più valori e li contiene nella variabile di parametro
function sum(...$values) {
    $sum = 0;
    foreach ($values as $value) {
        $sum += $value;
    }
    return $sum;
}
$result = sum(1, 2, 3);
echo $result;



function stringJoin(string $separatore, int ...$parti) {
    return implode($separatore, $parti);
}

echo "\n";
echo stringJoin('-', 1, 2, 3, 4, 5, 6);


function showFavoriteColors (string ...$colori) {
    return "\nI tuoi colori preferiti sono: ".implode(',', $colori);
}

echo showFavoriteColors('giallo', 'verde', 'blu', 'rosso');