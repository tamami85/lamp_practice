<?php 
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';


// purchase_historyテーブルにデータを新規登録する
function add_purchase_history($db, $date, $user){
    $sql = "
            INSERT INTO
                purchase_history(
                    created,
                    user_id
                )
            VALUES
                (?, ?)
            ";
    $params = array($date, $user);
    return execute_query($db, $sql, $params);
}

// purchase_historyテーブルを表示する
function get_purchase_history($db, $user){
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
    $params = array($user);
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

//購入履歴の配列にあだ名つける
function validate_purchase_history($purchase_history){//購商品履歴のバリデ関数
    if(count($purchase_history) === 0){//履歴が空やったら
      set_error('購入履歴を取得できませんでした。');//セッション箱にエラーメッセージ入れる
      return false;//処理やめぴ
    }
    return true;//エラーなかったら、何事もなかったかのように澄まし顔
}

// //管理者用の購入履歴の配列にあだ名つける
// function validate_purchase_history($admin_purchase_history){//購商品履歴のバリデ関数
//     if(count($admin_purchase_history) === 0){//履歴が空やったら
//       set_error('購入履歴を取得できませんでした。');//セッション箱にエラーメッセージ入れる
//       return false;//処理やめぴ
//     }
//     return true;//エラーなかったら、何事もなかったかのように澄まし顔
// }





