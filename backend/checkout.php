<?php
include_once(__DIR__ . "/config.php");

require_once 'paypal-checkout-class.php';
$paypal = new PaypalCheckout;

$response = array('status' => 0, 'msg' => 'Transaction Failed!');
if (!empty($_POST['paypal_order_check']) && !empty($_POST['order_id'])) {
  $response = array('status' => 1);
}
echo json_encode($response);
