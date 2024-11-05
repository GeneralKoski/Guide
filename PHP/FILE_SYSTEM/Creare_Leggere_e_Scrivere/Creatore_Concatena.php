<?php
$dir = './';
$fileName = 'FileTestoConcatenato.txt';
$content = '';
if(!file_exists($fileName)) {
    file_put_contents($fileName, 'Primo contenuto');
}
$content = file_get_contents($fileName);
file_put_contents($fileName, $content."\nSecondo contenuto");