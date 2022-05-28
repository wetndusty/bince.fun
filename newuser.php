<?php

include "pipe.php";

$pipe = <<<XML
  <transform id="main">
      <page id="newuser" title="Регистрация нового пользователя">
  <body><main>
  <form method="post" action="json.php">
  <input type="hidden" name="action" value="newuser"/>
  <input type="hidden" name="from" value="newuser.php"/>
  <input type="number" name="сid" placeholder="номер приглашения" required="required"/>
  <input type="text" name="name" placeholder="имя" required="required"/>
  <input type="tel" name="tel" placeholder="телефон" required="required"/>
  <input type="email" name="email" placeholder="e-mail" required="required"/>
  <br/>
  <button type="submit">Зарегистрироваться</button>
  </form></main></body>
  </page>
  </transform>
XML;

echo process_pipeline($pipe);
