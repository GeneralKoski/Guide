<?php
$arr = [
    'name' => 'Trajkovski Martin',
    'age' => 22,
    'city' => 'Piacenza'
];

$arrResult = array_map(fn($v) => strtoupper($v), $arr);
print_r($arrResult);