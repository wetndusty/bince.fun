<?php

error_reporting(E_ERROR | E_PARSE);
include "pipe.php";

$pipe = <<<XML
<transform id="main">
        <page title="resume"><load-xml id="pf" transform="resume"/></page>
</transform>
XML;

echo process_pipeline($pipe);
