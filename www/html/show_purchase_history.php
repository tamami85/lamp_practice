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
$token = get_csrf_token();//ビュー側でvalueに入ってる$tokenを作った

if(is_admin($user)){//もし管理者がログインしてたら
    $admin_history_data = admin_get_history_data($db);//購入履歴の「注文番号」「購入日時」「該当の注文の合計金額」を配列で取得してあだ名つける
    admin_validate_history($admin_history_data);//バリデ
}else{//管理者以外がログインしてたら
    $history_data = get_history_data($db, $user_id);//購入履歴の「注文番号」「購入日時」「該当の注文の合計金額」を配列で取得してあだ名つける
    validate_history($history_data);//バリデ
}


include_once VIEW_PATH . 'purchase_history_view.php';