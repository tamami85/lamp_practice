<?php 
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';


// purchase_historyテーブルにデータを新規登録する
function add_purchase_history($db, $date, $user_id){
    $sql = "
            INSERT IMTO
                purchase_history(
                    created,
                    user_id
                )
            VALUES
                (?, ?)
            ";
    $params = array($date, $user_id);
    return execute_query($db, $sql, $params);
}


// purchase_historyテーブルを表示する
function get_purchase_history($db, $user_id){
    $sql = "
            SELECT
                history_id,
                created,
                user_id
            FROM
                purchase_history
            WHERE
                user_id = ?
            ";
    $params = array($user_id);
    return fetch_all_query($db, $sql, $params);
}

// 全部見られる管理者用の購入履歴
function admin_get_purchase_history($db){
    $sql = "
            SELECT
                history_id,
                created,
                user_id
            FROM
                purchase_history
            ";
    return fetch_all_query($db, $sql);
}


