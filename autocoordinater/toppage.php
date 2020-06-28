<?php 
require('header.php');
require('dbconnect.php');
require('clothes_type.php');


//「決定」ボタンを押すと、選んだ服を最後に着た日が更新される
if(!empty($_POST['wear'])){
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
	if ( empty( $var ) && 0 !== $var && '0' !== $var ) { 
		return true;
	} else {
		return false;
	}
}

$selectd_tops = array(); //トップスを入れる配列
$selected_bottoms = array(); //ボトムスを入れる配列

if(!is_empty($_POST['max_temperature']) && !is_empty($_POST['min_temperature'])){
    $max_temperature = $_POST['max_temperature'];
    $min_temperature = $_POST['min_temperature'] + 3;
    require('select_clothes.php');
}else if(!empty($_POST)){
    $error["temperature"] = "blank";
}

?>

<h1>自動コーディネータ　ver0.1</h1>
<p>その日の気温に合わせていい感じの服を勝手に選んでくれます。</p>
<form action="" method="post">
    <?php if($error["temperature"]==="blank"){echo "※気温を入力してください<br>";}?>
    最高気温：<input type="number" name="max_temperature" value="<?php echo $_POST['max_temperature']?>"><br>
    最低気温：<input type="number" name="min_temperature" value="<?php echo $_POST['min_temperature']?>"><br>
    <input type="submit" value="服を選ぶ">
</form>

<!---検索結果の表示--->
<?php if(!empty($selected_tops)):
    foreach($selected_tops as $top):?>
        <a href=""><img src="cloth_images/<?php echo $top['picture']?>" width="200" height="200"></a>
    <?php endforeach;
endif; ?>

<?php if(!empty($selected_bottoms)):
    foreach($selected_bottoms as $bottom):?>
        <a href=""><img src="cloth_images/<?php echo $bottom['picture']?>" width="200" height="200"></a>
    <?php endforeach;
endif;?>
<br>
<!---決定ボタン　押したら現在選んでいる服を二日後まで選択不可能にする--->
<form action="" method="post"> 
    <?php if(!empty($selected_tops)):
        foreach($selected_tops as $top):?>
        <input type="hidden" name="wear[]" value="<?php echo $top['id']?>">
    <?php endforeach;
        endif;?>
    <?php if(!empty($selected_bottoms)):   
        foreach($selected_bottoms as $bottom): ?>
        <input type="hidden" name="wear[]" value="<?php echo $bottom['id']?>">
    <?php endforeach;
    endif;?>
    <input type="submit" value="これで決定！">
</form>

<br><br><!---仮--->
<a href="closet.php"><img src="pictures/closet.png" class="closet"width="120" height="120" alt="衣服管理"></a>
<?php require('footer.php')?>