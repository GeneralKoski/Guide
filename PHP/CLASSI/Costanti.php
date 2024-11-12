<?php
const PI = 3.141516;

abstract class Padre {
    public const Velocita = 'm/s';

    public static function getVelocita() {
        return 'Da padre mi trovo da solo la velocità: '.self::Velocita;
    }
}
class Figlia extends Padre {
    public const Velocita = 'km/h';
    protected $speed = 0;
    public function speedUp(int $v)  {}
    public static function getVelocitaFiglia() {
        return 'Da figlia cerco velocità figlia: '.self::Velocita;
    }
    public static function getVelocitaPadre() {
        return 'Da figlia cerco velocità padre: '.parent::Velocita;
    }
}

$figlia = new Figlia();
echo $figlia::getVelocitaFiglia()."\n"; // Alla costante si accede sempre nello stesso modo delle funzioni, se non è dichiarata la cerca nel padre
echo $figlia::getVelocitaPadre()."\n";
echo Padre::getVelocita()."\n"; // Oppure si può sempre richiamare la funzione che restituisce il valore

echo 'La classe di $figlia è: '.$figlia::class; // Per sapere la classe dell'istanza