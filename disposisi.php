<!DOCTYPE html>
<html lang="en">
<?php include('header.php'); 
require_once 'Paginator.class.php';
$halasl = $nosrt = $tglsrt = '';
$rows = null;
$aktif=1;
 
    $limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 10;
    $page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
    $links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 5;
    $query      = "select tdposisi.*, tsurat.noagenda, tsurat.nosurat, tdari.satker as textdari, ttuju.satker as texttuju
					from tdposisi 
					inner join tsurat on tdposisi.noagenda=tsurat.noagenda
					inner join tsatker as tdari on tdposisi.dari=tdari.id
					inner join tsatker as ttuju on tdposisi.tujuan=ttuju.id";
 
    $Paginator  = new Paginator( $db, $query );
    $results    = $Paginator->getData( $page, $limit );

$noagd = $cari = $dari = $tuju = $tgl = $dposisi = $update = $edit = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['cari'])) $cari=cek_input($_POST['cari']);
	if (isset($_POST['noagd'])) $noagd=cek_input($_POST['noagd']);
	if (isset($_POST['dari'])) $dari=cek_input($_POST['dari']);
	if (isset($_POST['tuju'])) $tuju=cek_input($_POST['tuju']);
	if (isset($_POST['tgl'])) $tgl=cek_input($_POST['tgl']);
	if (isset($_POST['dposisi'])) $dposisi=cek_input($_POST['dposisi']);
	if (isset($_POST['update'])) $update=cek_input($_POST['update']);
	
	if ($cari !=='' && $cari !== 'true') {
		if ($update !== '') {
			$sql="update tdposisi 
				set dari=$dari, tujuan=$tuju, dposisi='$dposisi', tgldposisi='$tgl', tglentri=curdate(), noagenda='$cari'
				where id=$update";
			$db->query($sql);
			if ($db->affected_rows > 0) {
				header('location:disposisi.php');
			} else {
				$msg->error("Error: " . mysqli_error($db), 'disposisi.php');
			}
		} else {
			$sql="insert into tdposisi (dari, tujuan, dposisi, tgldposisi, tglentri, noagenda)
				values ($dari, $tuju, '$dposisi', '$tgl', curdate(), '$cari')";
			$db->query($sql);
			if ($db->affected_rows > 0) {
				$sql="update tsurat set status=1 where noagenda='$cari'";
				$db->query($sql);
				if ($db->affected_rows > 0) {
					header('location:disposisi.php');
				}
			} else {
				$msg->error("Error: " . mysqli_error($db), 'disposisi.php');
			}
		}
	}
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	if (isset($_GET['edit'])){
		$edit=cek_input($_GET['edit']);
		$sql="select * from tdposisi where id=$edit";
		$result=$db->query($sql);
		if ($db->affected_rows > 0) {
			$row=$result->fetch_array(MYSQLI_ASSOC);
			$noagd = $row['noagenda'];
			$dari = $row['dari'];
			$tgl = $row['tgldposisi'];
			$tuju = $row['tujuan'];
			$dposisi = $row['dposisi'];
		}
	}
	
	if (isset($_GET['hapus'])){
		$hapus=cek_input($_GET['hapus']);
		$noagd=cek_input($_GET['noagd']);
		$sql="delete from tdposisi where id=$hapus";
		$db->query($sql);
		if ($db->affected_rows > 0 ) {
			$sql="update tsurat set status=0 where noagenda='$noagd'";
			$db->query($sql);
			$msg->success('Data berhasil di hapus..!', 'disposisi.php');
		} else {
			$errmsg = "Error: " . $sql . "<br>" . mysqli_error($db);
			$msg->error($errmsg, 'disposisi.php');
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
							<legend>Catat Disposisi</legend>
						</div>
				</div>
			<div class="row well well-sm">
				<div class="row well-sm">
				<form action="disposisi.php" method="POST" class="form form-horizontal">
					<label class="col-md-2 col-xs-4 text-right" for="noagd">No. Agenda:</label>
					<div class="col-md-3 col-xs-5">
						<input type="text" name="noagd" id="noagd" class="form-control input-sm" placeholder="No. agennda" value="<?=$noagd;?>">
					</div>
					<div class="col-md-2 col-xs-3">
						<button id="tampil" type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-eye-open"></span> Tampil</button>
					</div>
					<div class="col-md-2 col-xs-3">
						<a href="#" id="search" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-search"></span> Cari</a>
					</div>
					<input type="hidden" name="cari" value="true">
				</form>
				</div>
				<div class="panel table-responsive">
				<div class="panel-body">
					<table class="table table-striped table-condensed table-bordered">
						<tr>
							<th>Agenda</th>
							<th class="text-nowrap">Tgl Terima</th>
							<th class="text-nowrap">No. Surat</th>
							<th class="text-nowrap">Tgl. Surat</th>
							<th class="text-nowrap"> Asal Surat </th>
							<th>Sifat</th>
							<th class="text-center">Perihal</th>
						</tr>
						<?php
							if ($cari == "true" || $edit !== '') {
								$sql="select * from tsurat where noagenda=$noagd";
								$result=$db->query($sql);
								if ($db->affected_rows > 0) {
									while ($row=$result->fetch_array(MYSQLI_ASSOC)) {
										echo "<tr>";
										echo "<td>".$row['noagenda']."</td>";
										echo "<td>".$row['tglterima']."</td>";
										echo "<td>".$row['nosurat']."</td>";
										echo "<td>".$row['tglsurat']."</td>";
										echo "<td>".$row['asal']."</td>";
										echo "<td>".$row['sifat']."</td>";
										echo "<td>".$row['hal']."</td>";
										echo "</tr>";
									} ?>
									<script>var simpan=false;</script>
								<?php } else {?> 
									<tr>
										<td colspan="7" align="center">Data Tidak Ditemukan</td>
									</tr>									
									<script>var simpan=true;</script>
								<?php }
							}
						?>
					</table>
				</div>
				</div>
				<form action="disposisi.php" method="POST" class="form-horizontal">
				<div class="form-group col-md-12">
					<div class="">
						<label class="col-md-1 text-right" for="dari">Dari:</label>
						<div class="col-md-3">
							<select class="form-control input-sm" name="dari" id="dari">
								<option selected="selected">.:Disposisi:.</option>
								<?php
									$sql="select id, satker from tsatker where dari=true";
									$result=$db->query($sql);
									if ($db->affected_rows > 0) {
										while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
											if ($dari == $row['id']){
												printf('<option value="%s" selected="selected">%s</option>', $row['id'], $row['satker']);
											}else {
												printf('<option value="%s">%s</option>', $row['id'], $row['satker']);
											}
										}
									}
								?>
							</select>
						</div>
					</div>
					<div class="">
						<label class="col-md-1 text-right" for="tuju">Tujuan:</label>
						<div class="col-md-3">
							<select class="form-control input-sm" name="tuju" id="tuju">
								<option selected="selected">.:Tujuan:.</option>
								<?php
									$sql="select id, satker from tsatker where tujuan=true";
									$result=$db->query($sql);
									if ($db->affected_rows > 0) {
										while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
											if ($tuju == $row['id']) {
												printf('<option selected="selected" value="%s">%s</option>', $row['id'], $row['satker']);
											} else {
												printf('<option value="%s">%s</option>', $row['id'], $row['satker']);
											}
										}
									}
								?>
							</select>
						</div>
					</div>
					<div class="">
						<label class="col-md-1 text-right" for="tgl">Tgl:</label>
						<div class="col-md-3">
							<input value="<?=$tgl;?>" type="date" name="tgl" id="tgl" class="form-control input-sm">
						</div>
					</div>
				</div>
				<div class="">
					<label class="col-md-2 text-right" for="dposisi">Disposisi:</label>
					<div class="col-md-10">
						<textarea rows="1" name="dposisi" id="dposisi" class="form-control input-sm" placeholder="Catatan Disposisi"><?=$dposisi ? $dposisi : '';?></textarea>
					</div>
				</div>
				</div>
				<div class="form-group col-md-12">
					<div class="col-md-3 col-md-offset-3 col-xs-4">
						<button id="update" name="update" type="submit" value="<?=$edit ? $edit : ''; ?>" class="btn btn-block btn-primary" disabled="true"><span class="glyphicon glyphicon-floppy-disk"></span><?=$edit ? ' Update' : ' Simpan' ;?></button>
					</div>
					<div class=" col-md-3 col-xs-4">
						<button type="reset" class="btn btn-block btn-warning"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
					</div>
				</div>
					<input type="hidden" name="cari" value="<?=$noagd;?>">
				</form>
			</div>
			<div class="row well well-sm">
				<div class="responsive">
					<table class="table table-striped">
						<tr>
							<th>Tanggal</th>
							<th>Agenda</th>
							<th>No. Surat</th>
							<th>Dari</th>
							<th>Tujuan</th>
							<th>Disposisi</th>
							<th>Opsi</th>
						</tr>
						<?php
							for( $i = 0; $i < count( $results->data ); $i++ ) : ?>
							<tr>
								<?php
									$id=$results->data[$i]['id']; 
									$noagd=$results->data[$i]['noagenda'];
								?>
								<td><?php echo $results->data[$i]['tgldposisi']; ?></td>
								<td><?php echo $results->data[$i]['noagenda']; ?></td>
								<td><?php echo $results->data[$i]['nosurat']; ?></td>
								<td><?php echo $results->data[$i]['textdari']; ?></td>
								<td><?php echo $results->data[$i]['texttuju']; ?></td>
								<td><?php echo $results->data[$i]['dposisi']; ?></td>
								<td><?php
									echo "<a href='disposisi.php?edit=$id' data-toggle=\"tooltip\" title=\"Edit\"><span class=\"glyphicon glyphicon-edit\"></span></a>" ;
									echo "&nbsp";
									echo "<a href='disposisi.php?hapus=$id&noagd=$noagd' data-toggle=\"tooltip\" title=\"Hapus\"><span class=\"glyphicon glyphicon-trash\" onClick=\"return confirm('Yakin menghapus data tersebut?')\"></span></a>" ;
								?></td>
							</tr>
						<?php endfor; ?>
					</table>
						<?php echo $Paginator->createLinks( $links, 'pagination pagination-sm' ); ?> 
				</div>
			</div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    
    <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Cari Surat</h4>
        </div>
        <div class="modal-body">
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
									<input type="text" name="halasl" id="find" class="form-control input-sm" placeholder="Perihal atau asal surat" value="<?=$halasl;?>">
								</div>
								<?php $opt =1;
								echo "<a href='#' onclick=\"showhasil('$opt');\" class='btn btn-primary col-md-2'><span class='glyphicon glyphicon-search'></span> Cari</a>";
								?>	
							</div>
							</form>
						</div>
						<div id="menu1" class="tab-pane fade <?=$aktif == 2 ? 'in active' : '';?>" >
							<form action="cari.php" method="POST" class="form form-horizontal">
							<div class="panel panel-body">
								<label class="col-md-3 text-right" for="nosrt">No. Surat:</label>
								<div class="col-md-5">
									<input type="text" name="nosrt" id="find1" class="form-control input-sm" placeholder="Cari dengan No. Surat" value="<?=$nosrt;?>">
								</div>
								<?php $opt =2;
								echo "<a href='#' onclick=\"showhasil('$opt');\" class='btn btn-primary col-md-2'><span class='glyphicon glyphicon-search'></span> Cari</a>";
								?>								
							</div>
							</form>
						</div>
						<div id="menu2" class="tab-pane fade <?=$aktif == 3 ? 'in active' : '';?>">
							<form action="cari.php" method="POST" class="form form-horizontal">
							<div class="panel panel-body">
								<label class="col-md-3 text-right col-md-offset-1" for="tglsrt">Tgl. Surat:</label>
								<div class="col-md-3">
									<input type="date" name="tglsrt" id="find2" class="form-control input-sm" value="<?=$tglsrt;?>">
								</div>
								<?php $opt =3;
								echo "<a href='#' onclick=\"showhasil('$opt');\" class='btn btn-primary col-md-2'><span class='glyphicon glyphicon-search'></span> Cari</a>";
								?>	
							</div>
							</form>
						</div>
					</div>
                </div>
				<div class="row well well-sm">
					<div id="detail">
						
					</div>
				</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
    
    
    <div id="test">
    	
    </div>
    <!-- /#wrapper -->
	<?php include('footer.php');?>
	
	<script>
		document.getElementById("update").disabled = simpan;
		document.getElementByid("test").innerHMTL = simpan;
		
		function showhasil(opt) {
			if(opt==1){
				var cari=$("#find").val();	
			}else if(opt==2){
				var cari=$("#find1").val();	
			}else {
				var cari=$("#find2").val();	
			}
		if (cari!=""){
		$.ajax({
		type:"post",
		url	:"ajaxcari.php",
		data:"opt="+opt+"&cari="+cari,
		success:function(data){
			$("#detail").html(data);
			
		}
		});
		}
	}
	
	function pilih(agd){
      $.ajax({
		type:"post",
		url	:"disposisi.php",
		data:"noagd="+agd+"&cari=true"
		});
   	}
	</script>
</body>

</html>
