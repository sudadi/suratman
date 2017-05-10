<?php
include("dbconfig.php");
session_start();
require 'FlashMessages.php';
$msg = new \Plasticbrain\FlashMessages\FlashMessages();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      
      $sql = "SELECT * FROM tuser WHERE userid = '$myusername' and sandi = '$mypassword'";
	  $result = $db->query($sql);
	  if ($db->affected_rows > 0) {
		$row = $result->fetch_array(MYSQLI_ASSOC);  
        $_SESSION['userid'] = $row['userid'];
		$_SESSION['nmuser'] = $row['nama'];
		header("location: index.php");
      }else {
         $error = "User-ID atau Sandi yang anda masukkan salah..!";
		 $msg->error($error);
      }
   }
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Surat Kendali</title>

    <!-- Bootstrap Core CSS -->
    <link href="assets/css/bootstrap-3.3.1.min.css" rel="stylesheet" />

    <!-- Custom CSS -->

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->

    <!-- Page Content -->
    <div class="container">
		<?php $msg->display(); ?>
        <!-- Page Header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" Style="text-align:center">Surat Kendali
                    <div><small>Manajemen Surat Masuk</small></div>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Projects Row -->

		<div class="row">
			<div class="col-sm-6 col-md-4 col-md-offset-4">
				<div class="panel panel-default">
					<div class="panel-heading">
						<strong> Sign-in</strong>
					</div>
					<div class="panel-body">
						<form role="form" action="#" method="POST">
							<fieldset>
								<div class="row">
									<div class="img-responsive ">
										<img class="profile-img center-block"
											src="assets/img/user.png" alt="">
									</div>
								</div> <br />
								<div class="row">
									<div class="col-sm-12 col-md-10  col-md-offset-1 ">
										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-user"></i>
												</span> 
												<input class="form-control" placeholder="Username" name="username" type="text" autofocus>
											</div>
										</div>
										<div class="form-group">
											<div class="input-group">
												<span class="input-group-addon">
													<i class="glyphicon glyphicon-lock"></i>
												</span>
												<input class="form-control" placeholder="Password" name="password" type="password" value="">
											</div>
										</div>
										<div class="form-group">
											<input type="submit" class="btn btn-lg btn-primary btn-block" value="Sign in">
										</div>
									</div>
								</div>
							</fieldset>
						</form>
					</div>

                </div>
			</div>
		</div>

		
		
        <!-- /.row -->

        
        <hr>

       <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Copyright &copy; 2016</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
	<script src="assets/js/jquery-2.2.4.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script> -->

    <!-- Bootstrap Core JavaScript -->
    
    <script src="assets/js/bootstrap.min.js"></script> 

</body>

</html>
		