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
            <h1 class="app-page-title mb-0">Users</h1>
          </div>

        </div><!--//row-->

        <div class="card">
          <div class="card-body">
            <table class="table app-table-hover mb-0 text-left" id="userTable">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Role</th>
                  <th class="text-start">Date Created</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $users = $helpers->select_all("users");
                foreach ($users as $user) :
                ?>
                  <tr>
                    <td style="vertical-align: middle" class="cell text-start"><?= $helpers->get_full_name($user->id) ?></td>
                    <td style="vertical-align: middle" class="cell text-start"><?= $user->email ?></td>
                    <td style="vertical-align: middle" class="cell text-start"><?= $user->role ?></td>
                    <td class="cell text-start"><?= date("Y-m-d", strtotime($user->created_at)) ?></td>
                    <td style="vertical-align: middle" class="cell text-start">
                      <?php if ($user->id != $LOGIN_USER->id) : ?>
                        <a class="btn btn-primary btn-sm" href="<?= SERVER_NAME . "/admin/profile?id=$user->id" ?>">
                          View
                        </a>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

      </div><!--//container-fluid-->
    </div><!--//app-content-->


  </div><!--//app-wrapper-->


  <?php include("./components/scripts.php") ?>
  <script>
    const userTableCols = [0, 1, 2, 3];
    const userTable = $("#userTable").DataTable({
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
            columns: userTableCols
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
          columns: userTableCols
        },
        {
          extend: 'searchBuilder',
          config: {
            columns: userTableCols
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