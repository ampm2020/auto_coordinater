<?php 
require('header.php');
require('dbconnect.php');
require('clothes_type.php');


if(!empty($_POST)){
    //エラーチェック
    //ファイルが空
    if($_FILES['picture']['name']===''){
        $error['file'] = "blank";
    }
    //分類を選んでいない
    if($_POST['type']==='tops' || $_POST['type']==='bottoms'){
        $error['type'] = 'blank';
    }
    if(empty($error)){
        echo "登録しました<br>";
	    $statement = $db->prepare('INSERT INTO clothes SET owner="test", divide=?, type=?,picture=?');
	    $statement->execute(array(
		    $_POST['divide'],
		    $_POST['type'],
		    $_FILES['picture']['name'],
        ));
    }
}
?>

<h1>☆服の登録☆</h1>
<a href="closet.php">戻る</a>
<div id="content">
<form action="" method="post" class="regist" enctype="multipart/form-data">
	<dl>
		<dt>【画像】</dt>
        <?php if($error['file']==='blank'):
                echo '※ファイルが選択されていません';
              endif;?>
		<dd>
        	<input type="file" name="picture" size="35" value="test"/>
        </dd>
        <br>
        <dt>【上下】</dt>
        <dd>
            <input type="radio" name="divide" value="tops" checked>トップス
            <input type="radio" name="divide" value="bottoms">ボトムス
        </dd>
        <dt>【分類】</dt>
        <?php if($error['type']==='blank'):
                echo '※服のタイプを選んでください';
              endif; ?>
        <dd>
            <select name="type">
                <option value="tops">----トップス----</option>
                <?php
                foreach($clothes_type_tops as $key => $val):
                    echo '<option value="'.$key.'">'.$val.'</option>';
                endforeach;
                ?>
                <option value="bottoms">----ボトムス----</option>
                <?php
                foreach($clothes_type_bottoms as $key => $val):
                    echo '<option value="'.$key.'">'.$val.'</option>';
                endforeach;                
                ?>
            </select>
        </dd>
	</dl>
	<div><input type="submit" value="登録" /></div>
</form>
</div>

<?php require('footer.php')?>