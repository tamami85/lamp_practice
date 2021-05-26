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

$db = get_db_connect();
$user = get_login_user($db);
$user_id = $user['user_id'];


$post_token = get_post('token');//ポストで隠されて来たトークンにあだ名つける
is_valid_csrf_token($post_token);//ポストで来たトークンをバリデする

$history = get_post('history');//履歴ボタンはちゃんと押されてるんか？
is_valid_user_id($user['user_id']);//$userつまり$user_idがちゃんと飛んできてるかチェック

$carts = get_user_carts($db, $user['user_id']);//カート内に何が入ってるか配列で取得

if(is_valid_csrf_token(get_post('token')) === false){//ポストされてきたトークンがバリデしたけどfalseで返してきよったら（つまりポストされたやつとセッションに入ってるやつが一致せんかったら
  set_error('不正な処理が行われました');//セッション箱のエラーのとこに入れる
  $_SESSION = array();//セッション箱空にする
  redirect_to(LOGIN_URL);//ログインページに戻らせる
} else {

  $db->beginTransaction();//トランザクション開始
  if(purchase_carts($db, $carts) === false){
    set_error('商品が購入できませんでした。');
    redirect_to(CART_URL);
  }

  insert_history($db, $user_id, $carts);//商品履歴と商品明細に値入れる

  if(isset($_SESSION['__errors']) === false || count($_SESSION['__errors']) === 0){//エラーがなかったら
    $db->commit();//コミットちゃん
  }else{
    $db->rollback();//振り出しに戻る
  }


  $_SESSION['csrf_token'] = '';//トークンの破棄
  get_csrf_token();//トークンまた新しく作る
}


$total_price = sum_carts($carts);



include_once '../view/finish_view.php';