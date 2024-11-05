<?php
$user = json_decode($_GET['json']);// Al posto di $_GET['json'] metto -> 
                                        //'{"name":"Martin","lastName":"Trajkovski","age":22,"hobbies":["Programming","Travelling","Beating up terroni"],"isAvailable":false,"money":null}'
                                        // Oppure la aggiunto sul web browser dopo l'url aggiungendo ?json= e poi la stringa senza gli apici
var_dump($user);