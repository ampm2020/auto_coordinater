<?php
//セッションが空（非ログイン時）か、セッションIDとcookieが一致しない場合は弾く
if(empty($_SESSION) || $_SESSION['session_id'] !== $_COOKIE['Cookie']){
     header('Location: login.php');
     exit();   
}

?>