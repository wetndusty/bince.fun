<?php

include "pipe.php";
$global_heap = [];
$take_this = $_SERVER['REQUEST_METHOD'] === 'POST' ? INPUT_POST : INPUT_GET;
$params_arr = filter_input_array($take_this);
$params = json_encode($params_arr, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
$global_heap['json'] = $params;
$pipe = <<<XML
        <r><stored_proc name="echo" heap="json"/></r>
XML;

header('Content-type: application/xml');
//echo $pipe;
$doc = process_pipeline($pipe);
echo $doc->saveXML();

