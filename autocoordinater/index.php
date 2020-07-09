<?php
session_start();
require_once('header.php');
require_once('dbconnect.php');
require_once('clothes_type.php');
require_once('logincheck.php');

//ゼロを空判定しない関数
function is_empty( $var = null ) {
	if (empty( $var ) && 0 !== $var && '0' !== $var ) { 
		return true;
	} else {
		return false;
	}
}
/*
決定ボタンを押した際の処理
着ると決めた服の「最後に着た日付」を更新する
*/
if(!empty($_POST['wear'])){
    $deside = true;
    foreach($_POST['wear'] as $id){
        $date = date('Y-m-d');
        $sql = $db->prepare('UPDATE clothes SET used_date=? WHERE id=?');
        $sql->bindparam(1, $date, PDO::PARAM_STR);
        $sql->bindparam(2, $id, PDO::PARAM_INT);
        $sql->execute();
    }
}

$selectd_tops = array();
$selected_bottoms = array();
$max_temperature = $min_temperature = 0;
$name = $_SESSION['name'];

/*
最高気温：最低気温を受け取って、エラーチェック
エラーがなければselect_clothesを呼び出す
*/
if(!is_empty($_POST['max_temperature']) && !is_empty($_POST['min_temperature'])){
    $max_temperature = $_POST['max_temperature'];
    $min_temperature = $_POST['min_temperature'];
    //ありえない数値設定がなされた場合はエラーメッセージを表示する
    if($max_temperature > 50){
        $error['temperature'] = "maxover";
    }
    else if($min_temperature < -50){
        $error['temperature'] = "minover";
    }
    else if($max_temperature < $min_temperature){
        $error['temperature'] = "impossible";
    }
    if(empty($error)){
        require_once('select_clothes.php');
    }
}else if(!empty($_POST) && empty($_POST['wear'])){
    $error["temperature"] = "blank";
}
?>

<h1>自動コーディネータ　ver.0.7</h1><!---ユーザー名はエスケープ処理してから表示する--->
<p>ようこそ、<?php echo '<span style="font-weight: bold;">'.htmlspecialchars($name, ENT_QUOTES).'</span>';?>さん。
<a href="logout.php" style="mergin-left: 20px;">ログアウト</a></p>

<!---「決定」が押された場合はメッセージと画像を表示--->
<?php if($deside):?>
<p id="after_msg">Have a nice day!</p>
<img src='pictures/halloween_nekomajo.png'><br>
<a href="index.php"><img src="pictures/navigationj_back.png" width="100" height="50"></a>
<!--- 入力フォーム--->
<?php else: ?>
<form action="" method="post">
    <?php if($error["temperature"]==="blank"):?>
        <div class="alart">※気温を入力してください</div>
    <?php elseif($error['temperature']==="maxover"):?>
        <div class="alart">※正しい最高気温を入力してください(50℃まで)</div>
    <?php elseif($error['temperature']==="minover"):?>
        <div class="alart">※正しい最低気温を入力してください(-50℃まで)</div>
    <?php elseif($error['temperature']==="impossible"):?>
        <div class="alart">※最高気温が最低気温以上になるように入力してください</div>
    <?php endif;?>
    最高気温：<input type="number" name="max_temperature" value="<?php echo $_POST['max_temperature']?>"><br>
    最低気温：<input type="number" name="min_temperature" value="<?php echo $_POST['min_temperature']?>"><br>
    <input class= "coordinate" type="submit" name="select" value=
    <?php if($_POST['select'] && empty($error)) echo '"もう一度！"'; else echo '"　選ぶ　"'; ?>>
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
        <a href="upload/<?php echo $bottom['picture']?>" target="_blank"><img src="upload/<?php echo $bottom['picture']?>" width="250" height="250"></a>
    <?php endforeach;
endif;?>
<!---決定ボタン　表示されている服のidを配列に格納して送信する--->
<form action="" method="post"> 
    <?php if(!empty($selected_tops)):
        foreach($selected_tops as $top):
            //毎日洗濯しなくてもいい服は除外する
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
    <?php if(!empty($_POST) && empty($error) && $deside !== true):?>
    画像をクリックすると拡大できます<br>
    <input type="image" src="pictures/pop_kettei.png" alt="決定" width="120" height="60">
    <?php endif; ?>
</form>

<hr>
<div style="font-size: 110%;">▼管理ページへ▼</div>
<a href="closet.php"><img src="pictures/closet.png" class="closet"width="150" height="150" alt="衣服管理"></a>
<a href="explanation.php">このアプリについて</a><br>
<?php require_once('footer.php')?>