<?php
session_start();
require('header.php');
require('dbconnect.php');
$id = $_POST['id'];
$sql = $db->prepare('SELECT id, picture FROM clothes WHERE id=?');
$sql->bindparam(1, $id, PDO::PARAM_INT);
$sql->execute();
$res = $sql->fetch();

$sql = $db->prepare('DELETE FROM clothes WHERE id=?');
$sql->bindparam(1, $id, PDO::PARAM_INT);
$sql->execute();

$pass = 'upload/';
$pass .= $res['picture'];
unlink($pass);
?>
<h1>削除しました</h1>
<img src="pictures/oosouji_gomidashi.png">
<form action="closet.php" name="re" method="post">
    <input type="hidden" name="return" value="true">
    <a class="return" href="javascript:re.submit()"><img src="pictures/navigationj_back.png" width="100" height="50"></a>
</form>

<?php require('footer.php') ?>
