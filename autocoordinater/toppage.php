<?php
session_start();
require('header.php');
require('dbconnect.php');
require('clothes_type.php');

//ログインチェック
if(!empty($_SESSION['id'])){
    $members = $db->prepare('SELECT * FROM members WHERE id=?');
    $members->execute(array($_SESSION['id']));
    $member = $members->fetch();
    $name = $_SESSION['name'];
}else{
    header('Location: login.php');
    exit();
}

//「決定」ボタンを押すと、選んだ服を最後に着た日が更新される
if(!empty($_POST['wear'])){
    $diside = true;
    foreach($_POST['wear'] as $id){
        $date = date('Y-m-d');
        $sql = $db->prepare('UPDATE clothes SET used_date=? WHERE id=?');
        $sql->bindparam(1, $date, PDO::PARAM_STR);
        $sql->bindparam(2, $id, PDO::PARAM_INT);
        $sql->execute();
    }
}

//ゼロを空判定しない関数
function is_empty( $var = null ) {
	if (empty( $var ) && 0 !== $var && '0' !== $var ) { 
		return true;
	} else {
		return false;
	}
}

$selectd_tops = array();
$selected_bottoms = array();

if(!is_empty($_POST['max_temperature']) && !is_empty($_POST['min_temperature'])){
    $max_temperature = $_POST['max_temperature'];
    $min_temperature = $_POST['min_temperature'];
    require('select_clothes.php');
}else if(!empty($_POST) && empty($_POST['wear'])){
    $error["temperature"] = "blank";
}
?>

<h1>自動コーディネータ　ver.0.7</h1>
<p>ようこそ、<?php echo '<span style="font-weight: bold;">'.htmlspecialchars($name, ENT_QUOTES).'</span>';?>さん。
<a href="logout.php" style="mergin-left: 20px;">ログアウト</a></p>

<?php if($diside): ?>
<p id="after_msg">Have a nice day!</p>
<img src='pictures/halloween_nekomajo.png'><br>
<a href="toppage.php"><img src="pictures/navigationj_back.png" width="100" height="50"></a>
<?php else: ?>
<form action="" method="post">
    <?php if($error["temperature"]==="blank"):?>
        <div class="alart">※気温を入力してください</div>
    <?php endif;?>
    最高気温：<input type="number" name="max_temperature" value="<?php echo $_POST['max_temperature']?>"><br>
    最低気温：<input type="number" name="min_temperature" value="<?php echo $_POST['min_temperature']?>"><br>
    <input class= "coordinate" type="submit" name="select" value=
    <?php if($_POST['select'] && empty($error)) echo '"もう一度！"'; else echo '"選んでもらう"'; ?>>
</form>
<?php endif;?>

<!---検索結果の表示--->
<?php if(!empty($selected_tops)):
    foreach($selected_tops as $top):?>
        <a href="upload/<?php echo $top['picture']?>" target="_blank"><img src="upload/<?php echo $top['picture']?>" width="230" height="230"></a>
    <?php endforeach;
endif; ?>

<?php if(!empty($selected_bottoms)):
    foreach($selected_bottoms as $bottom):?>
        <a href="upload/<?php echo $bottom['picture']?>"><img src="upload/<?php echo $bottom['picture']?>" width="250" height="250"></a>
    <?php endforeach;
endif;?>
<br>
<!---決定ボタン　押すと服を最後に着た日付が更新される--->
<form action="" method="post"> 
    <?php if(!empty($selected_tops)):
        foreach($selected_tops as $top):
            //毎日洗濯しなくてもいい服は日付を更新しない
            if(array_search($top['type'], $not_laundly_everyday)!==false)continue;     
        ?>
        <input type="hidden" name="wear[]" value="<?php echo $top['id']?>">
    <?php endforeach;
        endif;?>
    <?php if(!empty($selected_bottoms)):   
        foreach($selected_bottoms as $bottom): ?>
        <input type="hidden" name="wear[]" value="<?php echo $bottom['id']?>">
    <?php endforeach;
    endif;?>
    <br>
    <?php if(!empty($_POST) && empty($error) && $diside !== true):?>
    <input type="image" src="pictures/pop_kettei.png" alt="決定" width="120" height="60">
    <?php endif; ?>
</form>

<hr>
<div style="font-size: 110%;">▼管理ページへ▼</div>
<a href="closet.php"><img src="pictures/closet.png" class="closet"width="150" height="150" alt="衣服管理"></a>
<a href="explanation.php">このアプリについて</a><br>
<?php require('footer.php')?>