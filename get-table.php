<?php

include "pipe.php";

$pipe = <<<XML
  <transform id="main">
      <page title="table">
        <get-table name="v_tables" root_name="table" row_name="row"/>
        <get-table name="tasks_js" root_name="table" row_name="row"/>
        <get-table name="v_users_js" root_name="table" row_name="row"/>
        <get-table name="json" root_name="table" row_name="row"/>
        <get-table name="tasks_nj" root_name="table" row_name="row"/>
        <get-table name="telegram_js" root_name="table" row_name="row"/>
      </page>
  </transform>
XML;
//header('Content-type: application/xml');
//header('Content-type: application/xhtml');
echo process_pipeline($pipe);
