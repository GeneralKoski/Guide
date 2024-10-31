<?php
$money = 30;
echo "\nIF Statement:\n";
if ($money) { // if (!$money) per negare e quindi cercare il false
    echo "Hai dei soldi\n";
} else { // elseif() se voglio fare un'altro controllo in caso negativo
    echo "Non hai dei soldi\n";
}

// Si possono mettere più parametri includendo nella condizione l'AND (&&) quindi obbligatorio, oppure l'OR (||) per mettere un'altra condizione se la prima non è soddisfatta
if ($money == 20 || $money == 30) {
    echo "Hai 20 o 30 money\n";
    // Qui posso annidare un'altra if per capire se sono 20 o 30:
    if ($money == 20) {
        echo "I money sono 20\n";
    } else {
        echo "I money sono 30\n";
    }
    // Si poteva fare anche in ternaria: echo $money == 20 ?  "I money sono 20\n" : "I money sono 30\n";
} else {
    echo "Non hai ne 20 ne 30 money\n";
}

if ($money == 20 && $money == 30) {
    echo "Com'è possibile\n";
} else {
    echo "Ovviamente non può essere mai 20 e 30, quindi cade qui nell'else\n";
}

// Per includere del codice HTML all'interno degli statement, devo mettere i due punti (:), chiudere il tag <?php aperto, mettere il codice in HTML e poi riaprire il tag per i successivi comandi in php
$html = "ciao";
if ($html == "ciao"): ?>
    <h1>Ciao</h1>
<?php
else: ?>
    <h1>Non ciao</h1>
<?php
endif;

echo "\nSWITCH Statement:\n";
// Utile nel caso di tanti else nell'if
$money = 30; // Se lo imposto uguale a qualsiasi valore diverso dal valori nei case, finisce nel default. In caso di parametro FALSE, rientrerebbe nel case 0 in quanto php li legge nello stesso modo
switch ($money) {
    case 20:
    case 22:
        echo "i money sono 20 o 22\n"; // Scartato, esce lo stesso messaggio se rientra in una delle due casistiche (20 o 22)
        break;
    case 24:
        echo "i money sono 24\n"; // Scartato
        break;
    case 26:
        echo "i money sono 26\n"; // Scartato
        break;
    case 28:
        echo "i money sono 28\n"; // Scartato
        break;
    case 30:
        echo "i money sono 30\n"; // Preso
        break;
    default:
        echo "Non sei in nessun caso\n"; // Non ci arriva
}

echo "\nMATCH Statement:\n";
// Simile allo SWITCH ma confronta il valore ed il tipo. Con SWITCH il caso FALSE == 0 ritorna, con MATCH il caso FALSE === 0 non ritorna
$match = 0; // Ora finisce nel primo, se ci fosse false finirebbe nel secondo, se ci fosse qualsaisi altro valore (anche '0') finirebbe nel default
echo match ($match) {
    0 => 'match è 0',
    false => 'match è false',
    default => 'Nessuno dei valori'
};

echo "\n\nWHILE Statement:\n";
// WHILE farà il ciclo solo se la condizione è soddisfatta
$whilevar = 0;
while ($whilevar < 5) {
    $whilevar++;
    echo "$whilevar, ";
}

echo "\n\nDO WHILE Statement:\n";
// DO WHILE farà sempre il primo ciclo, ma poi continua solo se soddisfa la condizione
do {
    $whilevar++;
    echo $whilevar;
} while ($whilevar < 5);
echo "\n";

$whilearr = ['red', 'blue', 'yellow'];
$i = 0;
while ($i < count($whilearr)) {
    echo "|$whilearr[$i]| ";
    $i++;
}

echo "\n\nFOR Statement:\n";
$forarr = ['red', 'blue', 'yellow', 'purple', 'orange'];
for ($i = 0; $i < count($forarr); $i++) {
    echo "<li>$forarr[$i]</li>"; // Il tag <li></li> è di HTML, posso includerlo in PHP e verrà stampato come parola nel terminale ma sarà visualizzato come item quando si carica sul sito
}

echo "\n\nFOREACH Statement:\n";
// FOREACH funziona come il for, ma si possono personalizzare le chiavi (l'indice) di ogni elemento. Posso modificare l'array cambiandone gli indici.
$foreacharr = ['rosso'=>'red','blu'=>'blue', 'yellow', 'purple', 'orange'];
foreach ($foreacharr as $key => $value) {
    echo "$key => $value\n";
}