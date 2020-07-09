<?php
/*
ゲストアカウントの初期化
*/

//ユーザー名が「ゲスト」の全データおよび画像ファイルを削除
$result = $db->query('SELECT id, picture FROM clothes WHERE owner="ゲスト"');
while($res = $result->fetch()){
    $pass = 'upload/';
    $pass .= $res['picture'];
    unlink($pass);
}
$db->query('DELETE FROM clothes WHERE owner="ゲスト"');

//サンプルデータを新しく登録する
$db->query('INSERT INTO clothes(owner, type, picture) VALUES("ゲスト", "inner", "sample1.png")');
$db->query('INSERT INTO clothes(owner, type, picture) VALUES("ゲスト", "t_short", "sample2.png")');
$db->query('INSERT INTO clothes(owner, type, picture) VALUES("ゲスト", "t_short", "sample3.png")');
$db->query('INSERT INTO clothes(owner, type, picture) VALUES("ゲスト", "poro", "sample4.png")');
$db->query('INSERT INTO clothes(owner, type, picture) VALUES("ゲスト", "poro", "sample5.png")');
$db->query('INSERT INTO clothes(owner, type, picture) VALUES("ゲスト", "t_long", "sample6.png")');
$db->query('INSERT INTO clothes(owner, type, picture) VALUES("ゲスト", "check", "sample7.png")');
$db->query('INSERT INTO clothes(owner, type, picture) VALUES("ゲスト", "parker", "sample8.png")');
$db->query('INSERT INTO clothes(owner, type, picture) VALUES("ゲスト", "parker", "sample9.png")');
$db->query('INSERT INTO clothes(owner, type, picture) VALUES("ゲスト", "trainer", "sample10.png")');
$db->query('INSERT INTO clothes(owner, type, picture) VALUES("ゲスト", "seta", "sample11.png")');
$db->query('INSERT INTO clothes(owner, type, picture) VALUES("ゲスト", "seta", "sample12.png")');
$db->query('INSERT INTO clothes(owner, type, picture) VALUES("ゲスト", "cardigan_chack", "sample13.png")');
$db->query('INSERT INTO clothes(owner, type, picture) VALUES("ゲスト", "outer_thin", "sample14.png")');
$db->query('INSERT INTO clothes(owner, type, picture) VALUES("ゲスト", "outer_thin", "sample15.png")');
$db->query('INSERT INTO clothes(owner, type, picture) VALUES("ゲスト", "outer_thick", "sample16.png")');
$db->query('INSERT INTO clothes(owner, type, picture) VALUES("ゲスト", "outer_thick", "sample17.png")');
$db->query('INSERT INTO clothes(owner, type, picture) VALUES("ゲスト", "chino_thin", "sample18.png")');
$db->query('INSERT INTO clothes(owner, type, picture) VALUES("ゲスト", "other_b", "sample19.png")');

//画像をuploadファイルにコピー
$num = 19;
for($i=1; $i<=$num; $i++){
    $before_pass = 'guest/sample'.$i.'.png';
    $after_pass = 'upload/sample'.$i.'.png';
    copy($before_pass, $after_pass);
}