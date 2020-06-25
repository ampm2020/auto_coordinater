<?php 
require('header.php');
require('dbconnect.php');
require('clothes_type.php');

$selectd_tops = array(); //トップスを入れる配列
$selected_bottoms = array(); //ボトムスを入れる配列
if(!empty($_POST['max_temperature'])){
    $max_tmperature = $_POST['max_temperature'];//最高気温を取得
    require('select_clothes.php');
}
?>

<h1>自動コーディネータ　ver0.1</h1>
<p>その日の気温に合わせていい感じの服を勝手に選んでくれます。</p>
<p>※ファッションセンスの保証はしません</p>
<form action="" method="post">
    最高気温<input type="number" name="max_temperature" value="<?php echo $_POST['max_temperature']?>"><br>
    <input type="submit" value="服を選ぶ">
</form>

<!---検索結果の表示--->
<?php if(!empty($selected_tops)):
    foreach($selected_tops as $top):?>
        <a href=""><img src="cloth_images/<?php echo $top['picture']?>" width="200" height="200"></a>
    <?php endforeach;
endif; ?>

<?php 
if(!empty($selected_bottoms)):
    foreach($selected_bottoms as $bottom):?>
        <a href=""><img src="cloth_images/<?php echo $bottom['picture']?>" width="200" height="200"></a>
    <?php endforeach;
elseif(!empty($_POST['max_temperature'])):?>
    <img src="pictures/no_image_square.png" width="200" height="200">
    <br>※ちょうどいいボトムスを持っていません！
<?php endif; ?>
<br>

<br><br><!---仮--->
<a href="closet.php"><img src="pictures/closet.png" class="closet"width="120" height="120" alt="衣服管理"></a>
<?php require('footer.php')?>