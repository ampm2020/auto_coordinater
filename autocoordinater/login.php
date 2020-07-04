<?php
session_start();
require('header.php');
require('dbconnect.php');

//二重ログイン対策(未実装)
if(!empty($_SESSION)){
    header('Location: toppage.php');
    exit();
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
        if($member){
            $_SESSION['id'] = $member['id'];
            $_SESSION['name'] = $member['name'];
            $_SESSION['time'] = time();

            if($_SESSION['name']==='ゲスト'){
                require('guestlogin.php');
            }

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
if($error['login']==='blank'){
    $alart = '※ニックネームまたはパスワードが空です。';
}else if($error['login']==='failed'){
    $alart = '※ログインに失敗しました。ニックネームかパスワードが間違っています。';
}
?>

<h1>自動コーディネータ　ver.0.7</h1>
<p>その名の通り、外出時の服を自動で選んでくれるアプリケーションです。<br>
あらかじめ自分の持っている服を登録しておくと、その中から気温に合った組み合わせを選びます。<br>
<a href="explanation.php">このアプリについて</a></p><br>

<form atcion="" method="post">
    <table>
    <?php if(!empty($alart))echo '<span class="alart">'.$alart.'</span>';?>
    <tr>
        <td>ニックネーム</td>
        <td><input type="text" name="name" value="<?php echo $_COOKIE['Cookie'] ?>"></td>
    </tr>
    <tr>
        <td>パスワード</td>
        <td><input type="password" name="password"></td>
    </tr>
    <tr>
        <td><input type="submit" value="ログイン"></td>
    </tr>
    </table>
</form>

<br>アカウント作成は<a href="regist_user.php" style="font-weight: bold;">こちら</a>
<hr>
<br>※以下のニックネームとパスワードでお試しログインができます。<br>
ニックネーム：ゲスト<br>
パスワード：password<br>
ゲストアカウントには最初から幾つかの服が登録されているため、このアプリの動作を手軽に体験することができます。<br>
服の追加や削除も問題なくできますが、一度画面を閉じたりログアウトしてしまうと変更がリセットされます。<br>
<?php require('footer.php'); ?>