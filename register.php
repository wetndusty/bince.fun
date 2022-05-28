<?php
  include "dbh.php";
  function do_register()
   {
     session_start();
   };
  function do_check($dbh, $uid)
   {
     $sql = "update users set verified=1 where uid='{$uid}'";
     $dbh->beginTransaction();
     $dbh->exec($sql);
     $dbh->commit();
   };
  $uid = s($_GET["uid"]);
  echo "<h1>Авторизовано</h1><p>{$uid}</p>";
  do_check($dbh, $uid);
  do_register();
?>