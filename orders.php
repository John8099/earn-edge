<?php include("./backend/nodes.php") ?>
<!DOCTYPE html>
<html>

<head>
  <?php include("./components/head.php"); ?>
</head>

<body>
  <?php include("./components/navbar.php"); ?>

  <div class="checkout">
    <div class="container">

      <?php
      $orders = $helpers->select_all_with_params("orders", "user_id = $_SESSION[id] ORDER BY id ASC");
      if (count($orders) > 0) :
        foreach ($orders as $order) :
      ?>
          <div class="panel panel-default">
            <div class="panel-heading">Order #: <?= $order->order_number ?></div>
            <div class="panel-body">
              <div class="checkout-right">
                <table class="timetable_sub">
                  <thead>
                    <tr>
                      <th>Product</th>
                      <th>Quantity</th>
                      <th>Product Name</th>
                      <th>Price</th>
                    </tr>
                  </thead>
                  <?php
                  $order_details = $helpers->select_all_with_params("order_details", "order_id='$order->id'");
                  foreach ($order_details as $order_detail) :
                    $product = $helpers->select_all_individual("products", "id='$order_detail->product_id'");
                    $category = $helpers->select_all_individual("categories", "id='$product->category_id'");
                  ?>
                    <tr class="rem1">
                      <td class="invert-image">
                        <a href="<?= SERVER_NAME . "/item?id=$product->id" ?>">
                          <img src="<?= $product->product_img ?>" alt=" " style="width:150px" class="img-responsive" />
                        </a>
                      </td>
                      <td class="invert">
                        <div class="quantity">
                          <div class="quantity-select">
                            <div class="entry value"><span><?= $order_detail->quantity ?></span></div>
                          </div>
                        </div>
                      </td>
                      <td class="invert">
                        <?= $product->name ?>
                        <?php if ($order_detail->custom_img) : ?>
                          with
                          <br>
                          <a href="<?= $order_detail->custom_img ?>" target="_blank">Custom Design</a>
                        <?php endif ?>
                      </td>
                      <td class="invert">₱<?= number_format($product->selling_price, 2) ?></td>

                    </tr>
                  <?php endforeach; ?>
                </table>
              </div>
            </div>
            <div class="panel-footer row" style="margin: 0;">
              <div class="col-md-6">
                Status: <?= ucwords($order->status) ?>
              </div>
              <div class="col-md-6" style="display: flex; justify-content: flex-end;">
                <?php if ($order->status == "pending") : ?>
                  <button class="btn btn-danger" onclick="handleCancelOrder(`<?= $order->id ?>`)">Cancel</button>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <h3>No Orders yet</h3>
      <?php endif; ?>
    </div>
  </div>

  <!-- Bootstrap Core JavaScript -->
  <?php include("./components/scripts.php") ?>
  <script>
    function handleCancelOrder(orderID) {
      swal.showLoading()
      let formData = new FormData();
      formData.append("order_id", orderID)
      $.ajax({
        url: "<?= SERVER_NAME . "/backend/nodes?action=cancel_order" ?>",
        type: "POST",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
          const resp = $.parseJSON(data);

          swal.fire({
            title: resp.success ? "Success" : "Error",
            html: resp.message,
            icon: resp.success ? "success" : "error"
          }).then(() => resp.success ? window.location.reload() : undefined)

        },
        error: function(data) {
          swal.fire({
            title: 'Oops...',
            text: 'Something went wrong.',
            icon: 'error',
          })
        }
      });
    }
  </script>
</body>

</html>