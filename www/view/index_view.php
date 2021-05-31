<!DOCTYPE html>
<html lang="ja">
<head>
  <?php include VIEW_PATH . 'templates/head.php'; ?>
  
  <title>商品一覧</title>
  <link rel="stylesheet" href="<?php print(STYLESHEET_PATH . 'index.css'); ?>">
</head>
<body>
  <?php include VIEW_PATH . 'templates/header_logined.php'; ?>
  

  <div class="container">
    <h1>商品一覧</h1>
    <?php include VIEW_PATH . 'templates/messages.php'; ?>

    <form method="get">
      <select id="choices" name="choices" required>
          <option value="created DESC" selected>新着順</option>
          <option value="price">価格の安い順</option>
          <option value="price DESC">価格の高い順</option>
      </select>
      <input type="submit" name="sort" value="並べ替え">
    </form>

    <script>
      window.onload=function(){
        let choices=document.getElementById('choices');
        choices.addEventListener('change', function(){
          location.href='index.php?sort=並べ替え&choices='+this.value;
        },false)
      }
    
    </script>
    <div class="card-deck">
      <div class="row">

      <?php if(isset($_GET['sort']) === true){ ?>
        <?php $item_array = change_sort($db, $choices); ?>
      <?php }else{ ?>
        <?php $item_array = get_open_items($db); ?>
      <?php } ?>

      <?php foreach($item_array as $item){ ?>
        <div class="col-6 item">
          <div class="card h-100 text-center">
            <div class="card-header">
              <?php print(h($item['name'])); ?>
            </div>
            <figure class="card-body">
              <img class="card-img" src="<?php print(IMAGE_PATH . h($item['image'])); ?>">
              <figcaption>
                <?php print(number_format(h($item['price']))); //number_formatは1000の位ごとにコロン入れる関数?>円
                <?php if($item['stock'] > 0){ ?>
                  <form action="index_add_cart.php" method="post">
                    <input type="submit" value="カートに追加" class="btn btn-primary btn-block">
                    <input type="hidden" name="item_id" value="<?php print(h($item['item_id'])); ?>">
                    <input type="hidden" name="token" value="<?php print $token; ?>">
                  </form>
                <?php } else { ?>
                  <p class="text-danger">現在売り切れです。</p>
                <?php } ?>
              </figcaption>
            </figure>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>
  </div>
  
</body>
</html>