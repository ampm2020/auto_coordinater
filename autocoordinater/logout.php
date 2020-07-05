<?php
session_start();
require('header.php');
require('dbconnect.php');
require('logincheck.php');

setcookie('Cookie', $_SESSION['name'], time()-3600);
$_SESSION = array();

session_destroy();
?>

<h1>ログアウトしました。</h1>
<img src="pictures/haloween_cat.png" width=200><br>
<a href="login.php"><img src="pictures/navigationj_back.png" width="100" height="50"></a>

<?php require('footer.php'); ?>