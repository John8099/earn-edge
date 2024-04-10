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
            <h1 class="app-page-title mb-0">Edit Product</h1>
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

        <div class="row d-flex justify-content-center">
          <div class="col-md-7">
            <div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start">

              <div class="app-card-body px-4 w-100">
                <?php
                $product = $helpers->select_all_individual("products", "id='$_GET[id]'");
                ?>
                <form id="form-edit-product" class="mt-5" enctype="multipart/form-data">
                  <input type="text" name="id" value="<?= $product->id ?>" hidden readonly>
                  
                  <div class="form-group mb-3">
                    <label for="product_image" class="form-label">Product Image</label>
                    <input type="file" class="form-control" name="product_image" id="product_image" accept='image/*'>
                  </div>

                  <div class="form-group mb-3">
                    <label for="product_name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" name="product_name" id="product_name" value="<?= $product->name ?>" required>
                  </div>

                  <div class="form-group mb-3">
                    <label for="category" class="form-label">Product Category</label>
                    <select name="category_id" id="category" class="ms-1 d-block w-100 form-select" required>
                      <option value="">-- select category --</option>
                      <?php
                      $categories = $helpers->select_all("categories");

                      foreach ($categories as $category) :
                      ?>
                        <option value="<?= $category->id ?>" <?= $helpers->is_selected($category->id, $product->id) ?>><?= $category->formatted_name ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label" for="quantity">Stock Quantity</label>
                    <input type="number" class="form-control" name="quantity" id="quantity" value="<?= $product->quantity ?>" required>
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label" for="price">Price</label>
                    <input type="number" class="form-control" name="price" id="price" value="<?= $product->selling_price ?>" required>
                  </div>

                  <div class="form-group mb-3">
                    <label class="form-label" for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" style="height: 100px;"><?= nl2br($product->description) ?></textarea>
                  </div>

                  <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-warning text-white form-control w-50 m-3">Edit Product</button>
                  </div>
                </form>
              </div><!--//app-card-body-->
            </div>
          </div>
        </div>
      </div><!--//container-fluid-->
    </div><!--//app-content-->


  </div><!--//app-wrapper-->


  <?php include("./components/scripts.php") ?>
  <script>
    $("#form-edit-product").on("submit", function(e) {
      e.preventDefault()
      swal.showLoading()
      $.ajax({
        url: "<?= SERVER_NAME . "/backend/nodes?action=edit_product" ?>",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
          const resp = $.parseJSON(data)

          swal.fire({
            title: resp.success ? "Success" : "Error",
            html: resp.message,
            icon: resp.success ? "success" : "error"
          }).then(() => resp.success ? window.location.href = '<?= SERVER_NAME . "/admin/products" ?>' : undefined)

        },
        error: function(data) {
          swal.fire({
            title: 'Oops...',
            text: 'Something went wrong.',
            icon: 'error',
          })
        }
      });
    })
  </script>
</body>

</html>