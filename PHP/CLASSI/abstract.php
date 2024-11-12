<?php
abstract class Car {
    protected $speed = 0;
    abstract protected function speedUp(int $v);
    public function getSpeed() {
        return $this->speed;
    }

}
class myCar extends Car {
    protected $speed = 0;
    public function speedUp(int $v)  {
        $this->speed += $v;
    }
}

$car = new myCar();
$car->speedUp(30);
var_dump($car);
echo $car->getSpeed(); // Posso richiamarla dalla classe astratta