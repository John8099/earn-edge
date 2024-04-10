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
            <h1 class="app-page-title mb-0">Category List</h1>
          </div>
          <div class="col-auto">
            <div class="page-utilities">
              <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                <div class="col-auto">
                  <a href="<?= SERVER_NAME . "/admin/add-category" ?>" class="btn btn-primary">Add Category</a>
                </div><!--//col-->
              </div><!--//row-->
            </div><!--//table-utilities-->
          </div>

        </div><!--//row-->

        <div class="card">
          <div class="card-body">
            <table class="table app-table-hover mb-0 text-left" id="categoryTable">
              <thead>
                <tr>
                  <th>Name</th>
                  <th class="text-start">Date Created</th>
                  <th class="text-start">Date Modified</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $categories = $helpers->select_all_with_params("categories", "id IS NOT NULL ORDER BY id DESC");
                foreach ($categories as $category) :
                ?>
                  <tr>
                    <td style="vertical-align: middle" class="cell text-start"><?= $category->formatted_name ?></td>
                    <td class="cell text-start"><?= date("Y-m-d", strtotime($category->date_created)) ?></td>
                    <td class="cell text-start"><?= date("Y-m-d", strtotime($category->date_updated)) ?></td>
                    <td style="vertical-align: middle" class="cell text-start">
                      <a href="<?= SERVER_NAME . "/admin/edit-category?id=$category->id" ?>" class="btn btn-warning btn-sm m-2 py-1" title="Edit">
                        <i class="fa-regular fa-pen-to-square"></i>
                      </a>
                      <button type="button" class="btn btn-danger btn-sm m-2 py-1" title="Delete" id="btnDelete_<?= $category->id ?>" onclick="handleBtnDelete(`<?= $category->id ?>`)">
                        <i class="fa-solid fa-trash"></i>
                      </button>
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
    function handleBtnDelete(id) {
      const postData = {
        table: "categories",
        column: "id",
        val: id
      }

      handleDelete("<?= SERVER_NAME . "/backend/nodes?action=delete_data" ?>", undefined, postData);
    }
    const categoryTableCols = [0, 1, 2];
    const categoryTable = $("#categoryTable").DataTable({
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
            columns: categoryTableCols
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
          columns: categoryTableCols
        },
        {
          extend: 'searchBuilder',
          config: {
            columns: categoryTableCols
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