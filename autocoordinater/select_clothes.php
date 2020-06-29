<?php
/*
気温に合わせて実際に服を選ぶスクリプト
基本的には最低気温を基準にしています（朝は寒いため）
同じ最低気温のとき、最高気温が高いと一部の脱ぎにくい服が選択されなくなります（未実装）
*/

//clothesテーブルから任意の種類の服１枚のidと画像名を取得
function select_clothes(&$db, &$array, ...$types){
    $time = date('Y-m-d', strtotime('-1 day'));//今日、または昨日着た服を選択肢から除外
    $len = count($types);

    //sql文の作成
    $sql = 'SELECT id, type, picture FROM clothes WHERE used_date<"';
    $sql .= $time.'" and (';
    for($i=0; $i<$len; $i++){
        $sql .= 'type="'.$types[$i].'" ';
        if($i < $len - 1)$sql .= 'or ';
        else $sql .=')';     
    }
    $sql .= 'ORDER BY RAND() LIMIT 1';
    //echo $sql.'<br>'; //※デバッグ用
    $result = $db->query($sql);
    $is_get = false;
    while($res = $result->fetch()){
        $array[] = $res;
        $is_get = true;
    }
    //条件に合う服を取得できなかった場合は、代わりにその旨が伝わる画像をセットする
    if(!$is_get){
        $tmp = ['id' => 0, 'picture' => "no_image_square.png",];
        $array[] = $tmp;
    }
}

//26度以上 暑い。半袖
if($min_temperature >= 26){
    select_clothes($db, $selected_tops,"t_short", "poro");
    select_clothes($db, $selected_bottoms, "chino_thin");
}
//22~25度　あったかい。半袖～薄手のシャツとか
else if($min_temperature >= 22){
    $r = rand(1, 2);//１なら2枚、2なら１枚着る
    if($r===1){
        select_clothes($db, $selected_tops, "t_short", "inner");
        select_clothes($db, $selected_tops, "t_long", "check", "poro");
    }
    if($r===2 || count($selected_tops) < 2){
        unset($selected_tops);
        select_clothes($db, $selected_tops, "t_short", "poro", "t_long");       
    }
    select_clothes($db, $selected_tops, "chino_thin");

}
//19~21度　過ごしやすい。半袖+薄手の長袖
else if($min_temperature >= 19){
    select_clothes($db, $selected_tops, "t_short", "inner");
    select_clothes($db, $selected_tops, "t_long", "check");
    select_clothes($db, $selected_bottoms, "chino_thin");
}
//14~18度 ちょっと寒い。3枚重ね。最高気温がこのくらいなら厚手のズボンもありかも。
else if($min_temperature >= 14){
    select_clothes($db, $selected_tops, "t_short", "inner");
    select_clothes($db, $selected_tops, "t_long", "check");
    select_clothes($db, $selected_tops, "parker", "trainer", "jijan", "seta", "cardigan", "cardigan_check");
    select_clothes($db, $selected_bottoms, "chino_thin"); 
}
//10~13度 寒そう。3枚+アウター。ヒートテックや厚手のズボンも。
else if($min_temperature >= 10){
    select_clothes($db, $selected_tops, "t_short", "inner", "inner_hot");
    select_clothes($db, $selected_tops, "t_long", "check");
    select_clothes($db, $selected_tops, "parker", "trainer", "jijan", "seta", "cardigan", "cardigan_check");
    select_clothes($db, $selected_tops, "outer_thin");
    select_clothes($db, $selected_bottoms, "chino_thin", "chino_thick");

//9度以下 寒い。3枚+厚いアウター
}else if($min_temperature > -20){
    select_clothes($db, $selected_tops, "t_short", "inner", "inner_hot");
    select_clothes($db, $selected_tops, "t_long", "check");
    select_clothes($db, $selected_tops, "parker", "trainer", "jijan", "seta", "cardigan", "cardigan_check");
    select_clothes($db, $selected_tops, "outer_thin", "outer_thick");
    select_clothes($db, $selected_bottoms, "chino_thin", "chino_thick");
}else{
    //条件に合う服がない場合のデバッグ用
    echo "寒すぎるので外に出ない方がよいです";
    select_clothes($db, $selected_tops, "null");
    select_clothes($db, $selected_bottoms, "null");
}

?>