<?php
   //include('dbconfig.php');
   session_start();
   
   //$user_check = $_SESSION['login_user'];
   //$result = mysqli_query($db, "select user from user where username = $user_check");
   //$row = mysqli_fetch_array($result);
  // $login_session = $row['user'];
   
   if(!isset($_SESSION['userid'])){
      header("location:login.php");
   } else {
		//if ((isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) || (isset($_SESSION['tgl']) && $_SESSION['tgl'] < date('Y/m/d'))) {
		if (isset($_SESSION['tgl']) && $_SESSION['tgl'] < date('Y/m/d')){
			// last request was more than 30 minutes ago
			session_unset();     // unset $_SESSION variable for the run-time 
			session_destroy();   // destroy session data in storage
			header("location:login.php");
		}
		$_SESSION['LAST_ACTIVITY'] = time();
		$_SESSION['tgl'] = date('Y/m/d');
   }
?>