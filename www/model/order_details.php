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
                history_id AS 注文番号,
                SUM(price) AS 該当の注文の合計金額
            FROM
                order_details
            GROUP BY
                history_id = ?              
            ";
    $params = array($history_id);
    return fetch_query($db, $sql, $params);
}
    




// どこに置くのか後で考えまひょ

// 明細の一覧表示(表示項目は「商品名」「購入時の商品価格」「購入数」「小計」とする。)
$order_details = get_order_details($db, $history_id);//配列で明細を一気に取得してる
foreach($order_details as $value){
    $value['name'];//「商品名」
    $value['price'];//「購入時の商品価格」 
    $value['amount'];//「購入数」
}
// 明細の小計、および画面上部に表示させる「合計金額」
$subtotal_price['該当の注文の合計金額'] = get_total_price($db, $history_id);//配列で１行取得したから、'該当の注文の合計金額'カラムの金額だけを抽出


    