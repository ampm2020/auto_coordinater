<?php
try{
    $db = new PDO('mysql:dbname=catpunch_autocoordinater;host=mysql1.php.starfree.ne.jp;charaset=utf8','catpunch_ampm', 'mementmori');
} catch(PDOException $e){
    print('DB接続エラー：' . $e->getMessage());
}
?>

