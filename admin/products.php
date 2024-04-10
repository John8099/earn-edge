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
            <h1 class="app-page-title mb-0">Products</h1>
          </div>
          <div class="col-auto">
            <div class="page-utilities">
              <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                <div class="col-auto">
                  <a href="<?= SERVER_NAME . "/admin/add-product" ?>" class="btn btn-primary">Add Product</a>
                </div><!--//col-->
              </div><!--//row-->
            </div><!--//table-utilities-->
          </div>

        </div><!--//row-->

        <div class="card">
          <div class="card-body">
            <table class="table app-table-hover mb-0 text-left" id="productTable">
              <thead>
                <tr>
                  <th class="text-start">Image</th>
                  <th class="text-start">Name</th>
                  <th class="text-start">Category</th>
                  <th class="text-start">Quantity</th>
                  <th class="text-start">Price</th>
                  <th class="text-start">Date Created</th>
                  <th class="text-start">Date Modified</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $products = $helpers->select_all("products");
                foreach ($products as $product) :
                  $category = $helpers->select_custom_fields_individual("categories", array("formatted_name"), "id='$product->category_id'");
                ?>
                  <tr>
                    <td class="cell td-image">
                      <a href="javascript:void(0)" class="thumbnail">
                        <img src="<?= $product->product_img ?>" alt="image" class="avatar" style="width: 100px; height: 100px;">
                      </a>
                    </td>
                    <td style="vertical-align: middle" class="cell text-start"><?= $product->name ?></td>
                    <td style="vertical-align: middle" class="cell text-start"><?= $category->formatted_name ?></td>
                    <td style="vertical-align: middle" class="cell text-start"><?= $product->quantity ?></td>
                    <td style="vertical-align: middle" class="cell text-start"><?= $product->selling_price ?></td>
                    <td style="vertical-align: middle" class="cell text-start"><?= date("Y-m-d", strtotime($product->date_created)) ?></td>
                    <td style="vertical-align: middle" class="cell text-start"><?= date("Y-m-d", strtotime($product->date_modified)) ?></td>
                    <td style="vertical-align: middle" style="vertical-align: middle" class="cell text-start">
                      <a href="<?= SERVER_NAME . "/admin/edit-product?id=$product->id" ?>" class="btn btn-warning btn-sm m-2 py-1" title="Edit">
                        <i class="fa-regular fa-pen-to-square"></i>
                      </a>
                      <?php if ($product->quantity == 0) : ?>
                        <button type="button" class="btn btn-danger btn-sm m-2 py-1" title="Delete" id="btnDelete_<?= $product->id ?>" onclick="handleBtnDelete(`<?= $product->id ?>`)">
                          <i class="fa-solid fa-trash"></i>
                        </button>
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
    function handleBtnDelete(id) {
      const postData = {
        table: "products",
        column: "id",
        val: id
      }

      handleDelete("<?= SERVER_NAME . "/backend/nodes?action=delete_data" ?>", undefined, postData);
    }
    const productTableCols = [1, 2, 3, 4, 5, 6];
    const productTable = $("#productTable").DataTable({
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
            columns: productTableCols
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
          columns: productTableCols
        },
        {
          extend: 'searchBuilder',
          config: {
            columns: productTableCols
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