<?php

include('dbconfig.php');
include('session.php');
require 'FlashMessages.php';
$msg = new \Plasticbrain\FlashMessages\FlashMessages();

function cek_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Surat Kendali</title>
	<!-- jQuery -->
	<link href="assets/css/jquery-ui.min.css" rel="stylesheet">
	<!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap-3.3.1.min.css" rel="stylesheet" />
     <!-- FontAwesome Styles-->
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
       <!-- Custom Styles-->
    <link href="assets/css/simple-sidebar.css" rel="stylesheet">
     <!-- Google Fonts-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
     <!-- TABLE STYLES
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" /> -->
	<style>
		.nota {
			display: none;
		}
		
		body.wait *, body.wait
		{
			cursor: progress !important;
		}
	</style>
</head>