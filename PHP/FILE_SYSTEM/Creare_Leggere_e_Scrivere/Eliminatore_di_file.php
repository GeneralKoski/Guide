<?php
$fileName = 'FileTestoConcatenato.txt';

if (file_exists($fileName)) {
    unlink($fileName);
}