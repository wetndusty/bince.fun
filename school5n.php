<?php

include "pipe.php";

$pipe = <<<XML
        <transform id="main">
        <page title="Пятая школа">
        <body><header>
            <nav>
        <link href="http://mail.ru" title="MAIL.RU"/>
        <link href="http://youtube.com" title="Youtube"/>
        <link href="http://google.com" title="Google"/>
        <link href="https://troitskaya5.eljur.ru/" title="Электронный журнал"/>
        <link href="https://zoom.us/" title="Zoom"/>
        <link href="http://yandex.ru" title="Яндекс"/>
        <link href="https://translate.google.ru/" title="Переводчик"/>
        <link href="http://exterium.ru/" title="Экстериум"/>
        <link href="http://rgdb.ru/" title="Электронная детская библиотека"/>
        <link href="http://pixologic.com/sculptris/" title="Sculptris"/>
        <link href="https://www.blender.org/" title="Blender"/>
        <link href="http://kpolyakov.spb.ru/" title="Поляков"/>
        <link href="http://mironit.ru" title="Мир моих интересов"/>
        <link href="https://inkscape.org/ru/" title="inkscape"/>
        </nav></header></body>
        </page>
        </transform>
XML;

echo process_pipeline($pipe);
