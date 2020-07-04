<?php
/*
気温に合わせて実際に服を選ぶスクリプト
*/

//clothesテーブルから任意の種類の服１枚のidと画像名を取得
function select_clothes(&$db, &$array, ...$types){
    $time = date('Y-m-d', strtotime('-1 day'));//今日、または昨日着た服を選択肢から除外
    $len = count($types);
    if(!empty($_SESSION['name'])){
        $name = $_SESSION['name'];
    }else{
        $name = "gest";
    }

    //sql文の作成
    $sql = 'SELECT id, type, picture FROM clothes WHERE owner=? and used_date<"';
    $sql .= $time.'" and (';
    for($i=0; $i<$len; $i++){
        $sql .= 'type="'.$types[$i].'" ';
        if($i < $len - 1)$sql .= 'or ';
        else $sql .=')';     
    }
    $sql .= 'ORDER BY RAND() LIMIT 1';
    //echo $sql.'<br>'; //※デバッグ用
    $result = $db->prepare($sql);
    $result->execute(array($name));
    $is_get = false;
    while($res = $result->fetch()){
        $array[] = $res;
        $is_get = true;
    }
    //条件に合う服を取得できなかった場合は、代わりにその旨が伝わる画像をセットする
    if(!$is_get){
        $tmp = ['id' => 0, 'picture' => "10195no_image_square.png",];
        $array[] = $tmp;
    }
}

//23度以上 暑い。半袖
if($min_temperature >= 23){
    select_clothes($db, $selected_tops,"t_short", "poro","other1");
    select_clothes($db, $selected_bottoms, "chino_thin", "other_b");
}
//19~22度　あったかい。半袖～薄手のシャツとか
else if($min_temperature >= 19){
    $r = rand(1, 2);//１なら2枚、2なら１枚着る
    if($r===1){
        if($max_temperature >=26){
        select_clothes($db, $selected_tops, "t_short","other1");           
        }else{
        select_clothes($db, $selected_tops, "t_short", "inner","other1");
        }
        select_clothes($db, $selected_tops, "t_long", "check","other2");
    }
    if($r===2 || count($selected_tops) < 2){
        unset($selected_tops);
        select_clothes($db, $selected_tops, "t_short", "poro", "t_long","other2");       
    }
    select_clothes($db, $selected_tops, "chino_thin","other_b");

}
//16~18度　過ごしやすい。半袖+薄手の長袖
else if($min_temperature >= 16){
    if($max_temperature >=26){
        select_clothes($db, $selected_tops, "t_short","other1");           
    }else{
        select_clothes($db, $selected_tops, "t_short", "inner","other1");
        }
    select_clothes($db, $selected_tops, "t_long", "check","other2");
    select_clothes($db, $selected_bottoms, "chino_thin", "other_b");
}
//11~15度 ちょっと寒い。3枚重ね。最高気温がこのくらいなら厚手のズボンもありかも。
else if($min_temperature >= 11){
    if($max_temperature >=26){
        select_clothes($db, $selected_tops, "t_short","other1");           
    }else{
        select_clothes($db, $selected_tops, "t_short", "inner","other1");
        }
    select_clothes($db, $selected_tops, "t_long", "check","other2");
    if($max_temperature >= 19){
    select_clothes($db, $selected_tops, "parker","check_thick","cardigan_check","other3");        
    }else{
    select_clothes($db, $selected_tops, "parker", "trainer", "check_thick", "seta", "cardigan", "cardigan_check","other3");
    }
    select_clothes($db, $selected_bottoms, "chino_thin","other3"); 
}
//7~10度 寒そう。3枚+アウター。ヒートテックや厚手のズボンも。
else if($min_temperature >= 7){
    select_clothes($db, $selected_tops, "t_short", "inner","other1");
    select_clothes($db, $selected_tops, "t_long", "check","other2");
    if($max_temperature >= 19){
    select_clothes($db, $selected_tops, "parker","check_thick","cardigan_check","other3");        
    }else{
    select_clothes($db, $selected_tops, "parker", "trainer", "check_thick", "seta", "cardigan", "cardigan_check","other3");
    }
    select_clothes($db, $selected_tops, "outer_thin", "other4");
    select_clothes($db, $selected_bottoms, "chino_thin", "chino_thick", "other_b");

//6度以下 寒い。3枚+厚いアウター
}else if($min_temperature > -50){
    select_clothes($db, $selected_tops, "t_short", "inner","other1");
    select_clothes($db, $selected_tops, "t_long", "check", "other2");
    if($max_temperature >= 19){
    select_clothes($db, $selected_tops, "parker","check_thick","cardigan_check","other3");        
    }else{
    select_clothes($db, $selected_tops, "parker", "trainer", "check_thick", "seta", "cardigan", "cardigan_check","other3");
    }
    select_clothes($db, $selected_tops, "outer_thin", "outer_thick","other4");
    select_clothes($db, $selected_bottoms, "chino_thin", "chino_thick","other_b");
}else{
    //条件に合う服がない場合 デバッグ用
    select_clothes($db, $selected_tops, "null");
    select_clothes($db, $selected_bottoms, "null");
}

?>