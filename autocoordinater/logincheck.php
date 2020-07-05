<?php
//ログインチェック
if(!empty($_SESSION['id'])){
    $members = $db->prepare('SELECT * FROM members WHERE id=?');
    $members->execute(array($_SESSION['id']));
    $member = $members->fetch();
    $name = $_SESSION['name'];
}else{
    header('Location: login.php');
    exit();
}

?>