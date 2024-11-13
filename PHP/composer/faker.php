<?php
require_once 'vendor/autoload.php';

$faker = Faker\Factory::create('it_IT');

echo $faker->name();
// echo $faker->address();
echo $faker->address();
echo $faker->paragraph('3');
