<?php
session_start();
require('header.php');
require('dbconnect.php');

if(!empty($_POST)){
    //空欄があった場合の処理
    if($_POST['name'] ==='') $error['name'] = 'blank';
    if($_POST['password']==='')$error['password'] = 'blank';

    //登録済みのメールアドレスが入力された時の処理
    $sql = $db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE name=?');
    $sql->execute(array($_POST['name']));
    $res = $sql->fetch();
    if($res['cnt']>0){
        $error['name'] = 'registed';       
    }

    if(empty($error)){
        //データベースに登録する
        $statement = $db->prepare('INSERT INTO members SET name=?, password=?');
        $statement->execute(array($_POST['name'],$_POST['password']));

        header('Location: regist_user_success.php');
        exit();
    }
}
?>

<h1>アカウント作成</h1>
<?php
if($error['name']==='blank')echo'※アカウント名が空です。<br>';
if($error['password']==='blank')echo'※パスワードが空です。<br>';
if($error['name']==='registed')echo'※登録済みのアカウント名です。<br>';
?>
<form action="" method="post"><table>
<tr><td>アカウント名</td><td><input type="textbox" name="name"></td></tr>
<tr><td>パスワード</td><td><input type="password" name="password"></td></tr>
<tr><td><input type="submit" value="ユーザー登録"></td></tr>
</table><form>
※アカウント名は重複不可です<br><br>
<a href="login.php"><img src="pictures/navigationj_back.png" width="100" height="50" style="margin-bottom: -20px;"></a>

<?php require('footer.php'); ?>