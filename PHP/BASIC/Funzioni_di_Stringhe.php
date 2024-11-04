<?php
$lastName = 'Trajkovski';
$firstName = 'Martin';
$email = 'mtrajkovski1@outlook.com     ';
$adress = 'Via cosè';
$ambarabacciccicoco = 'àmbàràbàccìccìcòcò';
$stringa = '1,2,3,4,5,6,7,8';
$ciao = ['C', 'i', 'a', 'o'];
$stripslash = "Ciao\!";
$testo = 'The quick brown Fox jumped over the lazy dog';
echo strtoupper($lastName); // Stampo in maiuscolo
echo "\n";
echo strtolower($firstName); // Stampo in minuscolo
// Ovviamente se invece di stampare mettessi i valori dentro una variabile, la variabile conterrebbe il valore modificato
echo "\n";
echo trim($email); // Stampa l'email senza gli spazi inutili alla fine
echo "\n";
echo str_replace("è", 'e', $adress); // Sostituisce alla variabile $adress la è con e  
echo "\n";
echo str_replace(['à', 'ì', 'ò'], ['a', 'i', 'o'], $ambarabacciccicoco); // Stessa cosa di prima ma usando un array di caratteri
echo "\n";
echo strpos($email, "@"); // Stampa la posizione della chiocciola in email
echo "\n";
var_dump(explode(',', $stringa)); // Toglie le virgole della stringa
echo "\n";
var_dump(implode('', $ciao)); // Unisce l'array di caratteri
echo "\n";
var_dump(stripslashes( $stripslash)); // Taglia via gli slash dalla stringa
echo "\n";
var_dump(str_contains(strtolower($testo), 'fox')); // Ritorna un booleano, true se dentro la stringa si trova la lettera o parola richiesta
                                                                                    // Posso aggiungere la funzione strtolower per gestire il case sensitive
echo "\n";
var_dump(str_ends_with($testo, 'dog')); // Ritorna un booleano, true se la stringa finisce con la lettera o parola richiesta
echo "\n";
var_dump(str_starts_with($testo, 'Porcodio')); // Ritorna un booleano, true se la stringa inizia con la lettera o parola richiesta