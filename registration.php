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
      <h2>Register Here</h2>
      <div class="login-form-grids">
        <h5>profile information</h5>
        <form id="form-register" method="post">

          <input type="text" placeholder="First Name..." name="fname" required=" ">
          <input type="text" placeholder="Middle Name..." name="mname">
          <input type="text" placeholder="Last Name..." name="lname" required=" ">

          <h6>Login information</h6>
          <input type="email" placeholder="Email Address" name="email" required=" ">
          <input type="password" placeholder="Password" name="password" required=" ">

          <input type="submit" value="Register">
        </form>
      </div>
      <div class="register-home">
        <a href="<?= SERVER_NAME . "/" ?>">Home</a>
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
        url: "<?= SERVER_NAME . "/backend/nodes?action=registration" ?>",
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
          }).then(() => resp.success ? window.location.href = '<?= SERVER_NAME . "/login" ?>' : undefined)

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