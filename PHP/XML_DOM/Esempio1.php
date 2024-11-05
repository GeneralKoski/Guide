<?php

$films = [
    [
        'title' => 'Batman',
        'year' => '1989',
        'director' => 'Tim Burton',
        'plot' => "The Dark Knight of Gotham City begins his war on crime with his first major enemy being the clownishly homicidal Joker."
    ],
    [
        'title' => 'The StarWars Adventures',
        'year' => '2016',
        'director' => 'Tim Burton',
        'plot' => "Slitting the Battalion into four companies, Thunder Company, under the command of Captain Mandeville."
    ]
];

$dom = new DOMDocument('1.0', 'utf-8');

$root = $dom->createElement('root');

$dom->appendChild($root);

foreach ($films as $film) {
    $movie = $dom->createElement('film');
    foreach ($film as $tag => $value) {
        $element = $dom->createElement($tag);
        $text = $dom->createTextNode($value);
        $element->appendChild($text);
        $movie->appendChild($element);
    }
    $root->appendChild($movie);
}
$dom->appendChild($root);
header("Content-type:text/xml");
echo $dom->saveXML();