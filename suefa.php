<?php

include "pipe.php";

$cases = ["камень", "ножницы", "бумага"];
$rand = random_int(0, 2);
$computer = $cases[$rand];
$pipe = <<<XML
  <transform id="main">
  <page title="Камень, ножницы, бумага - онлайн">
  <head/>
  <body>
  <article><h2>{$computer}</h2></article>
  </body>
  </page>
  </transform>
  XML;

echo process_pipeline($pipe);
