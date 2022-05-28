<?php

declare(strict_types=1);

include "sql.php";
include "xml.php";

// $global_out = "";

function process_pipe_table($table, $newnode) {
    $table_name = $table->getAttribute('name');
    $sql_fields = $table->hasAttribute('fields') ? $table->getAttribute('fields') : '*';
    $fields = explode(" ", $sql_fields);
    $sql_filter_name = $table->getAttribute('sql_filter_name');
    $sql_filter_value = $table->getAttribute('sql_filter_value');
    $rows = sql_get_table($table_name, $fields, $sql_filter_name ? [$sql_filter_name => $sql_filter_value] : []);
    packrows2xml($rows, $table->getAttribute('root_name'), $table->getAttribute('row_name'), $newnode);
}

function process_stored_proc(DOMElement $sp, DOMElement|DOMDocument $newnode) {
    $sp_name = $sp->getAttribute('name');
    $param_heap_name = $sp->getAttribute('heap');
    global $global_heap;
    $params = $global_heap[$param_heap_name];
    //$sp_param = $sp->getAttribute('param');
    $sql = "call " . $sp_name . "(:param)";
    global $dbh;
    $sth = $dbh->prepare($sql);
    $sth->bindParam(':param', $params, PDO::PARAM_STR);
    $rowsets = sql_stored_proc($sth);
    pack_rowsets($rowsets, $newnode);
}

function process_pure_sql($item, DOMElement|DOMDocument $newnode) {
    $sql = $item->getAttribute('sql');
    $rowsets = pure_sql($sql);
    pack_rowsets($rowsets, $newnode);
}

function process_ddl($item, DOMElement|DOMDocument $newnode) {
    global $ddl;
    $rowsets = pure_sql($ddl);
    pack_rowsets($rowsets, $newnode);
}

function pack_rowsets($rowsets, DOMElement|DOMDocument $newnode) {
    $xml_wrap_stack = [];
    $names_stack = [['table', 'row']];
    $res = [];
    foreach ($rowsets as $rowset):
        $skip = false;
        if ($rowset) {
            $is_meta = array_key_exists('xml_pipe', $rowset[0]);
            if ($is_meta):
                $skip = true;
                $meta_type = $rowset[0]['xml_pipe'];
                switch ($meta_type):
                    case (1):
                        $names_stack[] = [$rowset[0]['table_root'], $rowset[0]['table_row']];
                        break;
                    case (2):
                        $wp = $rowset[0]['wrapper'];
                        $xml_wrap_stack[] = $wp;
                        $od = $newnode->ownerDocument ?? $newnode;
                        $nd = $od->createElement($wp);
                        $newnode = $newnode->appendChild($nd);
                        break;
                    case (4):
                        $od = $newnode->ownerDocument;
                        $nd = $od->createTextNode($rowset[0]['xmltext']);
                        $newnode->appendChild($nd);
                        break;
                    case (5):
                        $attname = $rowset[0]['attname'];
                        $attvalue = $rowset[0]['attvalue'];
                        $newnode->setAttribute($attname, $attvalue);
                        break;
                    case (3):
                        $newnode = $newnode->parentNode;
                        break;
                endswitch;
            endif;
            $last_names = $names_stack[sizeof($names_stack) - 1];
            $table_root = $last_names[0];
            $table_row = $last_names[1];
            if (!$skip) {
                $res[] = packrows2xml($rowset, $table_root, $table_row, $newnode);
            }
        }
    endforeach;
    return $res;
}

function processChilds($newnode, $node) {
    foreach ($node->childNodes as $ch) {
        processPipe($newnode, $ch);
    }
}

function process_load_xml(DOMNode $node, DOMNode $newnode) {
    $file = $node->getAttribute('id') . '.xml';
    $xslt_name = $node->getAttribute('transform') . '.xsl';
    $doc = new DOMDocument;
    $doc->load($file);
    $xslt = new DOMDocument;
    $xslt->load($xslt_name);
    $trans = new XSLTProcessor;
    $trans->importStylesheet($xslt);
    $newdoc = $trans->transformToDoc($doc);
    $od = $newnode->ownerDocument;
    $n = $od->importNode($newdoc->documentElement, true);
    $newnode->appendChild($n);
}

function process_post(DOMElement $form) {

    $tname = $form->getAttribute("sql_table");
    $fields = $form->ownerDocument->getElementsByTagName("input");
    $sql_fields_list = [];
    $posted = filter_input_array(INPUT_POST);
    foreach ($fields as $item):
        $field_name = $item->getAttribute('name');
        if ($field_name):
            $sql_fields_list[$item->getAttribute('sql_field')] = $posted[$field_name];
        endif;
    endforeach;
    sql_insert($tname, $sql_fields_list);
    header("Location: " . $form->getAttribute('action'));
    exit();
}

function process_input_radio($newnode, $node) {
    global $dbh;
    $tname = $node->getAttribute("sql_table");
    $fname = $node->getAttribute("name");
    $id_field = $node->getAttribute("sql_id");
    $title_field = $node->getAttribute("sql_title");
    $table_query = $dbh->query("SELECT " . $id_field . ", " . $title_field . " FROM " . $tname);
    $table = $table_query->fetchAll();
    $od = $newnode->ownerDocument;
    foreach ($table as $i => $row):
        $input = $od->createElement("input");
        $input->setAttribute("name", $fname);
        $input->setAttribute("type", "radio");
        $input->setAttribute("value", (string) $row[$id_field]);
        $label = $od->createElement("label");
        $id = $fname . $i;
        $label->setAttribute("for", $id);
        $label->appendChild($od->createTextNode($row[$title_field]));
        $input->appendChild($label);
        $input->setAttribute("id", $id);
        $newnode->appendChild($label);
        $newnode->appendChild($input);

    endforeach;
}

function processPipe(DOMDocument|DOMElement $newnode, $node) {
    $node_type = $node->nodeType;
    $new_owner = $newnode->ownerDocument ?? $newnode;
    switch ($node_type):
        case 1:
            $nodename = $node->tagName;
            switch ($nodename):
                case "transform":
                    global $global_out;
                    processChilds($newnode, $node);
                    $xsl = new DOMDocument;
                    $xsl->load($node->getAttribute('id') . '.xsl');
                    $xml_in = $new_owner;
                    $proc = new XSLTProcessor;
                    $proc->importStyleSheet($xsl);
                    $global_out_doc = $proc->transformToDoc($xml_in);
                    $global_out = $global_out_doc->saveXML($global_out_doc->documentElement);
                    return;
                case "get-table":
                    process_pipe_table($node, $newnode);
                    break;
                case "ddl":
                    process_ddl($node, $newnode);
                    break;
                case "pure_sql":
                    process_pure_sql($node, $newnode);
                    break;
                case "stored_proc":
                    process_stored_proc($node, $newnode);
                    break;
                case "post":
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        process_post($node->ownerDocument->getElementsByTagName('form')->item(0));
                        break;
                    }
                    break;
                case "load-xml":
                    process_load_xml($node, $newnode);
                    break;
                case "input":
                    if ($node->getAttribute("type") === "radio" and $node->hasAttribute("sql_table")):
                        process_input_radio($newnode, $node);
                        break;
                    else:
                endif;
                default:
                    $new_cursor_node = $new_owner->createElement($nodename);
                    $newnode->appendChild($new_cursor_node);
                    foreach ($node->attributes as $name => $attrNode) {
                        if (!str_starts_with($name, 'sql_')) {
                            $new_cursor_node->setAttribute($name, $attrNode->value);
                        }
                    }
                    processChilds($new_cursor_node, $node);
                    break;
            endswitch;
            break;
        case 3:
            if (True):
                $new_text_node = $new_owner->createTextNode($node->nodeValue);
                $newnode->appendChild($new_text_node);
            endif;
            break;
    endswitch;
}

function process_pipeline($xmlstr) {

    $newDOM = new DOMDocument('1.0', 'UTF-8');
    $pipeDOM = new DOMDocument;
    $pipeDOM->loadXML($xmlstr);
    //$root = $newDOM->appendChild($newDOM->createElement('root'));
    //$root->setAttribute('test', 'проверка');
    processPipe($newDOM, $pipeDOM->documentElement);
//print_r($newDOM);
    global $global_out;
    return $global_out ? $global_out : $newDOM;
}
