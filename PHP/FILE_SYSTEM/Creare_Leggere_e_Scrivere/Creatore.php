<?php
$dir = './';
$fileName = 'FileCreato.txt';

// Apro il file o se non esiste ci scrivo
$hd = fopen($fileName, 'w');
if($hd) {
    fwrite($hd, 'Prima scrittura su file');
    fclose($hd);
} else {
    echo 'Impossibile creare il file';
}

// Apro il file e ci scrivo alla fine
$hd = fopen($fileName, 'a');
if($hd) {
    fwrite($hd, "\nSeconda scrittura su file");
    fclose($hd);
} else {
    echo 'Impossibile creare il file';
}

// Apro il file e lo leggo
$hd = fopen($fileName, 'r');
if($hd) {
    $content = fread($hd, filesize($fileName));
    echo $content;
} else {
    echo 'Impossibile creare il file';
}