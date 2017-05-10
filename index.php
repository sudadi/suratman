<!DOCTYPE html>
<html lang="en">
<?php include('header.php'); ?>
<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <?php include('menu.php'); ?>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
			    <div class="row">
					<div class="col-md-1">
						<a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></a>
					</div>
					<div class="col-md-11">
						<legend>Aplikasi Manajemen Surat<br /><small>RSO Prof.DR.R. Soeharso Surakarta</small></legend>
					</div>
				</div>
				<div class="row">
					<img src="assets/img/banner1.jpg" class="img-rounded img-responsive"></img>
                </div>
				<br />
				<div class="row">
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-body">
								<a href="surat.php"><img class="img-responsive img-rounded" src="assets/img/inbox.jpg"></img></a>
							</div>
							<div class="panel-footer text-center">
								<b>Surat Masuk</b>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-body">
								<a href="disposisi.php"><img class="img-responsive img-rounded" src="assets/img/send.jpg"></img></a>
							</div>
							<div class="panel-footer text-center">
								<b>Disposisi</b>
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="panel panel-default">
							<div class="panel-body">
								<a href="cari.php"><img class="img-responsive img-rounded" src="assets/img/search.jpg"></img></a>
							</div>
							<div class="panel-footer text-center">
								<b>Cari Surat</b>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->
	<?php include('footer.php');?>
</body>

</html>
