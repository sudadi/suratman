<!DOCTYPE html>
<html lang="en">
<?php include('header.php'); 
$old = $new1 = $new2 = '';
$userid=$_SESSION['userid'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['old'])) $old=cek_input($_POST['old']);
	if (isset($_POST['new1'])) $new1=cek_input($_POST['new1']);
	if (isset($_POST['new2'])) $new2=cek_input($_POST['new2']);
	
	if ($new1 !== $new2) {
		$msg->error('Konfirmasi sandi baru tidak sesuai..!');
	} else if ($old !== '' && $new1 !== '' && $new2 !== '') {
		$sql="select * from tuser where userid = '$userid' and sandi = '$old'";
		$db->query($sql);
		if ($db->affected_rows > 0) {
			$sql="update tuser set sandi='$new1' where userid='$userid'";
			$db->query($sql);
			if ($db->affected_rows > 0) {
				$msg->success('Sandi Berhasil di ubah..!', 'sandi.php');
			} else {
				$msg->error('Sandi lama dan baru sama, tidak ada perubahan..!');
			}
		} else {
			$msg->error("Sandi lama yang anda masukkan salah..!");
		}
	}
}

?>
<body>

    <div id="wrapper">

        <!-- Sidebar -->
        <?php include('menu.php'); ?>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <?php $msg->display();?>
            <div class="container-fluid">
				<div class="row">
					<div class="col-md-1">
						<a href="#menu-toggle" class="btn btn-default" id="menu-toggle"><i class="fa fa-bars" aria-hidden="true"></i></a>
					</div>
					<div class="col-md-11">
						<legend>Setting</legend>
					</div>
				</div>
				<div class="row well">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#satker">Setting Satker</a></li>
						<li><a data-toggle="tab" href="#sandi">Setting Sandi</a></li>
					</ul>
					<div class="tab-content">
						<div id="satker" class="tab-pane fade in active">
						<div class="panel panel-default">
							<div class="panel-heading text-center">
								<h4>Setting Satuan Kerja</h4>
							</div>
							<div class="panel-body">
								<form action="setting.php"
							</div>
						</div>
						</div>
						<div id="sandi" class="tab-pane fade">
						<div class="panel panel-default">
							<div class="panel-heading text-center">
								<h4>Form Ubah Sandi</h4>
							</div>
							<div class="panel-body">
								<form action="setting.php" method="POST" class="form form-horizontal">
									<div class="form-group">
										<label class="col-md-3 col-md-offset-2 text-right" for="old">Sandi Lama :</label>
										<div class="col-md-4">
											<input type="password" name="old" id="old" class="form-control input-sm">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 col-md-offset-2 text-right" for="new1">Sandi Baru :</label>
										<div class="col-md-4">
											<input type="password" name="new1" id="new1" class="form-control input-sm">
										</div>
									</div>
									<div class="form-group">
										<label class="col-md-3 col-md-offset-2 text-right" for="new2">Ulang Sandi Baru :</label>
										<div class="col-md-4">
											<input type="password" name="new2" id="new2" class="form-control input-sm">
										</div>
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-primary col-md-2 col-md-offset-5 col-xs-4 col-xs-offset-3"><span class="glyphicon glyphicon-save"></span> Simpan</button>
									</div>
								</form>
							</div>
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
