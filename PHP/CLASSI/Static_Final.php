<?php
abstract class Padre {
    protected $speed = 0;
    public static $classVersion = '1';
    abstract protected function speedUp(int $v);
    public final function getSpeed() {
        return $this->speed;
    }
    public static function getVersion() {
        return self::$classVersion;
    }
}
class Figlia extends Padre {
     protected $speed = 0;
    public function speedUp(int $v)  {
        $this->speed += $v;
    }
    public function getParentV() {
        return parent::$classVersion;
    }
}

$figlia = new Figlia();
echo Padre::$classVersion."\n"; // Posso richiamarla solo specificando la classe in quanto è un oggetto statico

var_dump(Padre::getVersion()); // La classe padre accede alla propria variabile con il self::
var_dump($figlia->getParentV()); // La classe figlia accede alla variabile padre con il parent::