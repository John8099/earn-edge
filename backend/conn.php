<?php


class Connect
{
  public $conn;

  public function __construct()
  {
    if ($_SERVER['HTTP_HOST'] == "localhost") {
      $host = "localhost";
      $user = "root";
      $password = "";
      $db = "earn_edge";
    } else {
      $host = "localhost";
      $user = "id22109410_earn_edge";
      $password = "Mayethanks_27!";
      $db = "id22109410_earn_edge";
    }

    try {
      $this->conn = new mysqli($host, $user, $password, $db);

      return $this->conn;
    } catch (Exception $e) {
      echo "<script>console.log('" . ($e->getMessage()) . "')</script>";
    }
  }
}
