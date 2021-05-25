<?php 
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';
require_once MODEL_PATH . 'cart.php';
require_once MODEL_PATH . 'purchase_history.php';


// order_detailsテーブルに値を入れていく
function add_order_details($db, $history_id, $item_id, $price, $amount){
    $sql = "
            INSERT INTO
                order_details(
                    history_id,
                    item_id,
                    price,
                    amount
                )
            VALUES
                (?, ?, ?, ?)
            ";
    $params = array($history_id, $item_id, $price, $amount);
    return execute_query($db, $sql, $params);
}

// order_detailsテーブルを表示する
function get_order_details($db, $history_id){
    $sql = "
            SELECT
                order_details.history_id,
                order_details.price,
                order_details.amount,
                order_details.item_id,
                item.name
            FROM
                order_details
            LEFT OUTER JOIN
                item
            ON
                order_details.item_id = item.item_id
            WHERE
                history_id = ?
            ORDER BY
                history_id DESC
            ";
            // 「ソート順は注文の新着順とする」つまりhistory_idが大きい順
            //　itemテーブルと結合して、itemの名前をもらう
    $params = array($history_id);
    return fetch_all_query($db, $sql, $params);
}

//合計金額の計算
function get_total($db, $history_id){
    $sql = "
            SELECT
                SUM(price * amount) AS total_price,
                order_details.history_id AS history_number,
                purchase_history.created
            FROM
                order_details
            LEFT OUTER JOIN
                purchase_history
            ON
                order_details.history_id = purchase_history.history_id
            GROUP BY
                history_id = ?              
            ";
            //total_priceって名前で価格とかった量の合計を計算する
            //history_numberって名前で明細のhistory_idを呼ぶ
            //日付を取得
    $params = array($history_id);
    return fetch_query($db, $sql, $params);
}

// 管理者用の配列取得
function admin_get_total_price($db, $history_id){
    $sql = "
            SELECT
                SUM(price * amount) AS total_price,
                order_details.history_id AS history_number,
                purchase_history.created
            FROM
                order_details
            LEFT OUTER JOIN
                purchase_history
            ON
                order_details.history_id = purchase_history.history_id
            GROUP BY
                history_id              
            ";
    return fetch_all_query($db, $sql);
}

//トランザクションで購入履歴と購入明細を同時にインサート
function insert_historical_transaction($db){//
    add_purchase_history($db, $user_id);//まず購入履歴に値を入れる
    //ここからは購入明細に値入れる
    $purchase_history = get_purchase_history($db, $user_id);//購入履歴を配列で持ってくる
    $carts = get_user_carts($db, $user['user_id']);//カートの中を配列で持ってくる
    foreach($purchase_history as $value){//購入履歴ををぐるぐるしてhistory_idにあだ名つける
        $history_id = $value['history_id'];
        foreach($carts as $value){//カート内をぐるぐるして３つにあだ名つける
            $item_id = $value['item_id'];
            $price = $value['price'];
            $amount = $value['amount'];
            
            add_order_details($db, $history_id, $item_id, $price, $amount);//購入明細にインサートする
        }
    }
        
}//

function validate_order_details($order_details){//購商品明細のバリデ関数
    if(count($order_details) === 0){//明細が空やったら
      set_error('購入明細を取得できませんでした。');//セッション箱にエラーメッセージ入れる
      return false;//処理やめぴ
    }
    return true;//エラーなかったら、何事もなかったかのように澄まし顔
}

// function validate_get_total($get_total){//購商品明細の商品のバリデ関数
//     if(count($get_total) === 0){//詳細が空やったら
//       set_error('購入明細の詳細を取得できませんでした。');//セッション箱にエラーメッセージ入れる
//       return false;//処理やめぴ
//     }
//     return true;//エラーなかったら、何事もなかったかのように澄まし顔
// }

// function put_in_variables($db, $user){
//     $carts = get_user_carts($db, $user['user_id']);
//     foreach($carts as $value){
//         $item_id = $value['item_id'];
//         $price = $value['price'];
//         $amount = $value['amount'];
//     }
//     $date = date("Y-m-d H:i:s");
// }

