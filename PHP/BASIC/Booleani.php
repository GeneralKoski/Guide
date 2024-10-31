<?php
// false, 0, '0', null sono tutti visti come false nella comparazione

$verify = '0'; // Lo setta come false
var_dump($verify);
if ($verify) {
    echo 'verify is true';
} else {
    echo 'verify is false';
}