<?php
session_start();
require('header.php');

setcookie('Cookie', $_SESSION['email'], time()-3600);
$_SESSION = array();

session_destroy();
?>

<h1>ログアウトしました。</h1>
<a href="login.php"><img src="pictures/navigationj_back.png" width="100" height="50" style="margin-bottom: -20px;"></a>

<?php require('footer.php'); ?>