<?php
class Request
{
    protected $data;

    public function __construct()
    {
        echo "Passando dal costruttore\n";
        if (!empty($_REQUEST) && empty($this->data)) {
            $this->data = $_REQUEST;
        }
    }

    public function getData()
    {
        return $this->data;
    }

    public static function __callStatic($name, $args)
    {
        var_dump($name, $args);  // Mostra il nome del metodo chiamato e gli argomenti passati
        $obj = new static();
        switch ($name) {
            case 'all':
                return $obj->getData();
        }
    }
}

// Testando con la richiesta GET
var_dump(Request::all());  // Questo chiama il metodo statico "all" e restituisce i dati