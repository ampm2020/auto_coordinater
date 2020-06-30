<?php 
require('header.php');
require('dbconnect.php');
require('clothes_type.php');

$result = array();

if(!empty($_POST['type'])){
    foreach($_POST['type'] as $type):
    $sql = $db->prepare('SELECT id, picture FROM clothes WHERE type=?');
    $sql->bindparam(1, $type, PDO::PARAM_STR);
    $sql->execute();
    while($tmp = $sql->fetch()){
    $result[] = $tmp;
    }
    endforeach;
}
?>

<h1>クローゼット</h1>
<p>現在持っている服を検索・削除したり、新しい服を登録することができます。</p>

<a href="register.php">新しい服を登録する</a><br><br>
<a href="toppage.php">戻る</a><br>

<!---検索フォーム--->
<form name="form" action="" method="post">
<ul><li>
<input type="checkbox" name="all" onClick="AllChecked();" /> 全選択</li>
<br>
<?php
foreach($clothes_type_tops as $key => $val):
    echo '<li><input type="checkbox" name="type[]" value="'. $key . '">' . $val.'</li>';
endforeach;
echo '<br>';
foreach($clothes_type_bottoms as $key => $val):
    echo '<li><input type="checkbox" name="type[]" value="'. $key . '">' . $val.'</li>';
endforeach;
?>
</ul>
<br><input type="submit" value="表示">
</form>

<script language="JavaScript" type="text/javascript">
function AllChecked(){
  var check =  document.form.all.checked;

  for (var i=0; i<document.form.elements['type[]'].length; i++){
    document.form.elements['type[]'][i].checked = check;
  }
}
</script>

<!---画像を表示する--->
<?php
if(!empty($result)):
    $cnt = 1;
    foreach($result as $res):?>
        <a href="upload/<?php echo $res['picture']?>"><img src="upload/<?php echo $res['picture']?>" width="200" height="200"></a>
        <!---削除処理--->
        <form method="post" name="form<?php echo $cnt ?>" action="delete_clothe.php" style="display:inline">
            <input type="hidden" name="clothe_id" value="<?php echo $res['id']?>">
            <a href="javascript:form<?php echo $cnt ?>.submit()">削除</a>
        </form>
        <?php $cnt++;?>
    <?php endforeach;
endif;?>
<br>
        </form>
<?php require('footer.php')?>