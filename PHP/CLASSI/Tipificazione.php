<?php
// Ad ogni varabile dichiaro il suo tipo (string, int, bool ecc.)
class Person {
    public string $name;
    public string $lastName;
    public int $age = 0;
    public ?string $address;
    public ?string $phone;
}