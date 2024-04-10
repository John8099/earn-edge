<?php include("../backend/nodes.php") ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include("./components/head.php");
  $user = null;
  if (isset($_GET["id"])) {
    $user = $helpers->get_user_by_id($_GET['id']);
  } else if (!isset($_GET["id"]) && $LOGIN_USER) {
    $user = $LOGIN_USER;
  }
  ?>
</head>

<body class="app">
  <?php include("./components/sidebar.php") ?>

  <div class="app-wrapper">

    <div class="app-content pt-3 p-md-3 p-lg-4">
      <div class="container-xl">

        <div class="row g-3 mb-4 align-items-center justify-content-between">
          <div class="col-auto">
            <h1 class="app-page-title mb-0">Profile</h1>
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
                <form id="form-profile" class="mt-5" enctype="multipart/form-data">
                  <input type="text" name="id" value="<?= $user->id ?>" hidden readonly>

                  <div class="form-group mb-3">
                    <label for="fname" class="form-label">First Name</label>
                    <input type="text" class="form-control" name="fname" id="fname" value="<?= $user->fname ?>" required>
                  </div>

                  <div class="form-group mb-3">
                    <label for="mname" class="form-label">MIddle Name</label>
                    <input type="text" class="form-control" name="mname" id="mname" value="<?= $user->mname ?>">
                  </div>

                  <div class="form-group mb-3">
                    <label for="lname" class="form-label">Last Name</label>
                    <input type="text" class="form-control" name="lname" id="lname" value="<?= $user->lname ?>" required>
                  </div>

                  <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" id="email" value="<?= $user->email ?>" required>
                  </div>

                  <?php if (!isset($_GET["id"])) : ?>
                    <div class="d-flex justify-content-center">
                      <button type="submit" class="btn btn-primary text-white form-control w-50 m-3">Update</button>
                    </div>
                  <?php endif; ?>
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
    $("#form-profile").on("submit", function(e) {
      e.preventDefault()
      swal.showLoading()
      $.ajax({
        url: "<?= SERVER_NAME . "/backend/nodes?action=update_profile" ?>",
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
    })
  </script>
</body>

</html>