<!DOCTYPE html>
<?php
session_start();
if ($_SESSION['authorized'] <> 1) {
    header("Location: login.php");
    exit;
}
?>
<?php
include "pipe.php";

$post_res = '';
$user_id = $_SESSION["user_id"];
$user_name = $_SESSION["user_name"];

$pipe = <<<XML
<transform id="main"><page title="Список задач">
  <!--post/-->
  <head/>
  <body>
  <get-table name="tasks_js" fields="id title txt" root_name="table" sql_filter_name="author" sql_filter_value="{$user_id}"/>
          <article>
            <h2>Create task</h2>
            <form method="post" action="json.php" sql_table="requests">
  <br/>
            <input name="title" type="text" required="required" placeholder="Заголовок" sql_field="title"/>
            <input name="txt" type="text" required="required" placeholder="Текст задачи" sql_field="txt"/>
        <input name="author" type="hidden" sql_field="author" value="{$user_id}"/>
            <input type="submit" value="Отправить"/>
        </form>
</article>
</body></page></transform>
XML;

echo process_pipeline($pipe);
