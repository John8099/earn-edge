<?php include("./backend/nodes.php") ?>
<!DOCTYPE html>
<html>

<head>
  <?php include("./components/head.php"); ?>
</head>

<body>
  <?php include("./components/navbar.php"); ?>

  <div class="login">
    <div class="container">
      <h2>Login Form</h2>

      <div class="login-form-grids animated wow slideInUp" data-wow-delay=".5s">
        <form id="form-login" method="POST">
          <input type="email" placeholder="Email Address" name="email" required=" ">
          <input type="password" placeholder="Password" name="password" required=" ">

          <input type="submit" value="Login">
        </form>
      </div>
      <h4>For New People</h4>
      <p><a href="<?= SERVER_NAME . "/registration" ?>">Register Here</a> (Or) go back to <a href="<?= SERVER_NAME . "/" ?>">Home<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a></p>
    </div>
  </div>

  <!-- Bootstrap Core JavaScript -->
  <?php include("./components/scripts.php") ?>

  <script>
    $("#form-login").on("submit", function(e) {
      e.preventDefault()
      swal.showLoading()
      $.ajax({
        url: "<?= SERVER_NAME . "/backend/nodes?action=login" ?>",
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
          }).then(() => {
            if (resp.success) {
              const role = resp.role;

              if (role == "admin") {
                window.location.href = '<?= SERVER_NAME . "/admin/" ?>'
              } else {
                window.location.href = '<?= SERVER_NAME . "/" ?>'
              }
            }
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
    })
  </script>
</body>

</html>