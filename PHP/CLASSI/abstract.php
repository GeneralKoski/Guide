<?php
abstract class Padre {
    protected $speed = 0;
    abstract protected function speedUp(int $v);
    public function getSpeed() {
        return $this->speed;
    }

}
class Figlia extends Padre {
    protected $speed = 0;
    public function speedUp(int $v)  {
        $this->speed += $v;
    }
}

$figlia = new Figlia();
$figlia->speedUp(30);
var_dump($figlia);
echo $figlia->getSpeed(); // Posso richiamarla dalla classe astratta