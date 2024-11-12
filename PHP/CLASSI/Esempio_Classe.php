<?php
// Visibilità: public da tutti, protected dalla classe o le derivate, private solo nella classe
// Per i privati si usano le variabili getter e setter

class Auto {
    protected $color;
    protected $secondcolor;

    function __construct($extColor = null, $intColor = null) {
        $this->color = $extColor;
        $this->secondcolor = $intColor;
    }

    public function getSecondcolor()
    {
        return $this->secondcolor;
    }
    public function setSecondcolor($secondocolore)
    {
        $this->secondcolor = $secondocolore;
    }
    public function getColor()
    {
        return $this->color;
    }

    public function setColor($colore)
    {
        if (strlen($colore) < 3) {
            throw new Exception("Il colore deve avere almeno 3 lettere"); // Genera l'eccezione
        }
        $this->color = $colore;
    }
}

// Creo una classe che estende l'altra in modo da ereditarne i parametri protected, e ne può creare di nuovi suoi
class Truck extends Auto {
    private $clacson = 'Pagliaccio';
    function __construct($extColor = null, $intColor = null, $clacson = null) {
        parent::__construct($extColor, $intColor);
        $this->clacson = $clacson;
    }
    
    public function getColor() {
        return 'Il colore del camion è: '.parent::getColor();
    }
    public function getSecondcolor() {
        return '<br>Il colore secondario del camion è: '.parent::getSecondcolor();
    }
    public function getClacson() {
        return '<br>Ha un clacson di tipo: '.$this->clacson;
    }

    public function setClacson($clacson) {
        $this->clacson = $clacson;
    }
}

$auto = new Auto('Red', 'Turin Glamour');
var_dump($auto);
echo '<br>';
var_dump($auto->getColor());
echo '<br>';
$auto->setColor('Blu');
var_dump($auto->getColor());
echo '<br>';
$fordTruck = new Truck('black','white', 'clown');

// Prende le funzioni di getColor e getSecondColor in override nella classe Truck. Se non fossero dichiarate userebbe quelle del genitore e basta
echo $fordTruck->getColor().$fordTruck->getSecondcolor().$fordTruck->getClacson(); 