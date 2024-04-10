<?php include("./backend/nodes.php") ?>
<!DOCTYPE html>
<html>

<head>
  <?php include("./components/head.php"); ?>
</head>

<body>
  <?php include("./components/navbar.php"); ?>


  <?php
  $product = $helpers->select_all_individual("products", "id='$_GET[id]'");
  $category = $helpers->select_all_individual("categories", "id='$product->category_id'");
  ?>
  <div class="products">
    <div class="container">
      <div class="agileinfo_single">
        <div class="col-md-4 agileinfo_single_left">
          <img id="example" src="<?= $product->product_img ?>" alt=" " class="img-responsive" />
        </div>
        <div class="col-md-8 agileinfo_single_right">
          <h2 style="margin-bottom: 0;"><?= $product->name ?></h2>
          <p><small><?= $product->quantity ?> item(s) left</small></p>
          <div class="w3agile_description">
            <h4>Description :</h4>
            <p>
              <?= nl2br($product->description) ?>
            </p>
          </div>
          <div class="snipcart-item block">
            <div class="snipcart-thumb agileinfo_single_right_snipcart">
              <h4 class="m-sing">₱<?= number_format($product->selling_price, 2) ?></h4>
            </div>
            <div class="snipcart-details agileinfo_single_right_details">
              <button type="button" class="btn btn-primary" style="padding: 6px 30px" onclick="addToCart(`<?= $product->id ?>`, `<?= $product->quantity ?>`,`<?= $category->slug ?>`)">
                Add to cart
              </button>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>

  <!-- Bootstrap Core JavaScript -->
  <?php include("./components/scripts.php") ?>

</body>

</html>