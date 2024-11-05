<?php
// Prendo l'url del sito e lo copio

$url = 'https://www.sitepoint.com/feed/';
$content = file_get_contents($url);
$xml = simplexml_load_string($content);

echo $xml->channel->title;
echo "<br>";
echo $xml->channel->description;

foreach ($xml->channel->item as $item) {
    echo $item->title;
    echo "<br>".$item->link;
}