<?php
session_start();
require_once('header.php');
require_once('dbconnect.php');

/*
アカウント削除
エラーチェックを行い問題なければデータベースから削除する
*/
$name = $_POST['name'];
$password = sha1($_POST['password']);
if(!empty($_POST)){
    //ゲストアカウントは削除できない
    if($name==='ゲスト')$error['name'] = 'guest';

    //空欄判定
    if($_POST['name'] ==='') $error['name'] = 'blank';
    if($_POST['password']==='')$error['password'] = 'blank';

    //存在判定
    if(empty($error)){
        $isfind = $db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE name=? and password=?');
        $isfind->execute(array($name, $password));
        $del_user = $isfind->fetch();
        //入力情報に合致するユーザーがいれば、画像を全て消去した上でユーザー情報を削除する
        if($del_user['cnt']>0){
            //そのユーザーが登録している画像があれば全て消去する
            $pictures = $db->prepare('SELECT id, picture FROM clothes WHERE owner=?');
            $pictures->execute(array($name));
            while($picture = $pictures->fetch()){
                $pass = 'upload/';
                $pass .= $picture['picture'];
                unlink($pass);
            }
            $del_pictures = $db->prepare('DELETE FROM clothes WHERE owner=?');
            $del_pictures->execute(array($name));

            //ユーザー情報を削除
            $statement = $db->prepare('DELETE FROM members WHERE name=? and password=?');
            $statement->execute(array($name,$password));
            $del_msg = "消去が完了しました。";
        }else{
            $error['name'] = 'not_find';
        }
    }
}
?>

<h1>アカウント削除</h1>
<p>削除したいアカウントのニックネームとパスワードを入力してください。<br>
アカウントを削除すると登録していた服のデータもすべて消去されます。</p>
<?php //エラーメッセージの表示
if($error['name']==='guest')echo'<div class="alart">※ゲストアカウントは削除できません。</div>';
if($error['name']==='blank')echo'<div class="alart">※ニックネームが空です。</div>';
if($error['password']==='blank')echo'<div class="alart">※パスワードが空です。</div>';
if($error['name']==='not_find')echo '<div class="alart">※ニックネームまたはパスワードが間違っています。</div>';
?>
<?php if(!empty($del_msg)):?>
<div style="color: red; font-size: 150%;"><?php echo $del_msg ?></div>
<?php else: ?>
<form action="" method="post"><table>
<tr><td>ニックネーム</td><td><input type="textbox" name="name"></td></tr>
<tr><td>パスワード</td><td><input type="password" name="password"></td></tr>
<tr><td><input type="submit" value="削除"></td></tr>
</table><form>
<?php endif; ?>
<br><br>
<a href="login.php"><img src="pictures/navigationj_back.png" width="100" height="50" style="margin-bottom: -20px;"></a>

<?php require_once('footer.php'); ?>