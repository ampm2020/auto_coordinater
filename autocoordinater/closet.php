<?php 
session_start();
require('header.php');
require('dbconnect.php');
require('clothes_type.php');

$result = array();
if(!empty($_SESSION['name'])){
    $name = $_SESSION['name'];
}else{
    $name = "gest";
}

//チェックボックスが１つ以上選択されている状態で、「表示」ボタンが押された場合
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
//拡大画面および削除画面から戻ってきた場合は、前回のチェック状況を保持する
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
}else{
    $_SESSION['checkbox'] = array();
}
?>

<h1>衣服管理ページ</h1>
<p>服をデータベースに追加したり、登録済みの服の検索・削除が行えます。</p>
<a href="register.php" class="add">●服を追加する</a><br>
<a href="toppage.php"><img src="pictures/navigationj_back.png" width="100" height="50" style="margin-bottom: 20px;"></a>
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
<?php require('footer.php')?>