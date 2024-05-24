<?php

class Helpers
{
  private $separator = "!I_I!";
  private $conn;
  private $session;

  public function __construct($conn, $session)
  {
    $this->conn = $conn;
    $this->session = $session;

    if ($_SERVER['HTTP_HOST'] == "localhost") {
      define("SERVER_NAME", "http://$_SERVER[SERVER_NAME]/earn-edge");
    } else {
      define("SERVER_NAME", "https://$_SERVER[SERVER_NAME]");
    }
  }

  public function get_sidebar_data($user = null)
  {
    $links = array(
      array(
        "title" => "Dashboard",
        "config" => array(
          "icon" => "fa fa-gauge",
          "url" => (SERVER_NAME . "/admin/index"),
          "is_dropdown" => false
        )
      ),
      array(
        "title" => "My Profile",
        "config" => array(
          "icon" => "fa-solid fa-user",
          "url" => (SERVER_NAME . "/admin/profile"),
          "is_dropdown" => false
        )
      ),
      array(
        "title" => "Users",
        "config" => array(
          "icon" => "fa-solid fa-users",
          "url" => (SERVER_NAME . "/admin/users"),
          "is_dropdown" => false
        )
      ),
      array(
        "title" => "Categories",
        "config" => array(
          "icon" => "fa-solid fa-list",
          "url" => (SERVER_NAME . "/admin/categories"),
          "is_dropdown" => false
        )
      ),
      array(
        "title" => "Products",
        "config" => array(
          "icon" => "fa-solid fa-boxes-stacked",
          "url" => (SERVER_NAME . "/admin/products"),
          "is_dropdown" => false
        )
      ),
      array(
        "title" => "Orders",
        "config" => array(
          "icon" => "fa-regular fa-rectangle-list",
          "url" => (SERVER_NAME . "/admin/orders"),
          "is_dropdown" => false
        )
      ),
      array(
        "title" => "For Pickups",
        "config" => array(
          "icon" => "fa-solid fa-people-carry-box",
          "url" => (SERVER_NAME . "/admin/pick-up-orders"),
          "is_dropdown" => false
        )
      ),
      array(
        "title" => "Paid Orders",
        "config" => array(
          "icon" => "fa-solid fa-sack-dollar",
          "url" => (SERVER_NAME . "/admin/paid-orders"),
          "is_dropdown" => false
        )
      ),
      array(
        "title" => "Canceled Orders",
        "config" => array(
          "icon" => "fa-solid fa-user-xmark",
          "url" => (SERVER_NAME . "/admin/canceled-orders"),
          "is_dropdown" => false
        )
      ),
      array(
        "title" => "Expired Orders",
        "config" => array(
          "icon" => "fa-solid fa-clock",
          "url" => (SERVER_NAME . "/admin/expired-orders"),
          "is_dropdown" => false
        )
      ),
      array(
        "title" => "Not Claimed Orders",
        "config" => array(
          "icon" => "fa-solid fa-sack-xmark",
          "url" => (SERVER_NAME . "/admin/not-claimed-orders"),
          "is_dropdown" => false
        )
      ),


    );

    return $links;
  }

  /**  custom builder */

  public function generate_image_upload(
    $imageUploadDivId,
    $title = "Upload Image",
    $inputFileName = "image-file",
    $inputUrlName = "image-url",
    $cancelButtonConfig = array(
      "show" => false,
      "onclick" => ""
    )
  ) {

    $cancelButton = $cancelButtonConfig["show"] ? "<button type='button' class='btn btn-outline-danger btn-sm' onclick='$cancelButtonConfig[onclick]'>Cancel</button>" : "";

    return ("
          <div class='imageupload panel panel-default card' id='$imageUploadDivId'>
            <div class='panel-heading clearfix card-header'>
              <span class='panel-title pull-left card-title float-start'>$title</span>
              <div class='btn-group pull-right float-end'>
                <button type='button' class='btn btn-outline-secondary btn-sm active'>File</button>
                <button type='button' class='btn btn-outline-secondary btn-sm'>URL</button>
                $cancelButton
              </div>
            </div>
            <div class='file-tab panel-body card-body'>
              <label class='btn btn-outline-primary btn-sm btn-file m-2'>
                <span>Browse</span>
                <input type='file' name='$inputFileName' accept='image/*'/>
              </label>
              <button type='button' class='btn btn-default btn-sm btn-outline-danger m-2'>Remove</button>
            </div>
            <div class='url-tab panel-body card-body' style='display: none;'>
              <div class='input-group'>
                <input type='text' class='form-control hasclear form-control-sm' placeholder='Image URL' />
                <button type='button' class='btn btn-default btn-sm btn-outline-secondary'>Submit</button>
              </div>
              
              <button type='button' class='btn btn-default btn-sm btn-outline-danger m-2'>Remove</button>
              
              <input type='hidden' name='$inputUrlName' accept='image/*'/>
            </div>
          </div>
    ");
  }

  public function encrypt($val)
  {
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'AA74CDCC2BBRT935136HH7B63C27';
    $secret_iv = '5fgf5HJ5g27';

    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    $output = openssl_encrypt($val, $encrypt_method, $key, 0, $iv);

    return base64_encode($output);
  }

  public function decrypt($val)
  {
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'AA74CDCC2BBRT935136HH7B63C27';
    $secret_iv = '5fgf5HJ5g27';

    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    return openssl_decrypt(base64_decode($val), $encrypt_method, $key, 0, $iv);
  }

  public function upload_file($file, $path)
  {
    $res = array(
      "success" => false,
      "file_name" => ""
    );

    try {
      if (intval($file["error"]) == 0) {
        $uploadFile = uniqid() . '_' . $file['name'];

        if (!is_dir($path)) {
          mkdir($path, 0777, true);
        }

        if (move_uploaded_file($file['tmp_name'], "$path/$uploadFile")) {
          $res["success"] = true;
          $res["file_name"] = $uploadFile;
        }
      }
    } catch (Exception $e) {
      $err = $e->getMessage();
    }
    return (object) $res;
  }

  public function generate_avatar($isButtonVisible, $src, $user_id, $rounded = true)
  {
    $backendUrl = (SERVER_NAME . "/backend/nodes");
    $resetBtnVisibility = !$src ? "d-none" : "";
    $roundedImg = $rounded ? "rounded" : "rounded-circle";

    return ("
        <div class='card-body'>
            <div class='d-flex align-items-start align-items-sm-center gap-4'>
              <img src='$src' alt='user-avatar' class='d-block $roundedImg' height='100' width='100' style='object-fit: cover' id='uploadedAvatar' />
              " . ($isButtonVisible ? "
              <div class='button-wrapper'>

                <label for='img_upload' class='btn btn-primary me-2 mb-4' tabindex='0'>
                  <span class='d-none d-sm-block'>Upload new photo</span>
                  <i class='bx bx-upload d-block d-sm-none'></i>

                  <input type='file' id='img_upload' class='account-file-input' onclick='handleInputClick()' onchange='handleChangeImage($(this), `uploadedAvatar`, `$backendUrl`, `upload`, `$user_id`)' accept='image/png, image/jpeg' name='img_upload' hidden />
                </label>

                <button type='button' class='btn btn-outline-danger account-image-reset mb-4 $resetBtnVisibility' id='btnReset' onclick='handleChangeImage($(this), `uploadedAvatar`, `$backendUrl`, `reset`, `$user_id`)'>
                  <i class='bx bx-reset d-block d-sm-none'></i>
                  <span class='d-none d-sm-block'>Reset</span>
                </button>

                <p class='text-muted mb-0'>Allowed JPG or PNG</p>
              </div>
              " : "") . "
            </div>
        </div>
        <hr class='my-0' />
    ");
  }

  public function generate_modal_click_avatar($src, $modal_id, $img_id, $caption_id)
  {
    $explodedSrc = explode("/", $src);
    $alt = count($explodedSrc) > 0 ? $explodedSrc[count($explodedSrc) - 1] : "image.jpg";

    return "
        <img src='$src' onclick='handleOpenModalImg($(this), `$modal_id`, `$img_id`, `$caption_id`)' class='avatar avatar-md rounded me-2' alt='$alt'>
  ";
  }

  public function generate_modal_img($modal_id, $img_id, $caption_id)
  {
    return "
    <div id='$modal_id' class='div-modal pt-5'>
      <span class='modal-close' onclick='handleCloseModalImg(`$modal_id`, `$img_id`, `$caption_id`)'>&times;</span>
      <img class='modal-img' id='$img_id'>
      <div id='$caption_id' class='modal-img-caption'></div>
    </div>
  ";
  }

  public function is_self_in_dropdown($self, array $configs)
  {
    $explodedSelf = explode("/", str_replace(".php", "", $self));
    $newSelf = $explodedSelf[count($explodedSelf) - 1];

    foreach ($configs as $config) {
      $explodedUrl = explode("/", $config["url"]);
      $newUrl =  $explodedUrl[count($explodedUrl) - 1];
      if ($newUrl == $newSelf) {
        return true;
      }
    }

    return false;
  }
  public function is_active_menu($url, $self)
  {
    $explodedUrl = explode("/", $url);
    $newUrl =  $explodedUrl[count($explodedUrl) - 1];

    $explodedSelf = explode("/", str_replace(".php", "", $self));
    $newSelf = $explodedSelf[count($explodedSelf) - 1];

    return $newUrl == $newSelf ? "active" : "";
  }

  public function insert($table, $data)
  {
    $columns = array();
    $values = array();

    try {
      if (count($data) > 0) {
        foreach ($data as $column => $value) {
          if ($value) {
            if ($value == "set_null") {
              array_push($columns, "`$column`");
              array_push($values, "NULL");
            } else if ($value == "set_zero") {
              array_push($columns, "`$column`");
              array_push($values, "0");
            } else {
              array_push($columns, "`$column`");
              array_push($values, "'" .   $this->conn->escape_string($value) . "'");
            }
          }
        }

        if (count($values) == count($columns)) {
          $queryStr = "INSERT INTO `$table` (" . implode(",", $columns) . ") VALUES (" . implode(",", $values) . ")";

          $query = $this->conn->query($queryStr);

          if ($query) {
            return $this->conn->insert_id;
          } else {
            $error =  $this->con->error;
          }
        }

        return null;
      }
    } catch (Exception $e) {
      $error = $e->getMessage();
    }

    return null;
  }

  public function select_all_individual($table, $params)
  {
    $query = $this->conn->query("SELECT * FROM $table WHERE $params");

    return $query->num_rows > 0 ? $query->fetch_object() : null;
  }

  public function select_custom_fields_individual($table, array $fields, $params)
  {
    $customFields = implode(",", $fields);

    $query = $this->conn->query("SELECT $customFields FROM $table WHERE $params");

    return $query->num_rows > 0 ? $query->fetch_object() : null;
  }

  public function select_all($table)
  {
    $query = $this->conn->query("SELECT * FROM $table");

    $data = array();

    while ($row = $query->fetch_object()) {
      array_push($data, $row);
    }

    return $data;
  }

  public function select_all_with_params($table, $params)
  {
    $query = $this->conn->query("SELECT * FROM $table WHERE $params");

    $data = array();

    while ($row = $query->fetch_object()) {
      array_push($data, $row);
    }

    return $data;
  }

  public function select_custom_fields($table, array $fields)
  {
    $customFields = implode(",", $fields);

    $query = $this->conn->query("SELECT $customFields FROM $table");

    $data = array();

    while ($row = $query->fetch_object()) {
      array_push($data, $row);
    }

    return $data;
  }

  public function select_custom_fields_with_params($table, array $fields, $params)
  {
    $customFields = implode(",", $fields);

    $query = $this->conn->query("SELECT $customFields FROM $table WHERE $params");

    $data = array();

    while ($row = $query->fetch_object()) {
      array_push($data, $row);
    }

    return $data;
  }

  public function select_custom_query($query)
  {
    $query = $this->conn->query($query);

    $data = array();

    while ($row = $query->fetch_object()) {
      array_push($data, $row);
    }

    return $data;
  }

  function update($table, $data, $column_where, $column_val)
  {
    $set = array();

    try {
      if (count($data) > 0) {
        foreach ($data as $column => $value) {
          if ($value) {
            if ($value == "set_null") {
              array_push($set, "$column = NULL");
            } else if ($value == "set_zero") {
              array_push($set, "$column = '0'");
            } else {
              array_push($set, "$column = '" . $this->conn->escape_string($value) . "'");
            }
          }
        }

        if (count($set) > 0) {
          $queryStr = "UPDATE `$table` SET " . (implode(', ', $set)) . " WHERE $column_where='$column_val'";

          return $this->conn->query($queryStr);
        }

        return null;
      }
    } catch (Exception $e) {
      $error = $e->getMessage();
    }

    return null;
  }

  function delete($table, $column, $value)
  {
    try {
      $queryStr = "DELETE FROM `$table` WHERE `$column`='$value'";

      return $this->conn->query($queryStr);
    } catch (Exception $e) {
      $error = $e->getMessage();
    }

    return null;
  }

  public function is_selected($value, $to_check)
  {
    if ($value && $to_check) {
      if ($value == $to_check) {
        return "selected";
      } else {
        return "";
      }
    }
    return "";
  }

  public function get_user_by_email($email, $id = null)
  {
    $params = $id ? "AND id <> $id" : "";
    $query = $this->conn->query("SELECT * FROM users WHERE email='$email' $params");

    return $query->num_rows > 0 ? $query->fetch_object() : null;
  }

  public function get_current_user()
  {
    $id = $this->session["id"];

    $query = $this->conn->query("SELECT * FROM users WHERE id='$id'");

    return $query->num_rows > 0 ? $query->fetch_object() : null;
  }

  public function get_user_by_id($user_id)
  {
    $query = $this->conn->query("SELECT * FROM users WHERE id='$user_id'");

    return $query->num_rows > 0 ? $query->fetch_object() : null;
  }

  public function get_full_name($user_id, $format = "") // format = with_middle
  {
    $user = $this->get_user_by_id($user_id);
    $fullName = "";

    if ($user->mname == "") {
      $fullName = ucwords("$user->fname $user->lname");
    } else {
      if ($format) {
        $fullName = ucwords("$user->fname $user->mname $user->lname");
      } else {
        $middle = $user->mname[0];
        $fullName = ucwords("$user->fname " . $middle . ". $user->lname");
      }
    }

    return $fullName;
  }

  public function get_avatar_link($user_id)
  {
    $user = $this->get_user_by_id($user_id);

    if ($user->avatar) {
      return SERVER_NAME . "/uploads/avatars/$user->avatar";
    }

    return SERVER_NAME . "/custom-assets/images/default.png";
  }

  function user_logout($path)
  {
    global $_SESSION;

    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
      );
    }

    session_destroy();
    header("location: $path");
  }

  function return_response($params)
  {
    print_r(
      json_encode($params)
    );
    exit;
  }

  function pr($data)
  {
    echo "<pre>";
    print_r($data); // or var_dump($data);
    echo "</pre>";
  }
}
