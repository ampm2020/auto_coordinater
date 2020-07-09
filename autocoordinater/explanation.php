<?php 
require('header.php');
?>
<a href="index.php"><img src="pictures/navigationj_back.png" width="100" height="50" style="margin-bottom: -20px;"></a>
<h1>これなに？</h1>
<div>
    <p>
    その日に着る服をワンポチで選んでくれるアプリです。<br>
    毎朝何を着るか考えるのが面倒くさく、じゃあコンピュータにやらせちゃおうと思って作りました。<br>
    </p>
</div>
<h1>使い方</h1>
<div>
    <p>【準備】<br>手持ちの服を写真に撮ってデータベースにアップロードしておきます。(これがなかなか面倒)<br>
    ゲストアカウントの場合はスキップして大丈夫です。</p>
    <p>【1】<br>最高気温・最低気温を入力してから<span class="bold">「選ぶ」</span>ボタンを押してください。<br>
    下記の選定基準に従って服を見繕い、画像を表示します。</p>
    <p>【2】<br>選ばれたコーディネートでよければ<span class="bold">「決定」</span>ボタンを押してください。<br>
    そうすると、選んだ服は2日後まで選択候補から外れるようになります。(洗濯が終わるまでの時間を考慮しています。/アウター・セーターは除く)<br>
    気に入らなかった場合は<span class="bold">「もう一度！」</span>ボタンを押すことで何度でも選びなおすことができます。<br>
    </p>

    <p><div style="font-weight: bold;">注記</div>
    ・服の分類、および選定基準はあくまで作成者自身の都合に合わせたものです。ご了承ください。(細かくカスタマイズできたらいいなと思っています)<br>
    ・条件に合う服が１着もない場合は「no image」と表示されます。そんな時は新しい服を買いに行くのがよいでしょう。<br>
    ・選べるのはトップスとボトムスだけです。下着や靴下などは考慮していません。</p>
</div>
<div>
<h1>選定基準</h1>
<p>トップスは<span class="futoi">「半袖」「薄い長袖」「厚い長袖」「アウター」</span>の４種類で大別しています。<br>
以下の表に従ってランダムに1着ずつ選んできます。ただし、条件によっては選ばれない種類の服（※）も存在します。
<br>
<table id="temp">
<tr><th>最低気温</th><th>トップスの種類</th></tr>
<tr><td id="temp">23℃～</td><td id="temp">半袖のみ</td></tr>
<tr><td id="temp">19℃～22℃</td><td id="temp">薄い長袖 または 半袖 + 薄い長袖</td></tr>
<tr><td id="temp">16℃～18℃</td><td id="temp">半袖 + 薄い長袖</td></tr>
<tr><td id="temp">11℃～15℃</td><td id="temp">半袖 + 薄い長袖 + 厚い長袖</td></tr>
<tr><td id="temp">7℃～10℃</td><td id="temp">半袖 + 薄い長袖 + 厚い長袖 + 薄めのアウター</td></tr>
<tr><td id="temp">～6℃</td><td id="temp">半袖 + 薄い長袖 + 厚い長袖 + 厚めのアウター</td></tr>
</table><br>
ボトムスは生地が薄いか、厚いかでのみ判断しています。<br>
ある程度寒ければ厚地のものを、そうでなければ薄地のものからランダムに１着選ばれます。<br><br>
※半袖1枚だけの日はインナーを選ばない、最低気温が低いが最高気温が高い日はセーター等の脱ぎにくい服を選ばない、など
</p>
</div>
<h1>服の管理</h1>
<div>
<p>服はあらかじめクローゼット(データベース)に登録しておく必要があります。トップページ下部のアイコンを押すと管理ページに移動します。</p>
管理ページでは、服の追加／検索／削除をすることができます。<br>
<span class="bold">【登録】</span>「新しい服を追加する」をクリックし、服の写真と分類を選択してから「追加」ボタンを押してください。登録に成功するとメッセージが表示されます。<br>
<span class="bold">【検索】</span>絞り込みができます。チェックを入れて「表示」を押してください。また、画像をクリックすると拡大した画像が見れます。<br>
<span class="bold">【削除】</span>削除したい服を拡大表示してから、左上の「削除」ボタンを押してください。<br>
</div>
<?php
require('footer.php');
?>