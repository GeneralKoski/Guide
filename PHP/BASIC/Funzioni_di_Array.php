<?php
$colors = ["BLUE", "RED", "GREEN"];
$numbers = [25, 27, 29, 23, 26, 21, 20, 22, 28, 24];
var_dump(array_pop($colors)); // Toglie l"ultimo valore
var_dump($colors);

array_push($colors,"GREEN", "YELLOW"); // Aggiunge un valore in fondo
var_dump($colors);

var_dump(array_shift($colors)); // Toglie il primo valore
var_dump($colors);

array_unshift($colors,"BLUE"); // Aggiunge all"inizio
var_dump($colors);

sort($numbers); // Riordina l"array
var_dump($numbers);

[$a, $b, $c] = $colors; // Prendendo dall"array colors, assegno alle variabili a, b e c i valori dei colori in modo sequenziale
var_dump($a, $b, $c);

$user = ["name" => "Martin", "lastName" => "Trajkovski"];
["name" => $name, "lastName" => $lastName] = $user; // Dall"array con chiavi User, estrapolo il nome e cognome nelle variabili $name e $lastName assegnandole a User
var_dump($user);

// Se ho un array di array, esempio un array di utenti, faccio la stampa assegnando i valori alle variabili e ciclando il tutto:
$users = [
    ["name" => "Martin", "lastName" => "Trajkovski"],
    ["name" => "Michelle", "lastName" => "Shuaipi"],
    ["name" => "Endri", "lastName" => "Hoxha"],
    ["name" => "Luigi", "lastName" => "Botrugno"],
    ["name" => "Luigi", "lastName" => "Zheng"]
];
foreach ($users as ["name" => $name, "lastName" => $lastName]) {
    echo "$name $lastName\n";
}

$adresses = [
    ["adress" => "Via Cirillica 3", "city" => "Macedonia"],
    ["adress" => "Via Reggio Merda 22", "city" => "SantIlario"],
    ["adress" => "Strada Salume 12", "city" => "Ziano Piacentino"],
    ["adress" => "Piazza Terronia 122", "city" => "Lecce"],
    ["adress" => "Ching Cheng Hanji", "city" => "Cina"]
];
$completo = array_merge($users, $adresses); // Concatena i due array

// In questo caso però, per unire insieme i valori, conviene creare un nuovo array vuoto e usare il merge degli stessi indici in modo da collegare tutto
$completo2 = [];
for ($i = 0; $i < count($users); $i++) {
    $completo2[] = array_merge($users[$i], $adresses[$i]);
}
print_r($completo2);