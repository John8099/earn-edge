<?php
session_start();
// Product Details 
$itemNumber = "DP12345";
$itemName = "Demo Product";
$itemPrice = 75;
$currency = "PHP";

include_once(__DIR__ . "/config.php");

include(__DIR__ . "/conn.php");
include(__DIR__ . "/helpers.php");

try {

  $connection = new Connect();
  $conn = $connection->conn;

  $helpers = new Helpers($conn, $_SESSION);

  if (isset($_GET["action"])) {

    switch ($_GET["action"]) {
      case "logout":
        logout();
        break;
      case "registration":
        registration();
        break;
      case "login":
        login();
        break;
      case "add_category":
        add_category();
        break;
      case "edit_category":
        edit_category();
        break;
      case "delete_data":
        delete_data();
        break;
      case "add_product":
        add_product();
        break;
      case "edit_product":
        edit_product();
        break;
      case "add_to_cart":
        add_to_cart();
        break;
      case "place_order":
        place_order();
        break;
      case "cancel_order":
        cancel_order();
        break;
      case "update_user_profile":
        update_user_profile();
        break;
      case "order_update":
        order_update();
        break;
      case "update_profile":
        update_profile();
        break;
      case "get_week_sales":
        get_week_sales();
        break;
      case "get_week_orders":
        get_week_orders();
        break;
      default:
        $response["success"] = false;
        $response["message"] = "Case action not found!";

        null;
        $helpers->return_response($response);
    }
  }
} catch (Exception $e) {
  echo "<script>console.log(`" . ($e->getMessage()) . "`)</script>";
}

function get_week_orders()
{
  global $helpers, $_POST;

  $month = $_POST["month"];
  $ranges = get_weeks($month, 2024);
  $orders = array();

  foreach ($ranges as $range) {
    $explodedRange = explode(" - ", $range);

    $start = date("Y-m-d", strtotime($explodedRange[0]));
    $end = date("Y-m-d", strtotime($explodedRange[1]));

    $ordersQ = $helpers->select_all_with_params("orders", "status='paid' AND DATE_FORMAT(date_modified, '%Y-%m-%d') BETWEEN '$start' AND '$end'");;

    array_push($orders, count($ordersQ));
  }

  $response["orders"] = $orders;
  $helpers->return_response($response);
}

function get_week_sales()
{
  global $helpers, $_POST;

  $month = $_POST["month"];
  $ranges = get_weeks($month, 2024);
  $totals = array();

  foreach ($ranges as $range) {
    $total = 0.00;

    $explodedRange = explode(" - ", $range);

    $start = date("Y-m-d", strtotime($explodedRange[0]));
    $end = date("Y-m-d", strtotime($explodedRange[1]));

    $orders = $helpers->select_all_with_params("orders", "status='paid' AND DATE_FORMAT(date_modified, '%Y-%m-%d') BETWEEN '$start' AND '$end'");

    if (count($orders) > 0) {
      foreach ($orders as $order) {
        $order_details = $helpers->select_all_with_params("order_details", "order_id='$order->id'");

        if (count($order_details) > 0) {
          foreach ($order_details as $order_detail) {
            $product = $helpers->select_all_individual("products", "id='$order_detail->product_id'");

            $total += $product->selling_price;
          }
        }
      }
    }

    array_push($totals, $total);
  }


  $response["totals"] = $totals;
  $helpers->return_response($response);
}

function get_weeks($month, $year)
{
  $weeks = [];
  $ym = $year . '-' . $month;
  $final = date('t', strtotime($ym));
  $firstSat = date('d', strtotime("first Saturday of $ym"));
  $d = 1;

  do {
    $weekEnd = $d === 1 ? $firstSat : min($final, $d + 6);
    $weeks[] = sprintf(
      "%s-%02d - %s-%02d",
      $ym,
      $d,
      $ym,
      $weekEnd
    );
    $d = $weekEnd + 1;
  } while ($weekEnd < $final);

  return $weeks;
}

function getBarChartData($start)
{
  global $helpers;

  $orders = $helpers->select_all_with_params("orders", "status='paid' AND DATE_FORMAT(date_modified, '%Y-%m-%d') BETWEEN '$start' AND LAST_DAY('$start')");

  return count($orders);
}

function getLineChartData($start)
{
  global $helpers;

  $total = 0.00;

  $orders = $helpers->select_all_with_params("orders", "status='paid' AND DATE_FORMAT(date_modified, '%Y-%m-%d') BETWEEN '$start' AND LAST_DAY('$start')");
  if (count($orders) > 0) {
    foreach ($orders as $order) {
      $order_details = $helpers->select_all_with_params("order_details", "order_id='$order->id'");

      if (count($order_details) > 0) {
        foreach ($order_details as $order_detail) {
          $product = $helpers->select_all_individual("products", "id='$order_detail->product_id'");

          $total += $product->selling_price;
        }
      }
    }
  }

  return $total;
}

function getCountPreparingOrder()
{
  global $helpers;

  $orders = $helpers->select_all_with_params("orders", "status='preparing'");

  return count($orders);
}

function getCountPendingOrder()
{
  global $helpers;

  $orders = $helpers->select_all_with_params("orders", "status='pending'");

  return count($orders);
}

function getTodayTotalSales()
{
  global $helpers;

  $total = 0.00;

  $orders = $helpers->select_all_with_params("orders", "status='paid' AND DATE_FORMAT(date_modified, '%Y-%m-%d')=DATE_FORMAT(CURRENT_DATE(), '%Y-%m-%d')");
  if (count($orders) > 0) {
    foreach ($orders as $order) {
      $order_details = $helpers->select_all_with_params("order_details", "order_id='$order->id'");

      if (count($order_details) > 0) {
        foreach ($order_details as $order_detail) {
          $product = $helpers->select_all_individual("products", "id='$order_detail->product_id'");

          $total += $product->selling_price;
        }
      }
    }
  }

  return $total;
}

function getTotalSales()
{
  global $helpers;

  $total = 0.00;

  $orders = $helpers->select_all_with_params("orders", "status='paid'");
  if (count($orders) > 0) {
    foreach ($orders as $order) {
      $order_details = $helpers->select_all_with_params("order_details", "order_id='$order->id'");

      if (count($order_details) > 0) {
        foreach ($order_details as $order_detail) {
          $product = $helpers->select_all_individual("products", "id='$order_detail->product_id'");

          $total += $product->selling_price;
        }
      }
    }
  }

  return $total;
}

function update_profile()
{
  global $helpers, $_POST, $conn;

  $id = $_POST['id'];
  $fname = $_POST["fname"];
  $mname = $_POST["mname"];
  $lname = $_POST["lname"];
  $email = $_POST["email"];

  $updateData = array(
    "fname" => ucwords($fname),
    "mname" => ucwords($mname),
    "lname" => ucwords($lname),
    "email" => $email,
  );

  $update = $helpers->update("users", $updateData, "id", $id);

  if ($update) {
    $response["success"] = true;
    $response["message"] = "Profile successfully updated";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function order_update()
{
  global $helpers, $_POST, $conn;

  $order_id = $_POST["order_id"];
  $action = $_POST["action"];

  if ($action == "not_claimed") {
    $orderDetailsData = $helpers->select_all_with_params("order_details", "order_id='$order_id'");

    if (count($orderDetailsData) > 0) {
      foreach ($orderDetailsData as $order_detail) {
        $product = $helpers->select_all_individual("products", "id='$order_detail->product_id'");

        $product_qty = $product->quantity;
        $order_detail_qty = $order_detail->quantity;

        $new_qty = $product_qty + $order_detail_qty;

        $helpers->update("products", array("quantity" => $new_qty), "id", $product->id);
      }
    }
  }

  $orderData = array("status" => $action);
  $update = $helpers->update("orders", $orderData, "id", $order_id);

  if ($update) {
    $response["success"] = true;
    $response["message"] = "Order successfully updated";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function update_user_profile()
{
  global $helpers, $_POST, $conn;

  $id = $_POST["id"];
  $fname = ucwords($_POST["fname"]);
  $mname = ucwords($_POST["mname"]);
  $lname = ucwords($_POST["lname"]);
  $email = $_POST["email"];

  $updateData = array(
    "fname" => $fname,
    "mname" => $mname,
    "lname" => $lname,
    "email" => $email
  );

  $updateUser = $helpers->update("users", $updateData, "id", $id);

  if ($updateUser) {
    $response["success"] = true;
    $response["message"] = "Profile successfully updated";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function cancel_order()
{
  global $helpers, $_POST, $conn;

  $order_id = $_POST['order_id'];

  $updateOrder = $helpers->update("orders", array("status" => "canceled"), "id", $order_id);

  if ($updateOrder) {
    $response["success"] = true;
    $response["message"] = "Order successfully canceled";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function place_order()
{
  global $helpers, $conn, $_SESSION, $_POST;

  $orderData = array(
     "order_number" => date("YmdHis"),
    "user_id" => $_SESSION["id"],
    "status" => "pending",
    "paypal_paid" => $_POST["isPayPalPaid"] == "yes" ? "1" : "set_zero"
  );

  $order_id = $helpers->insert("orders", $orderData);
  if ($order_id) {
    $cartData = $helpers->select_all("cart", "user_id='$_SESSION[id]'");

    foreach ($cartData as $cart) {
      $orderDetailsData = array(
        "order_id" => $order_id,
        "product_id" => $cart->product_id,
        "quantity" => $cart->quantity,
        "custom_img" => $cart->custom_img
      );

      $product = $helpers->select_all_individual("products", "id='$cart->product_id'");
      $newQuantity = $product->quantity - $cart->quantity;
      $helpers->update("products", array("quantity" => $newQuantity == 0 ? "set_zero" : $newQuantity), "id", $product->id);

      $helpers->insert("order_details", $orderDetailsData);
      $helpers->delete("cart", "id", $cart->id);
    }

    $response["success"] = true;
    $response["message"] = "Order successfully placed";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function add_to_cart()
{
  global $helpers, $_POST, $_FILES, $conn, $_SESSION;

  $product_id = $_POST["product_id"];
  $quantity = $_POST["quantity"];
  $custom_design_url = "";

  if (!empty($_FILES["file"]["name"])) {
    $file = $helpers->upload_file($_FILES["file"], "../uploads/custom_design");

    if ($file->success) {
      $custom_design_url = SERVER_NAME . "/uploads/custom_design/$file->file_name";
    }
  }

  $cartData = array(
    "user_id" => $_SESSION["id"],
    "product_id" => $product_id,
    "quantity" => $quantity,
    "custom_img" => $custom_design_url
  );

  $cart_id = $helpers->insert("cart", $cartData);

  if ($cart_id) {
    $response["success"] = true;
    $response["message"] = "Item successfully added to cart";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function edit_product()
{
  global $helpers, $_POST, $_FILES, $conn;

  $id = $_POST["id"];
  $product_image = $_FILES["product_image"];
  $product_name = $_POST["product_name"];
  $category_id = $_POST["category_id"];
  $quantity = $_POST["quantity"];
  $price = $_POST["price"];
  $description = $_POST["description"];

  $file = $helpers->upload_file($product_image, "../uploads/products");

  $uploadData = null;

  if ($file->success) {
    $image_url = SERVER_NAME . "/uploads/products/$file->file_name";

    $uploadData = array(
      "product_img" => $image_url,
      "name" => $product_name,
      "category_id" => $category_id,
      "quantity" => $quantity,
      "selling_price" => $price,
      "description" => nl2br($description)
    );
  } else {
    $uploadData = array(
      "name" => $product_name,
      "category_id" => $category_id,
      "quantity" => $quantity,
      "selling_price" => $price,
      "description" => nl2br($description)
    );
  }

  $product_id = $helpers->update("products", $uploadData, "id", $id);

  if ($product_id) {
    $response["success"] = true;
    $response["message"] = "Product successfully updated";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}

function add_product()
{
  global $helpers, $_POST, $_FILES, $conn;

  $product_image = $_FILES["product_image"];
  $product_name = $_POST["product_name"];
  $category_id = $_POST["category_id"];
  $quantity = $_POST["quantity"];
  $price = $_POST["price"];
  $description = $_POST["description"];

  $file = $helpers->upload_file($product_image, "../uploads/products");

  if ($file->success) {
    $file_name = $file->file_name;

    $image_url = SERVER_NAME . "/uploads/products/$file_name";

    $uploadData = array(
      "product_img" => $image_url,
      "name" => $product_name,
      "category_id" => $category_id,
      "quantity" => $quantity,
      "selling_price" => $price,
      "description" => nl2br($description)
    );

    $product_id = $helpers->insert("products", $uploadData);

    if ($product_id) {
      $response["success"] = true;
      $response["message"] = "Product successfully added";
    } else {
      $response["success"] = false;
      $response["message"] = $conn->error;
    }
  } else {
    $response["success"] = false;
    $response["message"] = "Error uploading image";
  }

  $helpers->return_response($response);
}

function edit_category()
{
  global $helpers, $_POST, $conn;

  $id = $_POST["id"];
  $category_name = $_POST["category_name"];
  $slug = strtolower(implode("_", preg_split("/\s+/", $category_name)));

  $categories = $helpers->select_all_with_params("categories", "slug='$slug' AND id <> $id");

  if (count($categories) == 0) {
    $categoryData = array(
      "formatted_name" => ucwords($category_name),
      "slug" => $slug
    );

    $category_id = $helpers->update("categories", $categoryData, "id", $id);

    if ($category_id) {
      $response["success"] = true;
      $response["message"] = "Category successfully updated";
    } else {
      $response["success"] = false;
      $response["message"] = $conn->error;
    }
  } else {
    $response["success"] = false;
    $response["message"] = "Category already exist.";
  }

  $helpers->return_response($response);
}

function add_category()
{
  global $helpers, $_POST, $conn;

  $category_name = $_POST["category_name"];
  $slug = strtolower(implode("_", preg_split("/\s+/", $category_name)));

  $categories = $helpers->select_all_with_params("categories", "slug='$slug'");

  if (count($categories) == 0) {
    $categoryData = array(
      "formatted_name" => ucwords($category_name),
      "slug" => $slug
    );

    $category_id = $helpers->insert("categories", $categoryData);

    if ($category_id) {
      $response["success"] = true;
      $response["message"] = "Category successfully added";
    } else {
      $response["success"] = false;
      $response["message"] = $conn->error;
    }
  } else {
    $response["success"] = false;
    $response["message"] = "Category already exist.";
  }

  $helpers->return_response($response);
}

function logout()
{
  global $helpers;
  $path = "../login";

  $helpers->user_logout($path);
}

function login()
{
  global $helpers, $_POST;

  $email = $_POST["email"];
  $password = $_POST["password"];

  $user = $helpers->get_user_by_email($email);

  if ($user) {
    if ($user->password == md5($password)) {
      $response["success"] = true;
      $response["message"] = "Successfully Login";
      $response["role"] = $user->role;

      $_SESSION["id"] = $user->id;
    } else {
      $response["success"] = false;
      $response["message"] = "Password not match";
    }
  } else {
    $response["success"] = false;
    $response["message"] = "User not found";
  }

  $helpers->return_response($response);
}

function registration()
{
  global $helpers, $_POST, $conn;

  $user = $helpers->get_user_by_email($_POST["email"]);

  if (!$user) {
    $registrationData = array(
      "fname" => $_POST["fname"],
      "mname" => $_POST["mname"],
      "lname" => $_POST["lname"],
      "email" => $_POST["email"],
      "password" => md5($_POST["password"]),
      "role" => "user",
    );

    $registration_id = $helpers->insert("users", $registrationData);

    if ($registration_id) {
      $response["success"] = true;
      $response["message"] = "Successfully Registered";
    } else {
      $response["success"] = false;
      $response["message"] = $conn->error;
    }
  } else {
    $response["success"] = false;
    $response["message"] = "Email already exist";
  }

  $helpers->return_response($response);
}

function delete_data()
{
  global $helpers, $_POST, $conn;

  $delete = $helpers->delete($_POST["table"], $_POST["column"], $_POST["val"]);

  if ($delete) {
    $response["success"] = true;
    $response["message"] = "Item successfully deleted";
  } else {
    $response["success"] = false;
    $response["message"] = $conn->error;
  }

  $helpers->return_response($response);
}
