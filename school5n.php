<?php

include "pipe.php";

$pipe = <<<XML
        <transform id="main">
        <page title="Йо">
        <body>
        <img src="b10.png"/>
        </body>
        </page>
        </transform>
XML;

echo process_pipeline($pipe);
