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
      $carts = $helpers->select_all_with_params("cart", "user_id = $_SESSION[id]");
      if (count($carts) > 0) :
      ?>
        <h2>Your shopping cart contains: <span><?= count($carts) ?> Product(s)</span></h2>
        <div class="checkout-right">
          <table class="timetable_sub">
            <thead>
              <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Remove</th>
              </tr>
            </thead>
            <?php
            foreach ($carts as $cart) :
              $product = $helpers->select_all_individual("products", "id='$cart->product_id'");
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
                      <!-- <div class="entry value-minus" onclick="handleMinus(`<?= $cart->id ?>`)">&nbsp;</div> -->
                      <div class="entry value"><span><?= $cart->quantity ?></span></div>
                      <!-- <div class="entry value-plus" onclick="handleAdd(`<?= $cart->id ?>`)">&nbsp;</div> -->
                    </div>
                  </div>
                </td>
                <td class="invert">
                  <?= $product->name ?>
                  <?php if ($cart->custom_img) : ?>
                    with
                    <br>
                    <a href="<?= $cart->custom_img ?>" target="_blank">Custom Design</a>
                  <?php endif ?>
                </td>

                <td class="invert">₱<?= number_format($product->selling_price, 2) ?></td>
                <td class="invert">
                  <div class="rem">
                    <div class="close1" onclick="handleRemove(`<?= $cart->id ?>`)"> </div>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </table>
        </div>
        <div class="checkout-left">
          <div class="checkout-left-basket">
            <h4>Checkout Items</h4>
            <ul>
              <?php
              $total = 0;
              foreach ($carts as $cart) :
                $product = $helpers->select_all_individual("products", "id='$cart->product_id'");
                $total += intval($product->selling_price) * intval($cart->quantity);
              ?>
                <li>
                  <?= $product->name ?> <i>x</i> <?= $cart->quantity ?>
                  <span>₱<?= number_format(intval($product->selling_price) * intval($cart->quantity), 2) ?></span>
                </li>
              <?php endforeach; ?>

              <li>Total <span>₱<?= number_format($total, 2) ?></span></li>
              <li style="text-align: right; margin-top:20px">
                <button type="button" class="btn btn-primary btn-block" onclick="handlePlaceOrder()">
                  Place Order
                </button>
              </li>
              <li>
                <div id="paypal-button-container"></div>
              </li>
            </ul>
          </div>
          <div class="checkout-right-basket">
            <a href="<?= SERVER_NAME . "/shop" ?>"><span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>Continue Shopping</a>
          </div>
          <div class="clearfix"> </div>
        </div>
      <?php else : ?>
        <h3>No Items in Cart</h3>
      <?php endif; ?>

    </div>
  </div>

  <script src="https://www.paypal.com/sdk/js?client-id=<?= PAYPAL_SANDBOX_CLIENT_ID ?>&currency=<?= $currency; ?>"></script>
  <!-- Bootstrap Core JavaScript -->
  <?php include("./components/scripts.php") ?>
  <script>
    paypal.Buttons({
      // Sets up the transaction when a payment button is clicked
      createOrder: (data, actions) => {
        return actions.order.create({
          "purchase_units": [
            <?php
            foreach ($carts as $cart) :
              $product = $helpers->select_all_individual("products", "id='$cart->product_id'");
              $category = $helpers->select_all_individual("categories", "id='$product->category_id'");
            ?> {
                "custom_id": "PRD<?= $cart->id ?>",
                "amount": {
                  "currency_code": "PHP",
                  "value": <?= intval($product->selling_price) ?>,
                  "breakdown": {
                    "item_total": {
                      "currency_code": "PHP",
                      "value": <?= intval($product->selling_price) ?>
                    }
                  }
                }
              },
            <?php endforeach; ?>
          ]
        });
      },
      // Finalize the transaction after payer approval
      onApprove: (data, actions) => {
        return actions.order.capture().then(function(orderData) {
          setProcessing(true);

          var postData = {
            paypal_order_check: 1,
            order_id: orderData.id
          };
          fetch(`<?= SERVER_NAME . "/backend/checkout" ?>`, {
              method: 'POST',
              headers: {
                'Accept': 'application/json'
              },
              body: encodeFormData(postData)
            })
            .then((response) => response.json())
            .then((result) => {
              if (result.status == 1) {
                handlePlaceOrder("yes")
              } else {
                swal.fire({
                  title: 'Error',
                  text: result.msg,
                  icon: 'error',
                })
              }
            })
            .catch(error => console.log(error));
        });
      }
    }).render('#paypal-button-container');

    const encodeFormData = (data) => {
      var form_data = new FormData();

      for (var key in data) {
        form_data.append(key, data[key]);
      }
      return form_data;
    }

    // Show a loader on payment form processing
    const setProcessing = (isProcessing) => {
      if (isProcessing) {
        swal.showLoading();
      }
    }

    function handlePlaceOrder(isPayPalPaid = null) {
      $.post("<?= SERVER_NAME . "/backend/nodes?action=place_order" ?>", {
        isPayPalPaid: isPayPalPaid ? isPayPalPaid : "no",
      }, (data, status) => {
        const resp = $.parseJSON(data);

        swal.fire({
          title: resp.success ? "Success" : "Error",
          html: resp.message,
          icon: resp.success ? "success" : "error"
        }).then(() => resp.success ? window.location.reload() : undefined)

      }).fail(function(e) {
        swal.fire({
          title: "Error!",
          html: e.statusText,
          icon: "error",
        });
      });
    }

    function handleAdd(cartId) {
      $.ajax({
        url: "<?= SERVER_NAME . "/backend/nodes?action=increase_quantity" ?>",
        type: "POST",
        data: {
          cart_id: cartId
        },
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
          swal.fire({
            title: resp.success ? "Success" : "Error",
            html: resp.message,
            icon: resp.success ? "success" : "error"
          })

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

    function handleMinus(cartId) {
      console.log(cartId)
    }

    function handleRemove(cartId) {
      const postData = {
        table: "cart",
        column: "id",
        val: cartId
      }

      handleDelete("<?= SERVER_NAME . "/backend/nodes?action=delete_data" ?>", undefined, postData);
    }
  </script>
</body>

</html>