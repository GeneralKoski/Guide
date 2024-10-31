<?php
declare (strict_types= 1); // Imposta che gli argomenti passati alle funzioni devono essere dello stesso tipo dei parametri richiesti.
// Esempio se ho come parametro string $name, quando richiamo la funzione non posso passare come argomento un numero, se non in formato stringa. 1 non va bene, '1' si


// Dichiaro una funzione che riceve una variabile name. Avere un parametro non è obbligatorio
function sayHello(string $name): string {
    return "Hello $name\n";
}

// Creo un array, lo scorro e stampo ogni suo valore richiamando la funzione
$name = ['Martin', 'Endri', 'Luigi B', 'Luigi Z', 'Michelle'];
for ($i = 0; $i < count($name); $i++) {
    echo sayHello($name[$i]);
}

// Posso attribuire ad una variabile il valore di una funzione
echo "\n";
$saluta = function(): string {
    return "La variabile che saluta\n";
};

echo $saluta();
echo $saluta();

// La differenza sta nel fatto che se dichiaro una variabile-funzione, non posso richiamarala prima della sua dichiarazione; una function è invece richiamabile in qualsiasi punto del codice



// Funzione che riceve valori e ritorna un array
function calcAreaPrimeter(int $a, int $b): array
{
    $area = $a * $b;
    $perimeter = 2 * $a + 2 * $b;
    return [$area, $perimeter];
}

echo "\nPrint ";
print_r(calcAreaPrimeter(3, 4)); // Stampo l'array che mi ritorna

echo "\nPrint destructured Array";
[$area, $perimeter] = calcAreaPrimeter(3,4); // Destrutturo il ritorno della funzione nelle due variabili e le stampo normalmente
echo "\nArea: $area - Perimeter: $perimeter";
