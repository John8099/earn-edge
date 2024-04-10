<?php
$LOGIN_USER = null;

if (isset($_SESSION["id"])) {
  $LOGIN_USER = $helpers->get_user_by_id($_SESSION['id']);
}
?>
<title>EarnEdge</title>
<!-- for-mobile-apps -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Super Market Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript">
  addEventListener("load", function() {
    setTimeout(hideURLbar, 0);
  }, false);

  function hideURLbar() {
    window.scrollTo(0, 1);
  }
</script>
<!-- //for-mobile-apps -->
<link href="<?= SERVER_NAME . "/assets/css/bootstrap.css" ?>" rel="stylesheet" />
<link href="<?= SERVER_NAME . "/assets/css/style.css" ?>" rel="stylesheet" />
<!-- font-awesome icons -->
<link href="<?= SERVER_NAME . "/assets/css/font-awesome.css" ?>" rel="stylesheet">
<!-- //font-awesome icons -->


<link href='https://fonts.googleapis.com/css?family=Raleway:400,100,100italic,200,200italic,300,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>


<link href="<?= SERVER_NAME . "/assets/css/skdslider.css" ?>" rel="stylesheet">
<!-- start-smoth-scrolling -->

<link rel="stylesheet" href="<?= SERVER_NAME . "/custom-assets/css/custom.css" ?>">
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>