<?php


             
新着順
function new_arrival($db)
$sql = "
        SELECT
            item_id,
            name,
            price,
            image,
            status,
            created
        FROM
            items
        ORDER BY
            created DESC
        ";
fetch_all_query($db, $sql);


価格の安い順
function cost_asc($db)
$sql = "
        SELECT
            item_id,
            name,
            price,
            image,
            status,
            created
        FROM
            items
        ORDER BY
            price
        ";
fetch_all_query($db, $sql);



価格の高い順
function cost_desc($db)
$sql = "
        SELECT
            item_id,
            name,
            price,
            image,
            status,
            created
        FROM
            items
        ORDER BY
            price DESC
        ";
fetch_all_query($db, $sql);


controler側に置くもの
$sort = get_get('sort');
if($sort === ''){
    $items = get_open_items($db);//すでにある
}
if($sort === 0){
    $new_arrival = new_arrival($db);
}
if($sort === 1){
    $cost_asc = cost_asc($db);
}
if($sort === 2){
    $cost_desc = cost_desc($db);
}


var btn = document.getElementById('btn');

btn.addEventListener('click', function() {
  
    console.log('クリックされました！');
  
}, false);

HTMLのボタン要素をまずは取得してその要素に対してaddEventListener()を実行しています。
これにより、ボタン要素をクリックしたら設定されている関数が実行されるようになるわけです。
今回の例だと、クリックしたあとにコンソールへ文字列が出力されます。


<form method="post" action="">
  <select name="state">
    <option value="1">東京</option>
    <option value="2">埼玉</option>
    <option value="3">群馬</option>
    <option value="4">栃木</option>
    <option value="5">茨城</option>
    <option value="6">千葉</option>
    <option value="7">神奈川</option>
  </select>
</form>

window.addEventListener('DOMContentLoaded', function(){

	// select要素を取得
	var select_state = document.querySelector("select[name=state]");

	select_state.addEventListener('change',function(){

		// 全てのoption要素を取得
		var option_states = document.querySelectorAll("select[name=state] option");
		for(var state of option_states) {

			if(state.selected) {
				console.log(state.value); // 「埼玉」を選択したら「2」と出力
				console.log(state.textContent); // 「埼玉」を選択したら「埼玉」と出力
			}
		}
	});
});

<?php

echo <<<EOM
<script type="text/javascript">
  alert( "TEST" )
</script>
EOM;

?>
EOMは長いから付けてる


VIEW側に置くもの
<form method="get">
    <select name="choices" required>
        <option value="">選択してください</option>
        <option value="0" selected>新着順</option>
        <option value="1">価格の安い順/option>
        <option value="2">価格の高い順</option>
    </select>
    <button type="submit" name="sort" value="並べ替え">
</form>

window.addEventListener('DOMContentLoaded', function(){

	// select要素を取得
	var select_choices = document.querySelector("select[name=choices]");

	select_choices.addEventListener('change',function(){

		// 全てのoption要素を取得
		var option_choices = document.querySelectorAll("select[name=choices] option");
		for(var choices of option_choices) {

			if(choices.selected) {
				Document.write(choices.value); // 「埼玉」を選択したら「2」と出力
				Document.write(state.textContent); // 「埼玉」を選択したら「埼玉」と出力
			}
		}
	});
});

