<?php 
session_start();
require_once('header.php');
require_once('dbconnect.php');
require_once('clothes_type.php');
require_once('logincheck.php');


if(isset($_POST['picture_id'])){
    $param = $_POST['picture_id'];
    $sql = $db->prepare('SELECT id, type, picture FROM clothes WHERE id=?');
    $sql->bindparam(1, $param, PDO::PARAM_INT);
    $sql->execute();
    $res = $sql->fetch();
}
$type = $clothes_type_tops[$res['type']];
if(empty($type))$type = $clothes_type_bottoms[$res['type']];

?>
<p>種別：<?php echo $type; ?>
<form method="post" name="form" action="delete_clothe.php">
    <input type="hidden" name="id" value="<?php echo $res['id']?>">
    <a href="javascript:form.submit()">データの削除(クリックすると消去されます)</a>
</form>

<hr>
<img id="detail" src="upload/<?php echo $res['picture']?>">
<form action="closet.php" name="re" method="post">
    <input type="hidden" name="return" value="true">
    <a class="return" href="javascript:re.submit()"><img src="pictures/navigationj_back.png" width="100" height="50"></a>
</form>

<?php require_once('footer.php')?>