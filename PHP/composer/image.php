<?php
require_once 'vendor/autoload.php';

use Intervention\Image\ImageManager;

$manager = new ImageManager(
    new Intervention\Image\Drivers\Gd\Driver()
);

$image = $manager->read('./Documenti_Tirocinio_Esterno.png');

$newimage = $image->resize(300, 200);

$newimage->save('./Documenti_Tirocinio_Esternoresize.png');
