<?php include("./backend/nodes.php") ?>
<!DOCTYPE html>
<html>

<head>
  <?php include("./components/head.php"); ?>
</head>

<body>
  <?php include("./components/navbar.php"); ?>
  <div class="register">
    <div class="container">

      <div class="login-form-grids">
        <h5>profile information</h5>
        <form id="form-register" method="POST">
          <input type="hidden" name="id" value="<?= $LOGIN_USER ? $LOGIN_USER->id : "" ?>" hidden readonly>

          <input type="text" placeholder="First Name..." name="fname" value="<?= $LOGIN_USER ? $LOGIN_USER->fname : "" ?>" required=" ">
          <input type="text" placeholder="Middle Name..." name="mname" value="<?= $LOGIN_USER ? $LOGIN_USER->mname : "" ?>">
          
          <input type="text" placeholder="Last Name..." name="lname" value="<?= $LOGIN_USER ? $LOGIN_USER->lname : "" ?>" required=" " style="margin: 1em 0;">

          <h6>Login information</h6>
          <input type="email" placeholder="Email Address" name="email" value="<?= $LOGIN_USER ? $LOGIN_USER->email : "" ?>" required=" ">

          <input type="submit" value="Update">
        </form>
      </div>

    </div>
  </div>

  <!-- Bootstrap Core JavaScript -->
  <?php include("./components/scripts.php") ?>
  <script>
    $("#form-register").on("submit", function(e) {
      e.preventDefault()
      swal.showLoading()
      $.ajax({
        url: "<?= SERVER_NAME . "/backend/nodes?action=update_user_profile" ?>",
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