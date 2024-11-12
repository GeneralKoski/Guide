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
    public static function __callStatic($name, $args) {
        var_dump(func_get_args());
        $obj = new static();
        switch ($name) {
            case 'all':
                return $obj->getData();
        }
    }    
}

var_dump(Request::all('name'));