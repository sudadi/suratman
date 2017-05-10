<!DOCTYPE html>
<html lang="en">
<?php include('header.php'); 
$halasl = $nosrt = $tglsrt = '';
$rows = null;
$aktif=1;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['halasl'])) $halasl=cek_input($_POST['halasl']);
	if (isset($_POST['nosrt'])) $nosrt=cek_input($_POST['nosrt']);
	if (isset($_POST['tglsrt'])) $tglsrt=cek_input($_POST['tglsrt']);
	
	if ($halasl !== '') {
		$sql="select *  from tsurat where hal like '%$halasl%' or asal like '%$halasl%' ";
		$result=$db->query($sql);
		if ($db->affected_rows > 0) {
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$rows[]=$row;
			}
		}
	} else if ($nosrt !== '') {
		$aktif=2;
		$sql="select *  from tsurat where nosurat like '%$nosrt%'";
		$result=$db->query($sql);
		if ($db->affected_rows > 0) {
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$rows[]=$row;
			}
		}
	} else if ($tglsrt !== ''){
		$aktif=3;
		$sql="select *  from tsurat where tglsurat='$tglsrt'";
		$result=$db->query($sql);
		if ($db->affected_rows > 0) {
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$rows[]=$row;
			}
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
						<legend>Pencarian Data</legend>
					</div>
				</div> 
				<div class="row well">
					<ul class="nav nav-tabs">
						<li class="<?=$aktif == 1 ? 'active' : '';?>"><a data-toggle="tab" href="#home">Asal/Perihal</a></li>
						<li class="<?=$aktif == 2 ? 'active' : '';?>"><a data-toggle="tab" href="#menu1">No. Surat</a></li>
						<li class="<?=$aktif == 3 ? 'active' : '';?>"><a data-toggle="tab" href="#menu2">Tgl. Surat</a></li>
					</ul>

					<div class="tab-content">
						<div id="home" class="tab-pane fade <?=$aktif == 1 ? 'in active' : '';?>">
							<form action="cari.php" method="POST" class="form form-horizontal">
							<div class="panel panel-body">
								<label class="col-md-3 text-right text-nowrap" for="halasl">Perihal atau Asal Surat:</label>
								<div class="col-md-7">
									<input type="text" name="halasl" id="halasl" class="form-control input-sm" placeholder="Perihal atau asal surat" value="<?=$halasl;?>">
								</div>
								<button type="submit" class="btn btn-primary col-md-2"><span class="glyphicon glyphicon-search"></span> Cari</button>
							</div>
							</form>
						</div>
						<div id="menu1" class="tab-pane fade <?=$aktif == 2 ? 'in active' : '';?>" >
							<form action="cari.php" method="POST" class="form form-horizontal">
							<div class="panel panel-body">
								<label class="col-md-3 text-right" for="nosrt">No. Surat:</label>
								<div class="col-md-5">
									<input type="text" name="nosrt" id="nosrt" class="form-control input-sm" placeholder="Cari dengan No. Surat" value="<?=$nosrt;?>">
								</div>
								<button type="submit" class="btn btn-primary col-md-2"><span class="glyphicon glyphicon-search"></span> Cari</button>
							</div>
							</form>
						</div>
						<div id="menu2" class="tab-pane fade <?=$aktif == 3 ? 'in active' : '';?>">
							<form action="cari.php" method="POST" class="form form-horizontal">
							<div class="panel panel-body">
								<label class="col-md-3 text-right col-md-offset-1" for="tglsrt">Tgl. Surat:</label>
								<div class="col-md-3">
									<input type="date" name="tglsrt" id="tglsrt" class="form-control input-sm" value="<?=$tglsrt;?>">
								</div>
								<button type="submit" class="btn btn-primary col-md-2"><span class="glyphicon glyphicon-search"></span> Cari</button>
							</div>
							</form>
						</div>
					</div>
                </div>
				<div class="row well well-sm">
					<div class=" table-responsive">
                	<table class="table table-striped">
						<tr>
							<th>Agenda</th>
							<th>Tgl Terima</th>
							<th class="text-nowrap">No. Surat</th>
							<th>Tgl. Surat</th>
							<th class="text-nowrap"> Asal Surat </th>
							<th>Sifat</th>
							<th class="text-center">Perihal</th>
							<th>Disp.</th>
						</tr>
						<?php
						if ($rows) {
						foreach ($rows as $row){
							echo "<tr>";
							echo "<td>".$row['noagenda']."</td>";
							$noagd=$row['noagenda'];
							echo "<td>".$row['tglterima']."</td>";
							echo "<td>".$row['nosurat']."</td>";
							echo "<td>".$row['tglsurat']."</td>";
							echo "<td>".$row['asal']."</td>";
							echo "<td>".$row['sifat']."</td>";
							echo "<td>".$row['hal']."</td>";
							if ($row['status']==1) {
								echo "<td><a href='#' onclick=\"showdetail('$noagd');\" data-toggle='tooltip' title='Detail Disposisi'><span class='glyphicon glyphicon-check'></span></a></td>";
							}
							echo "</tr>";
						} 
						}
						?>
					</table>
					</div>
				</div>		
			</div>
		</div>
        <!-- /#page-content-wrapper -->

    </div>
	<!-- Modal detail -->
	<div id="Modaldetail" class="modal fade" role="dialog">
	  <div class="modal-dialog modal-lg">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Detail Disposisi</h4>
			</div>
			<div class="modal-body">
				<div class="table-responsive" id="detail">
				
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	  </div>
	</div>
	
    <!-- /#wrapper -->
	<?php include('footer.php');?>
	<script type="text/javascript">
	
		function showdetail(noagd) {
			$.ajax({
			type:'post',
			url	:'ajaxdposisi.php',
			data:'noagd='+noagd,
			success:function(data){
				$('#detail').html(data);
				$('#Modaldetail').modal('show');
			}
			});
		}
	
	</script>
</body>

</html>
