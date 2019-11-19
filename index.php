<?php
require __DIR__ . '/vendor/autoload.php';

use PHPHtmlParser\Dom;

$dom = new Dom;
$dom->loadFromUrl('http://www.archistico.com');
$html = $dom->outerHtml;

$a = $dom->find('a');
foreach($a as $el) {
    echo $el->text."\n"; 
}