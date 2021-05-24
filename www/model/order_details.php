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
                item_id,
                price,
                amount
            FROM
                order_details
            WHERE
                history_id = ?
            ORDER BY
                history_id DESC
            ";
            // 「ソート順は注文の新着順とする」つまりhistory_idが大きい順
    $params = array($history_id);
    return fetch_all_query($db, $sql, $params);
}

// function get_total_price($db, $history_id){
//     $sql = "
//             SELECT
//                 SUM(price) AS 該当の注文の合計金額
//             FROM
//                 order_details;
//             WHERE
//                 history_id = ?
//             ";
//     $params = array($history_id);
//     return fetch_query($db, $sql, $params);
// }
    
    