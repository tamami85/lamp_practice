<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';
require_once MODEL_PATH . 'order_details.php';
require_once MODEL_PATH . 'purchase_history.php';


session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db     = get_db_connect();
$user   = get_login_user($db);

// 明細の一覧表示(表示項目は「商品名」「購入時の商品価格」「購入数」「小計」とする。)
$order_details = get_order_details($db, $history_id);//配列で明細を一気に取得してる
foreach($order_details as $value){//購入明細の表示のためのあだ名つける
    $name   = $value['name'];//「商品名」
    $price  = $value['price'];//「購入時の商品価格」 
    $amount = $value['amount'];//「購入数」
}

$get_total = get_total($db, $history_id);
foreach($get_total as $value){// 表示項目は「注文番号」「購入日時」「該当の注文の合計金額」とする。
    $history_number = $value['history_number'];//「注文番号」
    $created        = $value['created'];//「購入日時」 
    $total_price    = $value['total_price'];//「該当の注文の合計金額」
}


include_once VIEW_PATH . 'order_details_view.php';