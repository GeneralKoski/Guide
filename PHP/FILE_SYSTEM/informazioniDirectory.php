<?php

$dir = '../FILE_SYSTEM/';
$di = new DirectoryIterator($dir);

foreach ($di as $entry) {
    echo "Nome: ".$entry->getFilename().' ('.$entry->getSize().'KB)';
    echo "<br/>";


    echo "Cartella: ";
    if ($entry->isDir()) {
        echo "Si";
    } else {
        echo "No";
    }
    echo "<br/>";


    echo "File: ";
    if($entry->isFile()) {
        echo "Si";
    } else {
        echo "No";
    }
    echo "<br/>";
    echo "<br/>";
}