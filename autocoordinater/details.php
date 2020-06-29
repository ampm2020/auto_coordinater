<?php 
require('header.php');
?>
<h1>主な仕様</h1>
<div>
    <p>・気温に合わせてちょうどいい服を選んでくれます。</p>
    <p>・最高気温と最低気温を入力して「服を選ぶ」を押すと、温度ごとに7段階程度の基準に従って服を見繕ってきます。</p>
    <p>・基本的には最低気温を基準にしています。最高気温によってはセーター等の一部の服が選ばれないこともあります(未実装)。</p>
    <p>・選ばれる服は、基準に沿ったものの中からランダムで選ばれます。もう一度「服を選ぶ」を押せば結果を選びなおすこともできます。</p>
    <p>・服が表示されている状態で「これで決まり」を押すと、翌々日になるまではその服が候補に現れなくなります（洗濯のため。アウター等を除く）</p>
    <p>・適当な服がなければ「no image」画像が表示されます。そんな時は新しい服を買いに行くとよいでしょう。</p>
    <p>・下着や靴下などは考慮していません。</p>
    <p>・ランダム選定なのでファッションセンスの保証はできません。</p>
</div>
<h1>クローゼットについて</h1>
<div>
    <p>・クローゼットのアイコンを押すと衣服管理のページに飛びます。</p>
    <p>・衣服管理では、衣服の登録、絞り込み検索、削除ができます。</p>
    <p>・衣服を登録するには「新しい服を登録する」をクリックし、服の写真と分類を設定してから「登録」ボタンを押します。登録に成功するとメッセージが表示されます。</p>
    <p>・検索したい場合は該当する服の種類にチェックを入れて「表示」を押すと条件にあった服の画像が表示されます。</p>
    <p>・服が表示された状態で、右下の「削除」ボタンを押すとその服の情報をデータベースから抹消できます。</p>

</div>
<a href="toppage.php">戻る</a>
<?php
require('footer.php');
?>