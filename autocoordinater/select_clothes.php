<?php
/*
気温に合わせて実際に服を選ぶスクリプト
自分向けのアプリなので自分が判断基準になっている（チノパン＞ジーンズなど）
個々人の好みに合わせるのは現時点の実力では難しい
*/

//【関数】クエリを実行して結果を配列に格納する
//引数：DB、クエリ、格納先の配列
function select_clothes(&$db, $SQL, &$array){
    $result = $db->query($SQL);
    while($res = $result->fetch()){
        $array[] = $res;
    }
}

/* SQL文テンプレ
    $sql = 'SELECT picture FROM clothes WHERE type="" ORDER BY RAND() LIMIT 1';
*/
$min_tops; $min_bottoms;
//26度以上
//【上】Tシャツ、ポロシャツから１枚
//【下】チノパンから１枚 なければジーンズから１枚
if($max_tmperature >= 26){
    $sql = 'SELECT picture FROM clothes WHERE type="t_short" or type="poro" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops);

    $sql = 'SELECT picture FROM clothes WHERE type="chino_thin" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_bottoms);

    $min_tops = 1; $min_bottoms = 1;
}
//22~25度
//【上】２枚：半Torポロシャツorインナーから１枚 + 長Torチェックシャツから１枚　１枚：長Tor半Torポロシャツから１枚
//【下】チノパンから１枚　なければジーンズから１枚
else if($max_tmperature >= 22){
    $r = rand(1, 2);//１なら2枚、2なら１枚着る。あくまで仮の処置であり、後で変更する
    if($r===1){
        $sql = 'SELECT picture FROM clothes WHERE type="t_short" or type="poro" or type="inner" ORDER BY RAND() LIMIT 1';
        select_clothes($db, $sql, $selected_tops);
        $sql = 'SELECT picture FROM clothes WHERE type="t_long" or type="check" ORDER BY RAND() LIMIT 1';
        select_clothes($db, $sql, $selected_tops);
    }
    if($r===2 || count($selected_tops) < 2){
        unset($selected_tops);
        $sql = 'SELECT picture FROM clothes WHERE type="t_short" or type="poro" or type="t_long" ORDER BY RAND() LIMIT 1';
        select_clothes($db, $sql, $selected_tops);        
    }
    $sql = 'SELECT picture FROM clothes WHERE type="chino_thin" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_bottoms);

    $min_tops = 1; $min_bottoms = 1;
}
//19~21度
//22~25度の条件から2枚重ねのみを選べる
else if($max_tmperature >= 19){
    $sql = 'SELECT picture FROM clothes WHERE type="t_short" or type="poro" or type="inner" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops);
    $sql = 'SELECT picture FROM clothes WHERE type="t_long" or type="check" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops);
    $sql = 'SELECT picture FROM clothes WHERE type="chino_thin" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_bottoms); 

    $min_tops = 2; $min_bottoms = 1;
}
//14~18度
//上は3枚重ね着。3枚目はパーカーかスウェットかジージャン。下は厚手でもよい
else if($max_tmperature >= 14){
    $sql = 'SELECT picture FROM clothes WHERE type="t_short" or type="poro" or type="inner" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops);
    $sql = 'SELECT picture FROM clothes WHERE type="t_long" or type="check" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops);
    $sql = 'SELECT picture FROM clothes WHERE type="parker" or type="sweat" or type="jijan" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops); 

    $sql = 'SELECT picture FROM clothes WHERE type="chino_thin" or type="chino_thick" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_bottoms); 
    
    $min_tops = 3; $min_bottoms = 1;
}
//10~13度
//上は3枚+薄いアウター。下は厚いチノパンかジーンズ
else if($max_tmperature >= 10){
    $sql = 'SELECT picture FROM clothes WHERE type="t_short" or type="poro" or type="inner" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops);
    $sql = 'SELECT picture FROM clothes WHERE type="t_long" or type="check" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops);
    $sql = 'SELECT picture FROM clothes WHERE type="parker" or type="sweat" or type="jijan" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops);    
    $sql = 'SELECT picture FROM clothes WHERE type="outer_thin" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops); 

    $sql = 'SELECT picture FROM clothes WHERE type="chino_thick" or type= "jeans" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_bottoms);  
    
    $min_tops = 4; $min_bottoms = 1;

//9度以下
//3枚+厚いアウター
}else if($max_tmperature < 10){
    $sql = 'SELECT picture FROM clothes WHERE type="t_short" or type="poro" or type="inner" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops);
    $sql = 'SELECT picture FROM clothes WHERE type="t_long" or type="check" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops);
    $sql = 'SELECT picture FROM clothes WHERE type="parker" or type="sweat" or type="jijan" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops);    
    $sql = 'SELECT picture FROM clothes WHERE type="outer_thick" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops); 

    $sql = 'SELECT picture FROM clothes WHERE type="chino_thick" or type= "jeans" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_bottoms);   

    $min_tops = 4; $min_bottoms = 1;
}

//枚数チェック。最低枚数に達していなければ配列の中身を消去
//この仕様だと足りてない服の種類がわからなくあってしまう。要改善
if(!empty($selected_tops) && count($selected_tops) < $min_tops){
    unset($selected_tops);
}
if(!empty($selected_bottoms) && count($selected_bottoms) < $min_bottoms){
    unset($selected_bottoms);
}
?>