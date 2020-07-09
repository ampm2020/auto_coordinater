<?php
/*
服の分類を格納した配列
*/
$clothes_type_tops = [
    "inner" => "インナー",
    "t_short" => "Tシャツ(半袖)",
    "t_long" => "Tシャツ(長袖)",
    "poro" => "ポロシャツ",
    "check" => "チェックシャツ(薄)",
    "check_thick" => "チェックシャツ(厚)",
    "parker" => "パーカー",
    "trainer" => "トレーナー",
    "seta" =>"セーター",
    "cardigan" => "カーディガン",
    "cardigan_chack" =>"カーディガン(ﾁｬｯｸ)",
    "outer_thin" => "アウター(薄)",
    "outer_thick" => "アウター(厚)",
    "other1" => "その他[半袖]",
    "other2" => "その他[長袖(薄)]",
    "other3" => "その他[長袖(厚)]",
    "other4" => "その他[アウター]",
];
$clothes_type_bottoms = [
    "chino_thin" => "チノパン(薄)",
    "chino_thick" => "チノパン(厚)",
    "other_b" => "その他[ボトムス]",
];
//毎日洗濯しない種類の服
$not_laundly_everyday = [
    "seta", "outer_thin", "outer_thick",
];
