<?php 
session_start();
require_once('header.php');
require_once('dbconnect.php');
require_once('clothes_type.php');
require_once('logincheck.php');

$result = array();
$name = $_SESSION['name'];

/*
「表示」ボタンが押された時の処理
チェックボックスに１つ以上チェックが入っていた場合は一旦セッション変数を空にしてからチェック項目を記憶する
*/
if(!empty($_POST['type'])){
    $_SESSION['checkbox'] = array();
    foreach($_POST['type'] as $type):
    $sql = $db->prepare('SELECT id, picture FROM clothes WHERE owner=? and type=?');
    $sql->bindparam(1, $name, PDO::PARAM_STR);
    $sql->bindparam(2, $type, PDO::PARAM_STR);    
    $sql->execute();
    while($tmp = $sql->fetch()){
    $result[] = $tmp;
    }
    $_SESSION['checkbox'][] = $type;
    endforeach;
/*
拡大画面および削除画面から移動した場合は直前のチェック状況を保持する
*/
}else if($_POST['return'] == "true" && !empty($_SESSION['checkbox'])){
    foreach($_SESSION['checkbox'] as $type):
        $sql = $db->prepare('SELECT id, picture FROM clothes WHERE owner=? and type=?');
        $sql->bindparam(1, $name, PDO::PARAM_STR);
        $sql->bindparam(2, $type, PDO::PARAM_STR);   
        $sql->execute();
        while($tmp = $sql->fetch()){
        $result[] = $tmp;
        }
    endforeach;
/*
それ以外の場合はセッション変数を空にする
*/
}else{
    $_SESSION['checkbox'] = array();
}
?>

<h1>管理ページ</h1>
<p>ここでは服の登録、検索、削除を行うことができます。<br>
画像をクリックすると拡大できます。</p>
<a href="register.php" class="add">●服を追加する</a><br>
<a href="index.php"><img src="pictures/navigationj_back.png" width="100" height="50" style="margin-bottom: 20px;"></a>
<div style="font-size: 125%">【検索】</div>
<!---検索フォーム--->
<form id="search" name="form" action="" method="post">
<ul>
<?php foreach($clothes_type_tops as $key => $val):?>
    <li><label><input type="checkbox" name="type[]" value="<?php echo $key?>"
    <?php if(array_search($key, $_SESSION['checkbox'])!==false){echo 'checked';}?>>
    <?php echo $val?></label></li>
<?php endforeach;?>
<?php foreach($clothes_type_bottoms as $key => $val):?>
    <li><label><input type="checkbox" name="type[]" value="<?php echo $key?>"
    <?php if(array_search($key, $_SESSION['checkbox'])!==false){echo 'checked';}?>>
    <?php echo $val?></label></li>
<?php endforeach;?>
</ul>
<input id="view" type="submit" value="表示" style="float:left;">
</form>

<form action="" method="post" onsubmit="return false;">
    <input class="allcheck" type="submit" value="すべて選択" onClick ="AllChecked();">
    <input class="allcheck" type="submit" value="チェックを外す" onClick="AllUnChecked();">
</form>

<!---一度に全チェックを入れる/外す関数--->
<script language="JavaScript" type="text/javascript">
function AllChecked(){
  for (var i=0; i<document.form.elements['type[]'].length; i++){
    document.form.elements['type[]'][i].checked = true;
  }
}
function AllUnChecked(){
  for (var i=0; i<document.form.elements['type[]'].length; i++){
    document.form.elements['type[]'][i].checked = false;
  }
}
</script>
<hr>
<!---画像を表示する--->
<?php
$cnt = 0;
if(!empty($result)):
    foreach($result as $res):?>
        <form method="post" name="detail<?php echo $cnt?>" action="clothe_details.php" style="display:inline">
            <input type="hidden" name="picture_id" value="<?php echo $res['id']?>">
            <a href="javascript:detail<?php echo $cnt?>.submit()">
            <img id="result" src="upload/<?php echo $res['picture']?>" width="200" height="200"></a>
        </form>
        <?php $cnt++; if($cnt%5==0){echo '<br>';}?>
    <?php endforeach;
endif;?>
<br>
        </form>
<?php require_once('footer.php')?>