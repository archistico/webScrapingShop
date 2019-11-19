<?php
require __DIR__ . '/vendor/autoload.php';

use PHPHtmlParser\Dom;

// -------------------------------- FUNZIONI -----------------------------------

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

function PurgeString($str) {
    // cancella ogni carattere diverso da numeri e virgola
    
    $array_res = [];

    for ($i = 0; $i < strlen($str); $i++){
        $char_value = ord($str[$i]);
        if(($char_value>=32 && $char_value<=135)) {
            $array_res[] = $str[$i];
        }
    }

    $res = implode("", $array_res);
    return trim(htmlspecialchars_decode ($res));
}

function JoinString($array, $min, $max) {
    $res = "";

    for($i = $min; $i<=$max; $i++) {
        $res .= trim(htmlspecialchars_decode(str_replace("&nbsp;", '', $array[$i]->text)))." ";
    }
    return trim($res);
}

function EchoArray($arr) {
    $id = 0;
    foreach($arr as $el) {
        echo $id." ".$el->text."\n"; 
        $id++;
    }
}

function EchoPrice($number) {
    return number_format($number, 2, ',', ' ')." €";
}
// ------------------------------- FINE FUNZIONI --------------------------------------

// ##### AMAZON ######

$dom = new Dom;

//$url_papera = 'https://www.amazon.it/Plush-Company-07807-Mattia-Papero/dp/B01CPH79J0/ref=sr_1_1?__mk_it_IT=%C3%85M%C3%85%C5%BD%C3%95%C3%91&keywords=papera&qid=1574158639&sr=8-1';
$url_ipad = 'https://www.amazon.it/Nuovo-Apple-iPad-Wi-Fi-128GB/dp/B07XSCBJV2/ref=sr_1_1?__mk_it_IT=%C3%85M%C3%85%C5%BD%C3%95%C3%91&crid=18ALA17ODZJWD&keywords=ipad+2019+128gb&qid=1574157003&sprefix=ipad+2019+128%2Caps%2C196&sr=8-1';
$dom->loadFromUrl($url_ipad);
$html = $dom->outerHtml;

$span_array = $dom->find('span');

/*
EchoArray($span_array);
*/

$prodotto = PurgeString(strtoupper(trim(htmlspecialchars_decode ($span_array[99]->text))));
$prezzo_pieno = (float) Purge($span_array[108]->text);
$prezzo_scontato = (float) Purge($span_array[110]->text);
$sconto = $prezzo_pieno - $prezzo_scontato;
echo "-------------------------------------------------------------------------------\n";
echo "AMAZON\n";
echo $prodotto . "\n";
echo "Prezzo pieno: ".EchoPrice($prezzo_pieno)." | Prezzo scontato: ".EchoPrice($prezzo_scontato)." | Sconto: ".EchoPrice($sconto)."\n";
echo "-------------------------------------------------------------------------------\n";

// ##### FINE AMAZON ######

// ##### UNIEURO ######

$dom = new Dom;

$url_ipad = 'https://www.unieuro.it/online/iPad/iPad-pidAPLMW772TYA';
$dom->loadFromUrl($url_ipad);
$html = $dom->outerHtml;

$span_array = $dom->find('span');
$h1_array = $dom->find('h1');

/*
EchoArray($h1_array);
*/

$prodotto = PurgeString(strtoupper($h1_array[0]->text));
$prezzo_scontato = (float) Purge(JoinString($span_array, 357,358));

echo "UNIEURO\n";
echo $prodotto . "\n";
echo "Prezzo scontato: ".EchoPrice($prezzo_scontato)."\n";
echo "-------------------------------------------------------------------------------\n";

// ##### FINE UNIEURO ######

// ##### MEDIAWORLD ######

$dom = new Dom;

$url_ipad = 'https://www.mediaworld.it/product/p-112285/apple-ipad-102-2019-wi-fi-128gb-grigio-siderale';
$dom->loadFromUrl($url_ipad);
$html = $dom->outerHtml;

$span_array = $dom->find('span');
$h1_array = $dom->find('h1');

/*
EchoArray($span_array);
*/

$prodotto = strtoupper(PurgeString($h1_array[0]->text));
$prezzo_scontato = (float) Purge($span_array[243]->text);

echo "MEDIAWORLD\n";
echo $prodotto . "\n";
echo "Prezzo scontato: ".EchoPrice($prezzo_scontato)."\n";
echo "-------------------------------------------------------------------------------\n";

// ##### FINE MEDIAWORLD ######