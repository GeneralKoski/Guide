<?php
echo "Stampo dall'include di Martin/Test: ";
include_once 'Martin/Test.php';
echo "\nStampo dall'include di Gianprestigiacomo/Test: ";
include_once 'Gianprestigiacomo/Test.php';
class Test
{
    public function __construct()
    {
        echo "Class: " . __NAMESPACE__ . __CLASS__ . ' created';
    }
}

echo "\nStampo dalla classe Test in Index: ";
$test = new Test();

echo "\nStampo dalla classe Test in Martin\Test: ";
$martin = new Martin\Test();

echo "Stampo dalla classe Test in Gianprestigiacomo\Test: ";
$gianprestigiacomo = new Gianprestigiacomo\Test();