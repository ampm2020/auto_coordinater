<?php
/*
気温に合わせて実際に服を選ぶスクリプト
*/

//【関数】クエリを実行して結果を配列に格納する
//引数：DB、クエリ、格納先の配列
function select_clothes(&$db, $SQL, &$array){
    $result = $db->query($SQL);
    while($res = $result->fetch()){
        $array[] = $res;
    }
}
//【関数】：clothesテーブルから2種類の服のidと画像名を取得
function select_clothes_2(&$db, $type1, $type2, &$array){
    $time = date('Y-m-d', strtotime('-1 day'));
    $sql = $db->prepare('SELECT id, picture FROM clothes WHERE 
                        used_date<? and (type=? or type=?) ORDER BY RAND() LIMIT 1');
    $sql->execute(array($time, $type1, $type2));
    while($res = $sql->fetch()){
        $array[] = $res;
    }
}
//【関数】：clothesテーブルから任意の種類の服１枚のidと画像名を取得
function select_clothes_v(&$db, &$array, ...$types){
    $time = date('Y-m-d', strtotime('-1 day'));//最後に着たのが2日以上前のものから選ぶ
    $num = count($types);

    $sql = 'SELECT id, picture FROM clothes WHERE used_date<"';
    $sql .= $time.'" and (';
    for($i=0; $i<$num; $i++){
        $sql .= 'type="'.$types[$i].'" ';
        if($i < $num - 1)$sql .= 'or ';
        else $sql .=')';     
    }
    $sql .= 'ORDER BY RAND() LIMIT 1';
    //echo $sql.'<br>'; //slq文のデバッグ
    $result = $db->query($sql);
    while($res = $result->fetch()){
        $array[] = $res;
    }
}

//26度以上
//【上】Tシャツ、ポロシャツから１枚
//【下】チノパンから１枚 なければジーンズから１枚
if($min_temperature >= 26){
    select_clothes_v($db, $selected_tops,"t_short", "poro");
    select_clothes_v($db, $selected_bottoms, "chino_thin");
}
//22~25度
//【上】２枚：半Torポロシャツorインナーから１枚 + 長Torチェックシャツから１枚　１枚：長Tor半Torポロシャツから１枚
//【下】チノパンから１枚　なければジーンズから１枚
else if($min_temperature >= 22){
    $r = rand(1, 2);//１なら2枚、2なら１枚着る
    if($r===1){
        $sql = 'SELECT id,picture FROM clothes WHERE type="t_short" or type="poro" or type="inner" ORDER BY RAND() LIMIT 1';
        select_clothes($db, $sql, $selected_tops);
        $sql = 'SELECT id,picture FROM clothes WHERE type="t_long" or type="check" ORDER BY RAND() LIMIT 1';
        select_clothes($db, $sql, $selected_tops);
    }
    if($r===2 || count($selected_tops) < 2){
        unset($selected_tops);
        $sql = 'SELECT id,picture FROM clothes WHERE type="t_short" or type="poro" or type="t_long" ORDER BY RAND() LIMIT 1';
        select_clothes($db, $sql, $selected_tops);        
    }
    $sql = 'SELECT id,picture FROM clothes WHERE type="chino_thin" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_bottoms);

}
//19~21度
//22~25度の条件から2枚重ねのみを選べる
else if($min_temperature >= 19){
    $sql = 'SELECT id,picture FROM clothes WHERE type="t_short" or type="inner" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops);
    $sql = 'SELECT id,picture FROM clothes WHERE type="t_long" or type="check" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops);
    $sql = 'SELECT id,picture FROM clothes WHERE type="chino_thin" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_bottoms); 

}
//14~18度
//上は3枚重ね着。3枚目はパーカーかスウェットかジージャン。下は厚手でもよい
else if($min_temperature >= 14){
    $sql = 'SELECT id,picture FROM clothes WHERE type="t_short"or type="inner" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops);
    $sql = 'SELECT id,picture FROM clothes WHERE type="t_long" or type="check" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops);
    $sql = 'SELECT id,picture FROM clothes WHERE type="parker" or type="sweat" or type="jijan" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops); 

    $sql = 'SELECT id,picture FROM clothes WHERE type="chino_thin" or type="chino_thick" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_bottoms); 
    
}
//10~13度
//上は3枚+薄いアウター。下は厚いチノパンかジーンズ
else if($min_temperature >= 10){
    $sql = 'SELECT id,picture FROM clothes WHERE type="t_short" or type="inner" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops);
    $sql = 'SELECT id,picture FROM clothes WHERE type="t_long" or type="check" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops);
    $sql = 'SELECT id,picture FROM clothes WHERE type="parker" or type="sweat" or type="jijan" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops);    
    $sql = 'SELECT id,picture FROM clothes WHERE type="outer_thin" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops); 

    $sql = 'SELECT id,picture FROM clothes WHERE type="chino_thick" or type= "jeans" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_bottoms);  

//9度以下
//3枚+厚いアウター
}else if($min_temperature < 10){
    $sql = 'SELECT id,picture FROM clothes WHERE type="t_short"or type="inner" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops);
    $sql = 'SELECT id,picture FROM clothes WHERE type="t_long" or type="check" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops);
    $sql = 'SELECT id,picture FROM clothes WHERE type="parker" or type="sweat" or type="jijan" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops);    
    $sql = 'SELECT id,picture FROM clothes WHERE type="outer_thick" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_tops); 

    $sql = 'SELECT id,picture FROM clothes WHERE type="chino_thick" or type= "jeans" ORDER BY RAND() LIMIT 1';
    select_clothes($db, $sql, $selected_bottoms);   

}

?>