<?php
// 公開サーバー接続用

try{
    $db = new PDO('mysql:dbname=catpunch_autocoordinater;host=mysql1.php.starfree.ne.jp;charaset=utf8','catpunch_ampm', 'mementmori');
} catch(PDOException $e){
    print('DB接続エラー：' . $e->getMessage());
}

// ローカルサーバー接続用
/*
try{
    $db = new PDO('mysql:dbname=auto coordinater;host=127.0.0.1;charaset=utf8','root', '');
} catch(PDOException $e){
    print('DB接続エラー：' . $e->getMessage());
}
*/
?>

