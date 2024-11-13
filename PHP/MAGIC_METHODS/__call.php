<?php
// Se nell'URL della pagina aggiungi ?name=nome nella REQUEST prende i valori passati li

class Request
{
    protected $data;
    public function __construct()
    {
        echo "Passando dal costruttore\n";
        if (!empty($_REQUEST) && empty(self::$data)) {
            $this->data = $_REQUEST;
        }
    }
    public function getData()
    {
        return $this->data;
    }
    public function __call($name, $args)
    {
        $var = strtolower(str_replace('get', '', $name));
        return isset($this->data[$var]) ? $this->data[$var] : null;
    }
}

$obj = new Request();
var_dump($obj->getName());
var_dump($obj->getAge());