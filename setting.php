<!DOCTYPE html>
<html lang="en">
<?php include('header.php'); 
$old = $new1 = $new2 = $edit = $satker = $pwd = '';
 $dari = $tuju = $id = 0;
$userid=$_SESSION['userid'];

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	if (isset($_GET['edit'])) {
		$edit=$_GET['edit'];
		$sql="select * from tsatker where id=$edit";
		$result=$db->query($sql);
		if ($db->affected_rows >0) {
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$id=$row['id'];
			$satker=$row['satker'];
			$dari=$row['dari'];
			$tuju=$row['tujuan'];
		}
	} else if (isset($_GET['hapus'])) {
		$hapus=$_GET['hapus'];
		$sql="delete from tsatker where id=$hapus";
		$db->query($sql);
		if ($db->affected_rows > 0) {
			$msg->success("Data Berhasil Dihapus..!");
		} else {
			$msg->error("Hapus Data GAGAL..!");
		}
	}
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['old'])) $old=cek_input($_POST['old']);
	if (isset($_POST['new1'])) $new1=cek_input($_POST['new1']);
	if (isset($_POST['new2'])) $new2=cek_input($_POST['new2']);
	if (isset($_POST['pwd'])) $pwd=cek_input($_POST['pwd']);
	if (isset($_POST['sat'])) $sat=cek_input($_POST['sat']);
	if (isset($_POST['tuju'])) $tuju=cek_input($_POST['tuju']);
	if (isset($_POST['dari'])) $dari=cek_input($_POST['dari']);
	if (isset($_POST['satker'])) $satker=cek_input($_POST['satker']);
	
	if ($pwd) {
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
	} else if ($sat !== '') {
		$sql="update tsatker set satker='$satker', dari=$dari, tujuan=$tuju where id=$sat";
		$db->query($sql);
		if ($db->affected_rows > 0) {
			$msg->success('Update Data Satker Berhasil..!', 'setting.php');
		} else {
			$msg->error('Update GAGAL..!'.mysqli_error($db));
		}
	} else if ($sat == '') {
		$sql="insert into tsatker (satker, dari, tujuan) values ('$satker', $dari, $tuju)";
		$db->query($sql);
		if ($db->affected_rows > 0) {
			$msg->success('Data Satker Berhasil Ditambahkan..!', 'setting.php');
		} else {
			$msg->error('GAGAL Menambah Data Satker..!');
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
							<form action="setting.php" method="POST" class="form-horizontal">
							<div class="form-group">
							<div class="col-md-6">
								<label class="col-md-2 text-right" for="satker">Satker:</label>
								<div class="col-md-10">
									<input <?=$edit ? "value='$satker'" : "";?> type="text" name="satker" id="satker" class="form-control input-sm">
								</div>
							</div>
							<div class="col-md-6">
								<div class="col-md-6">
								<label class="checkbox-inline"><input type="checkbox" name="dari" value="1" <?=$dari ? 'checked="checked"' : '';?>>Asal Disposisi</label>
								</div>
								<div class="col-md-6">
									<label class="checkbox-inline"><input type="checkbox" name="tuju" value="1" <?=$tuju ? 'checked="checked"' : '';?>>Tujuan Disposisi</label>
								</div>
							</div>
							</div>
							<div class="col-md-12 form-group">
								<button type="submit" name="sat" <?=($edit!=='') ? "value='$edit'" : "value=''" ;?> value="true" class="btn btn-primary col-md-2 col-md-offset-5 col-xs-4 col-xs-offset-4">
								<?=$edit ? '<span class="glyphicon glyphicon-save"></span> Update' : '<span class="glyphicon glyphicon-save"></span> Simpan';?></button>
							</div>
							</form>
							<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-condensed table-striped">
									<tr>
										<th>ID</th>
										<th>Satker</th>
										<th>Asal</th>
										<th>Tujuan</th>
										<th>Opsi</th>
									</tr>
									<?php
										$sql="select * from tsatker";
										$result=$db->query($sql);
										if ($db->affected_rows > 0) {
											while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
												echo "<tr>";
												$id=$row['id'];
												echo "<td>".$id."</td>";
												echo "<td>".$row['satker']."</td>";
												$row['dari'] == 1 ? $dari='YA' : $dari='tidak';
												echo "<td>".$dari."</td>";
												$row['tujuan'] == 1 ? $tuju='YA' : $tuju='tidak';
												echo "<td>".$tuju."</td>";
												echo "<td>";
												echo "<a href='setting.php?edit=$id' data-toggle=\"tooltip\" title=\"Edit\"><span class=\"glyphicon glyphicon-edit\"></span></a>" ;
												echo "&nbsp";
												echo "<a href='setting.php?hapus=$id' data-toggle=\"tooltip\" title=\"Hapus\"><span class=\"glyphicon glyphicon-trash\" onClick=\"return confirm('Yakin menghapus data tersebut?')\"></span></a>" ;
												echo "</td>";
												echo "</tr>";
											}
										}
									?>
								</table>
							</div>
							</div>
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
										<button type="submit" name="pwd" value="true" class="btn btn-primary col-md-2 col-md-offset-5 col-xs-4 col-xs-offset-3"><span class="glyphicon glyphicon-save"></span> Simpan</button>
									</div>
								</form>
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
