<?php
//require_once('includes/db_connect.php'); // Database connection file
require_once('includes/functions.php');  // PHP functions file
require_once "config.php";

$page_id = 4;
$visitor_ip = $_SERVER['REMOTE_ADDR']; // stores IP address of visitor in variable
add_view($link, $visitor_ip, $page_id);
?>
<!-- header file -->
<?php require_once('includes/header.php'); ?>



<div>
  <?php
  $total_website_views = total_views($link); // Returns total website views
  echo  $total_website_views;
  ?>
</div>
<div style="color: red;">Note: This page only displays the total views of website.<div>
<!-- footer file -->
