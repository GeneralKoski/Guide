<?php
// Se non è settato già tutto, imposta i cookie al loro valore
foreach($_COOKIE as $name => $value) {
    echo "$name = $value <br>";
}