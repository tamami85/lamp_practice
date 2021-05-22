-- 購入履歴画面を作る
-- 「注文番号」「購入日時」「該当の注文の合計金額」が必要
-- 注文番号はオートインクリメント
-- 購入日時はカートテーブルからひっぱってくる
-- 該当の注文の合計金額はpriceとamountから計算する

-- purchase_historyテーブル作る
-- history_idは自動
-- item_id、priceはitemテーブルから取ってくる
-- amountはcartテーブルから取ってくる

CREATE TABLE 'purchase_history' (
    `history_id` int(11) NOT NULL AUTO_INCREMENT,
    'item_id' int(11) NOT NULL,
    `price` int(11) NOT NULL,
    `amount` int(11) NOT NULL,
    primary key(history_id)
);



-- 購入明細画面を作る
-- 「商品名」「購入時の商品価格」「購入数」「小計」が必要
-- 商品名、購入時の商品価格、購入数はpurchase_historyテーブルから取ってくる
-- 小計は計算する

-- order_detailsテーブル作る
-- history_idはpurchase_historyテーブルから取ってくる
-- createdはcartテーブルから取ってくる
-- user_idはuserテーブルから取ってくる
CREATE TABLE 'order_details' (
    `history_id` int(11) NOT NULL,
    `created` datetime NOT NULL,
    `user_id` int(11) NOT NULL,
);
