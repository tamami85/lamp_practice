<?php 
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';


// purchase_historyテーブルにデータを新規登録する
function add_purchase_history($db, $user_id){
    $date = date("Y-m-d H:i:s");
    $sql = "
            INSERT INTO
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

// 管理者用の配列取得。合計金額の計算と注文番号と購入日時
function admin_get_history_data($db){
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
        GROUP BY
            purchase_history.history_id
        ORDER BY
            created DESC
    ";
    return fetch_all_query($db, $sql);
}

//一般用の合計金額の計算と注文番号と購入日時
function get_history_data($db, $user_id){//関数名は変更する
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
            user_id = ?
        GROUP BY
            purchase_history.history_id
        ORDER BY
            created DESC
        ";//
        //total_priceって名前で価格とかった量の合計を計算する
        //history_numberって名前で明細のhistory_idを呼ぶ
        //日付を取得
    $params = array($user_id);
    return fetch_all_query($db, $sql, $params);
}

//管理者用購入履歴の配列にあだ名つける
function admin_validate_history($admin_history_data){//購商品履歴のバリデ関数
    if(count($admin_history_data) === 0){//履歴が空やったら
      set_error('購入履歴を取得できませんでした。');//セッション箱にエラーメッセージ入れる
      return false;//処理やめぴ
    }
    return true;//エラーなかったら、何事もなかったかのように澄まし顔
}

//の購入履歴の配列にあだ名つける
function validate_history($history_data){//購商品履歴のバリデ関数
    if(count($history_data) === 0){//履歴が空やったら
      set_error('購入履歴を取得できませんでした。');//セッション箱にエラーメッセージ入れる
      return false;//処理やめぴ
    }
    return true;//エラーなかったら、何事もなかったかのように澄まし顔
}





