<!DOCTYPE html>
<html lang="ja">
<head>
<?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入明細</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'history.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <h1>購入明細</h1>
<?php foreach($order_details_top as $value){//購入明細の表示のためのあだ名つける ?>
    <p>注文番号：<?php print h($value['history_number']); ?></p>
    <p>購入日時：<?php print h($value['created']); ?></p>
    <p>合計金額：<?php print h($value['total_price']); ?></p>
<?php } ?>
    <table>
        <tr>
            <th>商品名</th>
            <th>商品価格</th>
            <th>購入数</th>
            <th>小計</th>
        </tr>
<?php foreach($order_details as $value){//購入明細の表示のためのあだ名つける ?>
        <tr>
            <td><?php print h($value['name']);//「商品名」); ?></td>
            <td><?php print h($value['price']);//「購入時の商品価格」; ?></td>
            <td><?php print h($value['amount']);//「購入数」 ?></td>
            <td><?php print h($value['amount'] * $value['price']);//「小計」 ?></td>
        </tr>
<?php } ?>
    </table>
</body>
</html>