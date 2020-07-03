<?php
session_start();
require('header.php');
require('dbconnect.php');

if(isset($_COOKIE['Cookie'])){
    ;//自動ログインしたい
}

//リクエストパラメータが空でない場合ログイン処理を行う
if(!empty($_POST)){
    if($_POST['name'] !== '' && $_POST['password'] !== ''){
        $login = $db->prepare('SELECT * FROM members WHERE name=? AND password=?');
        $login->execute(array(
          $_POST['name'],
          $_POST['password']
        ));
        $member = $login->fetch();
        //入力データと一致する情報があればログイン成功。セッションに値を保持する
        if($member){
            $_SESSION['id'] = $member['id'];
            $_SESSION['name'] = $member['name'];
            $_SESSION['time'] = time();

            setcookie('Cookie', $member['name'], time()+60*60*24*7);

            header('Location: toppage.php');
            exit();
        }else{
            $error['login'] = 'failed';
        }
    }else{
        $error['login'] = 'blank';
    }
}
?>

<h1>自動コーディネータ　ver.0.4</h1>
<p>気温を入力してからボタンを押すと、いい感じの服を勝手に選んでくれます。</p>
<p>※ログインしてください※</p>
<?php 
if($error['login']==='blank'){
    echo '<br>※メールアドレスまたはパスワードが空です。';
}else if($error['login']==='failed'){
    echo '<br>※ログインに失敗しました。';
}?>
<form atcion="" method="post"><table style="margin-top: -20px;">
<tr><td>ニックネーム</td><td><input type="text" name="name"></td></tr><br>
<tr><td>パスワード</td><td><input type="password" name="password"></td></tr><br>
<tr><td><input type="submit" value="ログイン"></td></tr>
</table></form>
<br>アカウント作成は<a href="regist_user.php">こちら</a>
<br><a href="logout.php">ログアウト画面（デバッグ用)</a>
<br><a href="toppage.php">トップ画面（デバッグ用)</a>
<?php require('footer.php'); ?>