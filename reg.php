<!DOCTYPE html>
<?php
  
include "dbh.php";
include "pipe.php";
  
function process_post($dbh, $typ, $comment) {
    $sql = "INSERT INTO tasktypes (typ, comment)
VALUES ('{$typ}', '{$comment}')";
    $upd = $dbh->exec($sql);
};
  
$post_res = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $typ= s($_POST["typ"]);
  $comment= s($_POST["comment"]);

  $post_res = process_post($dbh, $typ, $comment);
}