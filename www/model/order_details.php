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
                items.name
            FROM
                order_details
            LEFT OUTER JOIN
                items
            ON
                order_details.item_id = items.item_id
            WHERE
                history_id = ?
            ";
            // 「ソート順は注文の新着順とする」つまりhistory_idが大きい順
            //　itemテーブルと結合して、itemの名前をもらう
    $params = array($history_id);
    return fetch_all_query($db, $sql, $params);
}

//一般用の合計金額の計算と注文番号と購入日時
function get_order_details_top($db, $history_id){//関数名は変更する
    $sql = "
        SELECT
            SUM(price * amount) AS total_price,
            purchase_history.history_id AS history_number,
            purchase_history.created
        FROM
            purchase_history
        LEFT OUTER JOIN
            order_details
        ON
            purchase_history.history_id = order_details.history_id
        WHERE
            purchase_history.history_id = ?
        GROUP BY
            purchase_history.history_id
        ";//
        //total_priceって名前で価格とかった量の合計を計算する
        //history_numberって名前で明細のhistory_idを呼ぶ
        //日付を取得
    $params = array($history_id);
    return fetch_all_query($db, $sql, $params);
}


//購入履歴と購入明細を同時にインサート
function insert_history($db, $user_id, $carts){//
    add_purchase_history($db, $user_id);//まず購入履歴に値を入れる
    $history_id = $db->lastInsertId();
    foreach($carts as $value){//カート内をぐるぐるして３つにあだ名つける
        $item_id = $value['item_id'];
        $price = $value['price'];
        $amount = $value['amount'];
        
        add_order_details($db, $history_id, $item_id, $price, $amount);//購入明細にインサートする
    }
}//

function validate_order_details($order_details){//購商品明細のバリデ関数
    if(count($order_details) === 0){//明細が空やったら
      set_error('購入明細を取得できませんでした。');//セッション箱にエラーメッセージ入れる
      return false;//処理やめぴ
    }
    return true;//エラーなかったら、何事もなかったかのように澄まし顔
}


