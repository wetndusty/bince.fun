<?php

include "pipe.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST'):
    $post = filter_input_array(INPUT_POST);
    list($pass, $email) = [$post['pass'], $post['email']];
    $where = ['email' => $email, 'tel' => $pass];
    $user = sql_get_table_fx('v_users_js', ["id", "name"], $where)[0];
    $user_name = $user['name'];
    $user_id = $user['id'];
    if ($user_id):
        session_start();
        $_SESSION['authorized'] = 1;
        $_SESSION['aut'] = uniqid("", true);
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_name'] = $user_name;
        $referer = $post['referer'];
        header("Location:todo.php");
        //echo session_id();
        //echo $user_id;
        exit;
    //echo $_SESSION['aut'];
    endif;
endif;

$post_res = '';
$referer = $_SERVER['HTTP_REFERER'] ?? "/";
$pipe = <<<XML
<transform id="main">
  <page title="Вход">
          <article>
        <h1>Вход</h1>
        <form method="post" action="login.php">
            <input name="email" type="email" required="required" placeholder="Электронная почта"/>
            <input name="pass" type="password" required="required" placeholder="Пароль"/>
            <input name="referer" type="hidden" value="{$referer}"/>
            <input type="submit" value="Войти"/>
        </form>
</article>
</page>
</transform>
XML;
//echo $pipe;
echo process_pipeline($pipe);
?>
