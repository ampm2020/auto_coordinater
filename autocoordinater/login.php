<?php
session_start();
require_once('header.php');
require_once('dbconnect.php');

/*
ログインチェック
既にログイン済みの場合はindex.phpに飛ばす
セッションidとcookieが同一ならログイン済みと判定
 */
if(!empty($_SESSION) && $_SESSION['session_id'] === $_COOKIE['Cookie']){
    header('Location: index.php');
    exit();
}

/*
ログイン処理
リクエストパラメータと同じname, passwordのアカウントがDBMSに登録されていればログイン成功
 */
if(!empty($_POST)){
    if($_POST['name'] !== '' && $_POST['password'] !== ''){
        $login = $db->prepare('SELECT * FROM members WHERE name=? AND password=?');
        $login->execute(array(
          $_POST['name'],
          sha1($_POST['password'])//パスワードはハッシュ化する
        ));
        $member = $login->fetch();
        //該当アカウントが存在する場合はセッション変数、cookieに情報を格納する
        if($member){
            $_SESSION['id'] = $member['id'];
            $_SESSION['name'] = $member['name'];
            $_SESSION['session_id'] = session_id();

            //ゲストアカウントでログインした場合は特殊処理を行う
            if($_SESSION['name']==='ゲスト'){
                require_once('guestlogin.php');
            }
            //cookieにセッションidをセットする
            setcookie('Cookie', $_SESSION['session_id'], time()+60*60*24*7);

            header('Location: index.php');
            exit();
        }else{
            //ニックネームかパスワードが間違っているとき
            $error['login'] = 'failed';
        }
    }else{
        //テキストボックスが空の時とき
        $error['login'] = 'blank';
    }
}
if($error['login']==='blank'){
    $alart = '※ニックネームまたはパスワードが空です。';
}else if($error['login']==='failed'){
    $alart = '※ログインに失敗しました。ニックネームかパスワードが間違っています。';
}
?>

<h1>自動コーディネータ　ver.0.9</h1>
<p>自分の持っている服を登録しておくと、気温を入力するだけで自動でコーディネートしてくれるアプリケーションです。<br>
(このページはPHPの学習を目的として製作されたものです)<br>
<a href="explanation.php">このアプリについて</a></p><br>

<form atcion="" method="post">
    <table>
    <?php if(!empty($alart))echo '<span class="alart">'.$alart.'</span>';?>
    <tr>
        <td>ニックネーム</td>
        <td><input type="text" name="name" value=""></td>
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

<br><a href="regist_user.php" style="font-weight: bold;">アカウント作成</a><br><br>
<a href="delete_user.php">アカウントの削除</a>
<hr>
<br>※以下のニックネームとパスワードでゲストアカウントによるお試しログインができます。<br>
ニックネーム：ゲスト<br>
パスワード：password<br><br>
ゲストアカウントには最初からいくつかの服が登録されているため、手軽にアプリの動作を確認することができます。<br>
服の追加・削除も可能ですが、ブラウザを閉じたりログアウトすると状態がリセットされます。<br>
<?php require_once('footer.php'); ?>