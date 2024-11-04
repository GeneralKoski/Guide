<?php
$cities = ['Piacenza', 'Milano', 'Austin', 'Tokyo'];
$accounts['accountnumber'] = 0; // Nelle quadre, come posizione, posso usare anche una stringa. Ora il valore 0 è mantenuto 
                                // non nell'indice di posizione n dell'array ma nella posizione di stringa x, posso controllare stampando il suo valore
print_r($accounts['accountnumber']);
echo '\n';


$arr = ['cities'];
$arr['cities'] = ['MILAN', 'TURIN'];
echo $arr['cities'][1];
echo '\n';


// Count
$altroarray = [
    'name' => 'Martin',
    'city' => 'Piacenza',
    'lastName' => null
];
echo $altroarray['lastName'] ?? 'N/A\n'; // Se il valore nella posizione 'lastName' è null, stampa N/A. Vedi meglio nel file 'Confronto.php' riga 48
echo count($cities); // Conta il numero di oggetti che ci sono


// Array_map
$numbers = [1.2, 2.4, 3.6, 4.8, 5];
function double($val) { 
    return $val * 2;
}
$doubled = array_map('doubleVal', $numbers); // Array_map ha come parametri una funzione (dichiarata o nativa) e un array
$truncated = array_map('floor', $numbers); // La funzione floor mi converte i valori in interi tagliando via la parte decimale
print_r($doubled);
print_r($truncated);