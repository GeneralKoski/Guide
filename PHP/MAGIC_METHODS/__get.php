<?php
// Se nell'URL della pagina aggiungi ?name=nome nella REQUEST prende i valori passati li
    
class Request {
    protected $data;
    public function __construct() {
        echo "Passando dal costruttore\n";
        if(!empty($_REQUEST) && empty(self::$data)) {
            $this->data = $_REQUEST;
        }
    }
    public function getData() {
        return $this->data;
    }
    public function __get($name) {
        echo "Passando da __get\n";
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }
}

$obj = new Request();
var_dump($obj->getData());