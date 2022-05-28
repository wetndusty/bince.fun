<?php

include "pipe.php";

$ddl = file_get_contents("sql/natural_join.sql");

$pipe = <<<XML
        <ddl/>
XML;

echo process_pipeline($pipe)->saveXML();
