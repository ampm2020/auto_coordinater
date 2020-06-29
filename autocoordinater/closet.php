<?php 
require('header.php');
require('dbconnect.php');
require('clothes_type.php');

//画像を配列として取得
$result = array();

//sqlでテーブルを取得してwhile(fetch)で1行ずつ取り出す
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

<h1>衣服管理ページ</h1>
<a href="register.php">新しい服を登録する</a><br>
<a href="toppage.php">戻る</a><br><br>

<!---検索フォーム--->
<form name="form" action="" method="post">
<input type="checkbox" name="all" onClick="AllChecked();" /> 全選択
<br>
<?php
$cnt = 0;
foreach($clothes_type_tops as $key => $val):
    echo '<input type="checkbox" name="type[]" value="'. $key . '">' . $val;
    $cnt++; if($cnt%5===0){echo '<br>';}
endforeach;
echo '<br>';
foreach($clothes_type_bottoms as $key => $val):
    echo '<input type="checkbox" name="type[]" value="'. $key . '">' . $val;
endforeach;
?>
<br><input type="submit" value="表示">
</form>

<script language="JavaScript" type="text/javascript">
<!--
function AllChecked(){
  var check =  document.form.all.checked;

  for (var i=0; i<document.form.elements['type[]'].length; i++){
    document.form.elements['type[]'][i].checked = check;
  }
}
//-->
</script>

<!---画像を表示する--->
<?php
if(!empty($result)):
    $cnt = 1;
    foreach($result as $res):?>
        <a href="clothe_images/<?php echo $res['picture']?>"><img src="cloth_images/<?php echo $res['picture']?>" width="200" height="200"></a>
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