<?php
// Ad ogni varabile dichiaro il suo tipo (string, int, bool ecc.)
class Person {
    readonly public string $name;
    function __construct(string $name, public string $lastName, public int $age, public ?string $address, public ?string $phone) {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->age = $age;
        $this->address = $address;
        $this->phone = $phone;
    }
}

$person = new Person("Martin", "Trajkovski", "22", "Via Lino Vescovi 38", "3755007982");
var_dump($person);

// $person->name = "giovanni"; // Non si può modificare dopo l'inizializzazione in quanto è readonly