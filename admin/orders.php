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
            <h1 class="app-page-title mb-0">Orders</h1>
          </div>


        </div><!--//row-->


        <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
          <a class="flex-sm-fill text-sm-center nav-link active" id="orders-all-tab" data-bs-toggle="tab" href="#orders-all" role="tab" aria-controls="orders-all" aria-selected="true">
            Pending
          </a>
          <a class="flex-sm-fill text-sm-center nav-link" id="orders-paid-tab" data-bs-toggle="tab" href="#orders-paid" role="tab" aria-controls="orders-paid" aria-selected="false">
            Preparing
          </a>

        </nav>

        <div class="tab-content" id="orders-table-tab-content">
          <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
            <div class="card">
              <div class="card-body">
                <table class="table app-table-hover mb-0 text-left" id="pendingOrdersTable">
                  <thead>
                    <tr>
                      <th class="text-start">Order Number</th>
                      <th class="text-start">Customer</th>
                      <th class="text-start">Items</th>
                      <th class="text-start">Total</th>
                      <th class="text-start">Date</th>
                      <th class="text-start">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $orders = $helpers->select_all_with_params("orders", "status='pending'");
                    foreach ($orders as $order) :
                      if (strtotime($order->date_created) < strtotime(date("Y-m-d H:i:s")) && $order->paypal_paid == "0") {
                        $conn->query("UPDATE orders SET `status`='expired' WHERE id='$order->id'");
                        continue;
                      }
                      $total = 0.00;
                      $items = 0;

                      $order_details = $helpers->select_all_with_params("order_details", "order_id='$order->id'");
                      if (count($order_details) > 0) {
                        foreach ($order_details as $order_detail) {
                          $product = $helpers->select_all_individual("products", "id='$order_detail->product_id'");
                          $total += $order_detail->quantity * $product->selling_price;
                          $items += $order_detail->quantity;
                        }
                      }
                    ?>
                      <tr>
                        <td style="vertical-align: middle" class="cell text-start"><?= $order->order_number ?></td>
                        <td style="vertical-align: middle" class="cell text-start"><?= $helpers->get_full_name($order->user_id) ?></td>
                        <td style="vertical-align: middle" class="cell text-start">
                          <?= $items ?>
                        </td>
                        <td style="vertical-align: middle" class="cell text-start">
                          ₱ <?= number_format($total, 2) ?>
                        </td>
                        <td style="vertical-align: middle" class="cell text-start">
                          <?= date("Y-m-d", strtotime($order->date_modified)) ?>
                        </td>
                        <td style="vertical-align: middle" class="cell text-start">
                          <a class="btn-sm btn btn-primary" href="<?= SERVER_NAME . "/admin/order-details?id=$order->id&&page=" . urlencode("Order Details") ?>">View</a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>

          </div><!--//tab-pane-->

          <div class="tab-pane fade" id="orders-paid" role="tabpanel" aria-labelledby="orders-paid-tab">
            <div class="card">
              <div class="card-body">
                <table class="table app-table-hover mb-0 text-left" id="preparingOrderTable">
                  <thead>
                    <tr>
                      <th class="text-start">Order Number</th>
                      <th class="text-start">Customer</th>
                      <th class="text-start">Items</th>
                      <th class="text-start">Total</th>
                      <th class="text-start">Date</th>
                      <th class="text-start">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $orders = $helpers->select_all_with_params("orders", "status='preparing'");
                    foreach ($orders as $order) :
                      $total = 0.00;
                      $items = 0;

                      $order_details = $helpers->select_all_with_params("order_details", "order_id='$order->id'");
                      if (count($order_details) > 0) {
                        foreach ($order_details as $order_detail) {
                          $product = $helpers->select_all_individual("products", "id='$order_detail->product_id'");
                          $total += $order_detail->quantity * $product->selling_price;
                          $items += $order_detail->quantity;
                        }
                      }
                    ?>
                      <tr>
                        <td style="vertical-align: middle" class="cell text-start"><?= $order->order_number ?></td>
                        <td style="vertical-align: middle" class="cell text-start"><?= $helpers->get_full_name($order->user_id) ?></td>
                        <td style="vertical-align: middle" class="cell text-start">
                          <?= $items ?>
                        </td>
                        <td style="vertical-align: middle" class="cell text-start">
                          ₱ <?= number_format($total, 2) ?>
                        </td>
                        <td style="vertical-align: middle" class="cell text-start">
                          <?= date("Y-m-d", strtotime($order->date_modified)) ?>
                        </td>
                        <td style="vertical-align: middle" class="cell text-start"><a class="btn-sm btn btn-primary" href="<?= SERVER_NAME . "/admin/order-details?id=$order->id&&page=" . urlencode("Preparing Order Details") ?>">View</a></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div><!--//tab-pane-->

        </div><!--//tab-content-->



      </div><!--//container-fluid-->
    </div><!--//app-content-->


  </div><!--//app-wrapper-->


  <?php include("./components/scripts.php") ?>
  <script>
    const pendingOrdersTableCols = [0, 1, 2, 3, 4];
    const pendingOrdersTable = $("#pendingOrdersTable").DataTable({
      paging: true,
      lengthChange: true,
      ordering: false,
      info: true,
      autoWidth: false,
      responsive: true,
      language: {
        searchBuilder: {
          button: 'Filter',
        }
      },
      buttons: [{
          extend: 'print',
          title: '',
          exportOptions: {
            columns: pendingOrdersTableCols
          },
          customize: function(win) {
            $(win.document.body)
              .css('font-size', '10pt')

            $(win.document.body)
              .find('table')
              .addClass('compact')
              .css('font-size', 'inherit');
          }
        },
        {
          extend: 'colvis',
          text: "Columns",
          columns: pendingOrdersTableCols
        },
        {
          extend: 'searchBuilder',
          config: {
            columns: pendingOrdersTableCols
          }
        }
      ],
      dom: `
      <'row'
      <'col-md-4 d-flex my-2 justify-content-start'B>
      <'col-md-4 d-flex my-2 justify-content-center'l>
      <'col-md-4 d-flex my-2 justify-content-md-end justify-content-sm-center'f>
      >
      <'row'<'col-12'tr>>
      <'row'
      <'col-md-6 col-sm-12'i>
      <'col-md-6 col-sm-12 d-flex justify-content-end'p>
      >
      `,
    });

    const preparingOrderTableCols = [0, 1, 2, 3, 4];
    const preparingOrderTable = $("#preparingOrderTable").DataTable({
      paging: true,
      lengthChange: true,
      ordering: false,
      info: true,
      autoWidth: false,
      responsive: true,
      language: {
        searchBuilder: {
          button: 'Filter',
        }
      },
      buttons: [{
          extend: 'print',
          title: '',
          exportOptions: {
            columns: preparingOrderTableCols
          },
          customize: function(win) {
            $(win.document.body)
              .css('font-size', '10pt')

            $(win.document.body)
              .find('table')
              .addClass('compact')
              .css('font-size', 'inherit');
          }
        },
        {
          extend: 'colvis',
          text: "Columns",
          columns: preparingOrderTableCols
        },
        {
          extend: 'searchBuilder',
          config: {
            columns: preparingOrderTableCols
          }
        }
      ],
      dom: `
      <'row'
      <'col-md-4 d-flex my-2 justify-content-start'B>
      <'col-md-4 d-flex my-2 justify-content-center'l>
      <'col-md-4 d-flex my-2 justify-content-md-end justify-content-sm-center'f>
      >
      <'row'<'col-12'tr>>
      <'row'
      <'col-md-6 col-sm-12'i>
      <'col-md-6 col-sm-12 d-flex justify-content-end'p>
      >
      `,
    });
  </script>
</body>

</html>