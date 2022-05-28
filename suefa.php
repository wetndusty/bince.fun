<?php
  session_start();

$cases = ["камень", "ножницы", "бумага"];
$rand = random_int(0, 2);
$computer=$cases[$rand];
$sxml = <<<XML
  <page title="Камень, ножницы, бумага - онлайн">
  <head/>
  <body><header><cite>Главней всего погода в доме, а всё другое суефа!</cite></header>
  <article><h2>{$computer}</h2></article>
  </body>
  </page>
  XML;
$xml = new DOMDocument;
$xml->loadXML($sxml);

$xsl = new DOMDocument;
$xsl->load('main.xsl');

// Настройка преобразования
$proc = new XSLTProcessor;
$proc->importStyleSheet($xsl); // добавление стилей xsl

echo $proc->transformToXML($xml);
?>
