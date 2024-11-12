<?php
// Definisco un'interfaccia e ne riutilizzo le funzioni nelle classi che la implementano
interface iCar {
    public function stop();
    public function start();
    public function changeGear(int $x);
    public function park();
    public function accelerate();
}
class Auto implements iCar {
    public $isStopped = true;
    protected $gear = 0;
    protected $isParked = false;
    private const maxGear = 6;
    public function stop() {
        $this->isStopped = true;
        $this->gear = 0;
    }
    public function start() {
        $this->isStopped = false;
        $this->isParked = false;
    }
    public function changeGear(int $v) {
        if ($v > self::maxGear) {
            $v = self::maxGear;
        } elseif ($v == 0) {
            $v = 0;
        }
        $this->gear = $v;
        if ($v > 0) {
            $this->start();
        }
    }
    public function park() {
        $this->isStopped = true;
        $this->isParked = true;
    }
    public function accelerate() {
        $this->gear += 1;
        $this->start();
    }
}

$auto = new Auto();
$auto->start();
$auto->changeGear(1);
$auto->stop();
var_dump($auto);