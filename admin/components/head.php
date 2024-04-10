<?php
if (!isset($_SESSION["id"])) {
  header("LOCATION: ./");
}
$LOGIN_USER = $helpers->get_user_by_id($_SESSION['id']);
?>
<title>EarnEdge</title>

<!-- Meta -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta name="description" content="EarnEdge">
<link rel="shortcut icon" href="favicon.ico">

<!-- FontAwesome JS-->
<script defer src="<?= SERVER_NAME . "/admin/assets/plugins/fontawesome/js/all.min.js" ?>"></script>

<link rel='stylesheet' href='https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css' />
<link rel='stylesheet' href='https://cdn.datatables.net/buttons/3.0.0/css/buttons.bootstrap5.css' />
<link rel='stylesheet' href='https://cdn.datatables.net/responsive/3.0.0/css/responsive.bootstrap5.css' />

<link rel='stylesheet' href='https://cdn.datatables.net/searchbuilder/1.7.0/css/searchBuilder.bootstrap5.css' />
<link rel='stylesheet' href='https://cdn.datatables.net/datetime/1.5.2/css/dataTables.dateTime.min.css' />

<!-- App CSS -->
<link id="theme-style" rel="stylesheet" href="<?= SERVER_NAME . "/admin/assets/css/portal.css" ?>">
<link id="theme-style" rel="stylesheet" href="<?= SERVER_NAME . "/custom-assets/css/custom.css" ?>">