<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'order_details.php';
require_once MODEL_PATH . 'purchase_history.php';


session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db      = get_db_connect();
$user    = get_login_user($db);
$user_id = $user['user_id'];

$history_id = get_post('history_id');

$order_details_top = get_order_details_top($db, $history_id);//その商品の注文番号、購入日時、合計の配列

// 明細の一覧表示(表示項目は「商品名」「購入時の商品価格」「購入数」「小計」とする。)
$order_details = get_order_details($db, $history_id);//配列で明細を一気に取得してる


include_once VIEW_PATH . 'order_details_view.php';