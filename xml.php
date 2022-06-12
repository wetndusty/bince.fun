<?php

function json2xmlattrs($json, $node) {
    $arr = json_decode($json);
    foreach ($arr as $name => $value):
        $node->setAttribute($name, $value);
    endforeach;
}

function json2xml(string $json, DOMNode $node): DOMNode {
    $arr = json_decode($json);
    $od = $node->ownerDocument;
    $jsonnode = $od->createElement("json");
    obj2xml($arr, $jsonnode);
    return $jsonnode;
}

function obj2xml($arr, $node) {
    $od = $node->ownerDocument;
    foreach ($arr as $name => $value):
        if (is_object($value) || is_array($value)):
            $jn = $node->appendChild($od->createElement((is_int($name) ? "json_array_item" : '') . $name));
            obj2xml($value, $jn);
        else:
            $jn = $node->appendChild($od->createElement($name));
            $jn->setAttribute("value", (string) $value);
        endif;
    endforeach;
}

function packrow2xml($node, $col) {
    $childs = [];
    foreach ($col as $name => $value):

        if ($name === 'json'):
            $childs['json'] = json2xml($value, $node);
        else:
            $node->setAttribute($name, $value);
        endif;
    endforeach;
    foreach ($childs as $key => $n):
        $node->appendChild($n);
    endforeach;
}

function packrows2xml($rows, string $root_name = "table", string $row_name = "row", $node = new DOMDocument) {
    $root_name = $root_name === '' ? 'table' : $root_name;
    $row_name = $row_name === '' ? 'row' : $row_name;
    $doc = $node->ownerDocument;
    $table = ($root_name !== '') ? $node->appendChild($doc->createElement($root_name)) : $node;
    foreach ($rows as $value) {
        $row = $doc->createElement($row_name);
        packrow2xml($row, $value);
        $table->appendChild($row);
    }
    return $doc;
}
