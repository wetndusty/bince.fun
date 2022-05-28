<?php

if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
    $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header('HTTP/1.1 301 Moved Permanently');
    header('Location: ' . $location);
    exit;
}

include "pipe.php";

$pipe = <<<XML
        <transform id="main">
        <page title="HRP">
        <body><header><nav><link href="todo.php" title="entry"/><link href="suefa.php" title="Камень, ножницы, бумага - онлайн"/><link href="newuser.php" title="new user"/></nav></header></body>
        </page>
        </transform>
XML;

echo process_pipeline($pipe);
