<?php

$user = new stdClass();
$user->name = 'Martin';
$user->lastName = 'Trajkovski';
$user->age = 22;
$user->hobbies = ['Programming', 'Travelling', 'Beating up terroni'];
$user->isAvailable = false;
$user->money = null;

echo json_encode($user);