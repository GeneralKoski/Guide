<?php
function autoloadClass($className)
{
    $link = str_replace('\\', '/', $className) . '.php';
    echo "\n$link\n";
    if (file_exists($link)) {
        require_once $link;
    }
}
spl_autoload_register('autoloadClass');

$martin = new Martin\Test();
$gianprestigiacomo = new Gianprestigiacomo\Test();
$filippo = new Filippo\User();