<?php
require __DIR__ . '/vendor/autoload.php';

use PHPHtmlParser\Dom;

$dom = new Dom;

$url_papera = 'https://www.amazon.it/Plush-Company-07807-Mattia-Papero/dp/B01CPH79J0/ref=sr_1_1?__mk_it_IT=%C3%85M%C3%85%C5%BD%C3%95%C3%91&keywords=papera&qid=1574158639&sr=8-1';
$url_ipad = 'https://www.amazon.it/Nuovo-Apple-iPad-Wi-Fi-128GB/dp/B07XSCBJV2/ref=sr_1_1?__mk_it_IT=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=18ALA17ODZJWD&keywords=ipad+2019+128gb&qid=1574157003&sprefix=ipad+2019+128%2Caps%2C196&sr=8-1';
$dom->loadFromUrl($url_ipad);
$html = $dom->outerHtml;

$span_array = $dom->find('span');

/*
$id = 0;
foreach($span_array as $el) {
    echo $id." ".$el->text."\n"; 
    $id++;
}
*/

function Purge($str) {
    // cancella ogni carattere diverso da numeri e virgola
    
    $array_res = [];

    for ($i = 0; $i < strlen($str); $i++){
        $char_value = ord($str[$i]);
        if(($char_value>=48 && $char_value<=57) || $char_value==44 || $char_value==46) {
            if($char_value==44) {
                $array_res[] = ".";
            } else {
                $array_res[] = $str[$i];
            }
            
        }
    }

    $res = implode("", $array_res);
    return $res;
}

$prodotto = strtoupper(trim($span_array[99]->text));
$prezzo_pieno = (float) Purge($span_array[108]->text);
$prezzo_scontato = (float) Purge($span_array[110]->text);
$sconto = $prezzo_pieno - $prezzo_scontato;
echo "-------------------------------------------------------------------------------\n";
echo "AMAZON\n";
echo $prodotto . "\n";
echo "Prezzo pieno: ".$prezzo_pieno." € | Prezzo scontato: ".$prezzo_scontato." € | Sconto: ".$sconto." €\n";
echo "-------------------------------------------------------------------------------\n";
