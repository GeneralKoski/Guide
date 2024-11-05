<!DOCTYPE html>
<html>
    <head>
        <title>XML FEED</title>
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <section>

<?php
$url = 'https://www.sitepoint.com/feed/';
$xml = simplexml_load_file($url);

echo '<h1>'.$xml->channel->title.'</h1>';
echo '<br>';
echo '<div class="description">'.$xml->channel->description.'</div>';

foreach ($xml->channel->item as $item) : ?>
            <article>
                <h3><?=$item->title?></h3>
            <ul>
                <li><a target="_blank" href="<?=$item->link?>"><?=$item->link?></a></li>
                <li><?=$item->description?></li>
                <li><?=$item->pubDate?></li>
            </ul>
            </article>
            <hr>
<?php
endforeach;
?>
        </section>
    </body>
</html>