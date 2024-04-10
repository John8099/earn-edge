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
            <h1 class="app-page-title mb-0">Edit Category</h1>
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
                $category = $helpers->select_all_individual("categories", "id='$_GET[id]'");
                ?>
                <form method="POST" id="form-edit-category" class="p-3">

                  <input type="text" name="id" value="<?= $category->id ?>" hidden readonly>
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input type="name" class="form-control" id="name" name="category_name" value="<?= $category->formatted_name ?>">
                  </div>

                  <div class="form-group mt-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
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
    $("#form-edit-category").on("submit", function(e) {
      e.preventDefault()
      swal.showLoading()
      $.ajax({
        url: "<?= SERVER_NAME . "/backend/nodes?action=edit_category" ?>",
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
          }).then(() => resp.success ? window.location.href = '<?= SERVER_NAME . "/admin/categories" ?>' : undefined)

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