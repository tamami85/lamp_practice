<!DOCTYPE html>
<html lang="ja">
<head>
<?php include VIEW_PATH . 'templates/head.php'; ?>
  <title>購入履歴</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'history.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  <h1>購入履歴</h1>
</head>
<body>
    <table>
        <tr>
            <th>注文番号</th>
            <th>購入日時</th>
            <th>合計金額</th>
            <th>購入明細</th>
        </tr>
<?php if(is_admin($user)){ ?>
    <?php foreach($admin_history_data as $value){// 表示項目は「注文番号」「購入日時」「該当の注文の合計金額」とする。?>
        <tr>
            <td><?php print h($value['history_number']); ?></td>
            <td><?php print h($value['created']); ?></td>
            <td><?php print h($value['total_price']); ?></td>
            <td>
                <form method="post" action="show_order_details.php">
                    <input type="submit" value="購入明細">
                    <input type="hidden" name="history_id" value="<?php print h($value['history_number']); ?>">
                    <input type="hidden" name="token" value="<?php print $token; ?>">
                </form>
            </td>
        </tr>
    <?php } ?>
<?php }else{ ?>
    <?php foreach($history_data as $value){// 管理者用?>
        <tr>
            <td><?php print h($value['history_number']); ?></td>
            <td><?php print h($value['created']); ?></td>
            <td><?php print h($value['total_price']); ?></td>
            <td>
                <form method="post" action="show_order_details.php">
                    <input type="submit" value="購入明細">
                    <input type="hidden" name="history_id" value="<?php print h($value['history_number']); ?>">
                    <input type="hidden" name="token" value="<?php print $token; ?>">
                </form>
            </td>
        </tr>
    <?php } ?>
<?php } ?>
    </table>
</body>
</html>