<?php
session_start();
require_once('header.php');
require_once('dbconnect.php');

/*
アカウント登録
エラーチェックを行い問題なければデータベースに登録する
*/
if(!empty($_POST)){
    //空欄判定
    if($_POST['name'] ==='') $error['name'] = 'blank';
    if($_POST['password']==='')$error['password'] = 'blank';

    //長さ判定
    if(empty($error['name']) &&  strlen($_POST['name']) > 16)$error['name'] = 'over';
    if(empty($error['password']) && strlen($_POST['password']) < 4)$error['password'] = 'shortage';
    if(empty($error['password']) && strlen($_POST['password']) > 16)$error['password'] = 'over';

    //登録済み判定
    $sql = $db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE name=?');
    $sql->execute(array($_POST['name']));
    $res = $sql->fetch();
    if($res['cnt']>0){
        $error['name'] = 'already';       
    }
    //エラーがなければデータベースに登録する
    if(empty($error)){
        $statement = $db->prepare('INSERT INTO members SET name=?, password=?');
        $statement->execute(array($_POST['name'],sha1($_POST['password'])));

        header('Location: regist_user_success.php');
        exit();
    }
}
?>

<h1>アカウント作成</h1>
<?php //エラーメッセージの表示
if($error['name']==='blank')echo'<div class="alart">※ニックネームが空です。</div>';
if($error['name']==='over')echo'<div class="alart">※ニックネームが長すぎます。</div>';
if($error['name']==='already')echo'<div class="alart">※登録済みのアカウント名です。</div>';
if($error['password']==='blank')echo'<div class="alart">※パスワードが空です。</div>';
if($error['password']==='shortage')echo '<div class="alart">※パスワードが短すぎます。</div>';
if($error['password']==='over')echo '<div class="alart">※パスワードが長すぎます。</div>';
?>
<form action="" method="post"><table>
<tr><td>ニックネーム(1~16文字)</td><td><input type="textbox" name="name"></td></tr>
<tr><td>パスワード(4~16文字)</td><td><input type="password" name="password"></td></tr>
<tr><td><input type="submit" value="ユーザー登録"></td></tr>
</table><form>
<hr>
※パスワードを忘れるとログインやアカウント削除ができなくなります。ご注意ください<br>
<a href="login.php"><img src="pictures/navigationj_back.png" width="100" height="50" style="margin-bottom: -20px;"></a>

<?php require_once('footer.php'); ?>