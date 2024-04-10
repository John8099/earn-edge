<?php include("./backend/nodes.php") ?>
<!DOCTYPE html>
<html>

<head>
  <?php include("./components/head.php"); ?>
</head>

<body>
  <?php include("./components/navbar.php"); ?>

  <div class="products">
    <div class="container">
      <div class="col-md-4 products-left">
        <div class="categories">
          <h2>Categories</h2>
          <ul class="cate">
            <li>
              <a href="<?= SERVER_NAME . "/shop" ?>"><i class="fa fa-arrow-right" aria-hidden="true"></i>
                All
              </a>
            </li>
            <?php
            $categories = $helpers->select_all_with_params("categories", "id IS NOT NULL LIMIT 4");
            foreach ($categories as $category) :
            ?>
              <li>
                <a href="<?= SERVER_NAME . "/shop?q=$category->slug" ?>"><i class="fa fa-arrow-right" aria-hidden="true"></i>
                  <?= $category->formatted_name ?>
                </a>
              </li>
            <?php endforeach; ?>

          </ul>
        </div>
      </div>
      <div class="col-md-8 products-right">

        <div class="row">
          <?php
          $products = null;
          if (isset($_GET["q"])) {
            $products = $helpers->select_custom_query("SELECT * FROM products p LEFT JOIN categories c ON p.category_id=c.id WHERE p.quantity <> '0' AND c.slug LIKE '%$_GET[q]%'");
          } else if (isset($_GET["s"])) {
            $search = urldecode($_GET['s']);
            $products = $helpers->select_all_with_params("products", "name LIKE '%$search%'");
          } else {
            $products = $helpers->select_all_with_params("products", "quantity <> '0'");
          }
          if (count($products) > 0) :
            foreach ($products as $product) :
              $category = $helpers->select_all_individual("categories", "id='$product->category_id'");
          ?>
              <div class="col-md-4" style="margin-top:0;margin-bottom: 40px">
                <div class="hover14 column">
                  <div class="agile_top_brand_left_grid1">
                    <div class="snipcart-item block">
                      <div class="snipcart-thumb">
                        <a href="<?= SERVER_NAME . "/item?id=$product->id" ?>">
                          <img src="<?= $product->product_img ?>" style="width: 150px; height: 150px" />
                        </a>
                        <p><?= $product->name ?></p>

                        <h4>₱<?= number_format($product->selling_price, 2) ?></h4>
                      </div>
                      <div class="snipcart-details top_brand_home_details">
                        <fieldset>
                          <input type="button" name="submit" value="Add to cart" class="button" onclick="addToCart(`<?= $product->id ?>`, `<?= $product->quantity ?>`,`<?= $category->slug ?>`)" />
                        </fieldset>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
          <div class="clearfix"></div>
        </div>
        <!-- 
        <nav class="numbering">
          <ul class="pagination paging">
            <li>
              <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <li class="active">
              <a href="#">1<span class="sr-only">(current)</span></a>
            </li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li>
              <a href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li>
          </ul>
        </nav> -->
      </div>
      <div class="clearfix"></div>
    </div>
  </div>

  <!-- Bootstrap Core JavaScript -->
  <?php include("./components/scripts.php") ?>

  <script>

  </script>
</body>

</html>