<!-- js -->
<!-- <script src="<?= SERVER_NAME . "/assets/js/jquery-1.11.1.min.js" ?>"></script> -->

<!-- //js -->
<!-- start-smoth-scrolling -->
<script src="<?= SERVER_NAME . "/assets/js/move-top.js" ?>"></script>
<script src="<?= SERVER_NAME . "/assets/js/easing.js" ?>"></script>

<script src="<?= SERVER_NAME . "/assets/js/bootstrap.min.js" ?>"></script>
<script src="<?= SERVER_NAME . "/assets/js/minicart.min.js" ?>"></script>
<script src="<?= SERVER_NAME . "/assets/js/skdslider.min.js" ?>"></script>
<script src="<?= SERVER_NAME . "/custom-assets/js/custom.js" ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  const sessionUser = "<?= isset($_SESSION['id']) ? $_SESSION['id'] : null ?>";

  $("#btnAddToCart").on("click", function(e) {
    console.log(e)
  })

  $("#btnSearch").on("click", function() {
    const search = $("#search").val()

    window.location.href = `<?= SERVER_NAME . "/shop?s=" ?>${encodeURIComponent(search)}`
  })

  function addToCart(productID, quantity, type) {
    console.log(sessionUser)
    if (!sessionUser) {

      swal.fire({
        title: "Warning",
        html: "You need to login before adding to cart",
        icon: "warning",
        confirmButtonText: "Login",
        showCancelButton: true
      }).then((res) => {
        if (res.isConfirmed) {
          window.location.href = "<?= SERVER_NAME . "/login" ?>"
        }
      })

    } else {
      swal.fire({
        input: "text",
        inputLabel: "Quantity",
        showCancelButton: true,
        inputValidator: (value) => {
          if (!value) {
            return "Please enter Quantity";
          } else if (isNaN(Number(value))) {
            return "Not a valid Quantity"
          } else if (Number(value) < 0) {
            return "Please enter valid Quantity"
          } else if (Number(value) > Number(quantity)) {
            return "Request quantity is greater than the items left of the product";
          }
        }
      }).then((res) => {
        if (res.isConfirmed) {
          let formData = new FormData()
          formData.append("product_id", productID);
          formData.append("quantity", res.value)

          if (type === "t-shirt") {
            swal.fire({
              input: "file",
              inputLabel: "Custom design",
              showCancelButton: true,
            }).then((c_res) => {
              if (c_res.isConfirmed) {
                formData.append("file", c_res.value);
              }
              saveToCart(formData)
            })
          } else {
            saveToCart(formData)
          }

        }
      });

    }
  }

  function saveToCart(formData) {
    $.ajax({
      url: "<?= SERVER_NAME . "/backend/nodes?action=add_to_cart" ?>",
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
</script>