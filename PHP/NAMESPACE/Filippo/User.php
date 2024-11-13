<?php

namespace Filippo;

class User
{
    public function __construct()
    {
        echo "Class Filippo: " . __NAMESPACE__ . ' ' . __CLASS__ . " created\n";
    }
}

$test = new User();