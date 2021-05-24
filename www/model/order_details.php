<?php 
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

// order_detailsテーブルに値を入れていく
function add_order_details($db, $history_id, $item_id, $price, $amount){
    $sql = "
            INSERT IMTO
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
function get_total_price($db, $history_id){
    $sql = "
            SELECT
                SUM(price * amount) AS total_price,
                order_details.history_id AS history_number,
                purchase_history.created,
            FROM
                order_details
            LEFT OUTER JOIN
                purchase_history
            ON
                order_details.history_id = purchase_history.history_id
            GROUP BY
                history_id = ?              
            ";
    $params = array($history_id);
    return fetch_query($db, $sql, $params);
}


//管理者用の配列取得
function admin_get_total_price($db, $history_id){
    $sql = "
            SELECT
                SUM(price * amount) AS total_price,
                order_details.history_id AS history_number,
                purchase_history.created,
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

    




// どこに置くのか後で考えまひょ


// 明細の一覧表示(表示項目は「商品名」「購入時の商品価格」「購入数」「小計」とする。)
$order_details = get_order_details($db, $history_id);//配列で明細を一気に取得してる
foreach($order_details as $value){
    $value['name'];//「商品名」
    $value['price'];//「購入時の商品価格」 
    $value['amount'];//「購入数」
}

//小計の表示
$total_price['total_price'] = get_total_price($db, $history_id);//配列で１行取得したから、'該当の注文の合計金額'カラムの金額だけを抽出

// 表示項目は「注文番号」「購入日時」「該当の注文の合計金額」とする。
foreach($total_price as $value){
    $value['history_number'];//「注文番号」
    $value['created'];//「購入日時」 
    $value['total_price'];//「該当の注文の合計金額」
}

// 表示項目は「注文番号」「購入日時」「該当の注文の合計金額」とする。（管理者用）
$admin_total_price = admin_get_total_price($db, $history_id);
foreach($admin_total_price as $value){
    $value['history_number'];//「注文番号」
    $value['created'];//「購入日時」 
    $value['total_price'];//「該当の注文の合計金額」
}
