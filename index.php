<?php include("./backend/nodes.php") ?>
<!DOCTYPE html>
<html>

<head>
  <?php include("./components/head.php"); ?>
</head>

<body>
  <?php include("./components/navbar.php"); ?>

  <!-- main-slider -->
  <ul id="demo1">
    <li>
      <img src="<?= SERVER_NAME . "/assets/images/11.jpg" ?>" alt="" />
      <!--Slider Description example-->
      <div class="slide-desc">
        <h3>Buy Rice Products Are Now On Line With Us</h3>
      </div>
    </li>
    <li>
      <img src="<?= SERVER_NAME . "/assets/images/22.jpg" ?>" alt="" />
      <div class="slide-desc">
        <h3>Whole Spices Products Are Now On Line With Us</h3>
      </div>
    </li>

    <li>
      <img src="<?= SERVER_NAME . "/assets/images/44.jpg" ?>" alt="" />
      <div class="slide-desc">
        <h3>Whole Spices Products Are Now On Line With Us</h3>
      </div>
    </li>
  </ul>
  <!-- //main-slider -->

  <!--brands-->
  <div class="brands">
    <div class="container">
      <h3>Categories</h3>
      <div class="brands-agile">
        <?php
        $categories = $helpers->select_all_with_params("categories", "id IS NOT NULL LIMIT 4");
        foreach ($categories as $category) :
        ?>
          <div class="col-md-3 w3layouts-brand">
            <div class="brands-w3l">
              <p><a href="<?= SERVER_NAME . "/shop?q=$category->slug" ?>"><?= $category->formatted_name ?></a></p>
            </div>
          </div>
        <?php endforeach; ?>

        <div class="clearfix"></div>
      </div>

    </div>
  </div>
  <!--//brands-->

  <!-- new -->
  <div class="newproducts-w3agile">
    <div class="container">
      <h3>New stocks</h3>
      <div class="row" style="margin-top: 40px;">
        <?php
        $products = $helpers->select_all_with_params("products", "quantity <> '0' ORDER BY id DESC LIMIT 4");
        if (count($products) > 0) :
          foreach ($products as $product) :
        ?>
            <div class="col-md-3" style="margin-top:0;margin-bottom: 40px">
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
                        <input type="button" name="submit" value="Add to cart" class="button" />
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
    </div>
  </div>
  <!-- //new -->

  <!-- Bootstrap Core JavaScript -->
  <?php include("./components/scripts.php") ?>
  <!-- top-header and slider -->
  <!-- here stars scrolling icon -->
  <script>
    $(document).ready(function() {
      $().UItoTop({
        easingType: 'easeOutQuart'
      });

    });
  </script>

  <script>
    jQuery(document).ready(function() {
      jQuery('#demo1').skdslider({
        'delay': 5000,
        'animationSpeed': 2000,
        'showNextPrev': true,
        'showPlayButton': true,
        'autoSlide': true,
        'animationType': 'fading'
      });

      jQuery('#responsive').change(function() {
        $('#responsive_wrapper').width(jQuery(this).val());
      });

    });
  </script>
  <!-- //main slider-banner -->
</body>

</html>