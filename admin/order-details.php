<?php include("../backend/nodes.php") ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php include("./components/head.php"); ?>

</head>

<body class="app">
  <?php include("./components/sidebar.php") ?>

  <div class="app-wrapper">

    <div class="app-content pt-3 p-md-3 p-lg-4">
      <div class="container-xl">

        <div class="row g-3 mb-4 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="app-page-title mb-0"><?= urldecode($_GET['page']) ?></h1>
          </div>
          <div class="col-auto">
            <div class="page-utilities">
              <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                <div class="col-auto">
                  <button type="button" class="btn btn-secondary" onclick="window.history.back()">Back</button>
                </div><!--//col-->
              </div><!--//row-->
            </div><!--//table-utilities-->
          </div>
        </div><!--//row-->

        <div class="app-card app-card-order_details-table mb-5">
          <?php $orderData = $helpers->select_all_individual("orders", "id='$_GET[id]'"); ?>
          <div class="app-card-header p-3">
            Order #: <?= $orderData->order_number ?>
          </div>
          <div class="app-card-body">
            <div class="table-responsive p-2">

              <table class="table mb-0 text-left">
                <thead>
                  <tr>
                    <th class="text-start">Image</th>
                    <th class="text-start">Customer</th>
                    <th class="text-start">Product name</th>
                    <th class="text-start">Quantity</th>
                    <th class="text-start">Price</th>
                    <th class="text-start">Date Ordered</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $total = 0;
                  $order_details = $helpers->select_all_with_params("order_details", "order_id='$_GET[id]'");

                  foreach ($order_details as $order_detail) :
                    $product = $helpers->select_all_individual("products", "id='$order_detail->product_id'");
                    $category = $helpers->select_all_individual("categories", "id='$product->category_id'");
                    $total += $order_detail->quantity * $product->selling_price;
                  ?>
                    <tr>
                      <td style="vertical-align: middle" class="cell text-start">
                        <a href="<?= $product->product_img ?>" target="_blank">
                          <img src="<?= $product->product_img ?>" alt=" " style="width:150px" class="img-responsive" />
                        </a>
                      </td>
                      <td style="vertical-align: middle" class="cell text-start">
                        <?= $helpers->get_full_name($orderData->user_id) ?>
                      </td>
                      <td style="vertical-align: middle" class="cell text-start">
                        <?= $product->name ?>
                        <?php if ($order_detail->custom_img) : ?>
                          with
                          <br>
                          <a href="<?= $order_detail->custom_img ?>" target="_blank">Custom Design</a>
                        <?php endif ?>
                      </td>
                      <td style="vertical-align: middle" class="cell text-start">
                        <?= $order_detail->quantity ?>
                      </td>
                      <td style="vertical-align: middle" class="cell text-start">
                        ₱ <?= number_format(($order_detail->quantity * $product->selling_price), 2) ?>
                      </td>
                      <td style="vertical-align: middle" class="cell text-start">
                        <?= date("Y-m-d", strtotime($orderData->date_created)) ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div><!--//table-responsive-->
          </div><!--//app-card-body-->
          <div class="app-card-footer p-4 mt-auto">
            <div class="row">
              <div class="col-md-6  text-start">
                <strong>Total: ₱ <?= number_format($total, 2) ?></strong>
              </div>
              <div class="col-md-6 text-end">
                <?php $pageTitle = urldecode($_GET['page']); ?>
                <?php if ($pageTitle == "Order Details") : ?>
                  <button class="btn btn-primary" onclick="handleOrderUpdate(`<?= $_GET['id'] ?>`, 'preparing')">Set Preparing</button>
                <?php elseif ($pageTitle == "Preparing Order Details") : ?>
                  <button class="btn btn-warning" onclick="handleOrderUpdate(`<?= $_GET['id'] ?>`, 'to_pickup')">Set To Pickup</button>
                <?php elseif ($pageTitle == "To Pick-up Order Details") : ?>
                  <button class="btn btn-success me-2" onclick="handleOrderUpdate(`<?= $_GET['id'] ?>`, 'paid')">Set Paid</button>
                  <button class="btn btn-danger me-2" onclick="handleOrderUpdate(`<?= $_GET['id'] ?>`, 'not_claimed')">Set Not Claimed</button>
                <?php endif; ?>

              </div>
            </div>
          </div>
        </div><!--//app-card-->

      </div><!--//container-fluid-->
    </div><!--//app-content-->


  </div><!--//app-wrapper-->


  <?php include("./components/scripts.php") ?>
  <script>
    function handleOrderUpdate(orderId, action) {
      swal.showLoading()

      let formData = new FormData();
      formData.append("order_id", orderId);
      formData.append("action", action);

      $.ajax({
        url: "<?= SERVER_NAME . "/backend/nodes?action=order_update" ?>",
        type: "POST",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
          const resp = $.parseJSON(data)

          swal.fire({
            title: resp.success ? "Success" : "Error",
            html: resp.message,
            icon: resp.success ? "success" : "error"
          }).then(() => resp.success ? window.history.back() : undefined)

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