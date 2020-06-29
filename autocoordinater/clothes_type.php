<?php
/*
服の分類を配列に格納する。
必要に応じてrequireで読み込む
*/
$clothes_type_tops = [
    "inner" => "インナー",
    "inner_hot" => "インナー(暖)",
    "t_short" => "Tシャツ(半袖)",
    "t_long" => "Tシャツ(長袖)",
    "poro" => "ポロシャツ",
    "check" => "チェックシャツ",
    "parker" => "パーカー",
    "trainer" => "トレーナー",
    "jijan" => "ジージャン",
    "seta" =>"セーター",
    "cardigan" => "カーディガン",
    "cardigan_chack" =>"カーディガン(チャック付)",
    "outer_thin" => "アウター(薄)",
    "outer_thick" => "アウター(厚)",
];
$clothes_type_bottoms = [
    "chino_thin" => "チノパン(薄)",
    "chino_thick" => "チノパン(厚)",
    "jeans" => "ジーンズ",
];
//毎日洗濯しない種類の服
$not_laundly_everyday = [
    "seta", "outer_thin", "outer_thick",
];
