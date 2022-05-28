<?php

include "pipe.php";

$tid = $_GET['id'];
$pipe = <<<XML
        <php>
        <h1>test</h1>
  <pure_sql sql="call get_task({$tid})"
      sql1="drop procedure if exists get_task;
      create procedure get_task(in task_id int)
begin
  select '2' as 'xml_pipe', 'wrapper' as wrapper;
  select '1' as 'xml_pipe', 'users' as 'table_root', 'user' as 'table_row';
  set @author_id:=(select author from v_tasks where id=task_id);
  select * from users where id=@author_id;
  select '3' as 'xml_pipe', 'end wrapper' as comment;
  select '1' as 'xml_pipe', 'wrapper' as wrapper, 'tasks' as 'table_root', 'task' as 'table_row';
  select * from v_tasks where id=task_id;

  select '1' as 'xml_pipe', 'wrapper' as wrapper, 'tasks_types' as 'table_root', 'task_type' as 'table_row';
        select * from tasktypes;
end;"/></php>
XML;
header('Content-type: application/xml');
$doc = new DOMDocument;
$doc = process_pipeline($pipe);
echo $doc->saveXML($doc->documentElement);
?>
