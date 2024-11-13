<?php

namespace Martin;

class Test
{
    public function __construct()
    {
        echo "Class Martin: " . __NAMESPACE__ . ' ' . __CLASS__ . " created\n";
    }
}

$test = new Test();