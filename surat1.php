<!DOCTYPE html>
<html lang="en">
<?php include('header.php'); 
require_once 'Paginator.class.php';
 
    //$conn       = new mysqli( '127.0.0.1', 'root', 'root', 'world' );
 
    $limit      = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : 10;
    $page       = ( isset( $_GET['page'] ) ) ? $_GET['page'] : 1;
    $links      = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 5;
    $query      = "SELECT * FROM tsurat";
 
    $Paginator  = new Paginator( $db, $query );
 
    $results    = $Paginator->getData( $page, $limit );


$edit = $hapus = $noagenda = $nosurat = $tglsurat = $tglterima = $asalsurat = $sifat = $hal ='';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if ($_POST['nosurat'] != null ) $nosurat=cek_input($_POST['nosurat']);
	if ($_POST['noagenda'] != null) $noagenda=cek_input($_POST['noagenda']);
	if ($_POST['tglsurat'] != null) $tglsurat=cek_input($_POST['tglsurat']);
	if ($_POST['tglterima'] != null) $tglterima=cek_input($_POST['tglterima']);
	if ($_POST['asalsurat']	!= null) $asalsurat=cek_input($_POST['asalsurat']);
	if ($_POST['sifat'] != null) $sifat=cek_input($_POST['sifat']);
	if ($_POST['hal'] != null) $hal=cek_input($_POST['hal']);
	if (isset($_POST['edit'])) $edit=cek_input($_POST['edit']);
	
	if ($nosurat != ''&& $noagenda != '' && $tglsurat != '' && $tglterima != '' && $asalsurat != '' && $sifat != '' && $hal != '') {
		unset($_POST);
		if ($edit !=''){
			$sql="update tsurat set nosurat='$nosurat', noagenda='$noagenda', tglsurat='$tglsurat', tglterima='$tglterima', 
				asal='$asalsurat', sifat='$sifat', hal='$hal', tglentri=curdate() where id=$edit";
			$db->query($sql);
			if ($db->affected_rows < 0) {
				$errmsg = "Error: " . $sql . "<br>" . mysqli_error($db);
				$msg->error($errmsg, 'surat.php');
			} else {
				$msg->success('Update data berhasil..!', 'surat.php');
			}
		} else {
			$sql="insert into tsurat (nosurat, noagenda, tglsurat, tglterima, asal, sifat, hal, tglentri, status)
				values ('$nosurat', '$noagenda', '$tglsurat', '$tglterima', '$asalsurat', '$sifat', '$hal', curdate(), 0)";
			$db->query($sql);
			if ($db->affected_rows < 0) {
				$errmsg = "Error: " . $sql . "<br>" . mysqli_error($db);
				$msg->error($errmsg, 'surat.php');
			} else {
				$msg->success('Data tersimpan..!', 'surat.php');
			}
		}
	} else {
		$msg->error("Data yang anda isikan tidak lengkap..!", 'surat.php');
	}
}

$sql="select noagenda from tsurat order by id DESC limit 1";
$result=$db->query($sql);
if ($db->affected_rows == 1) {
	$row=$result->fetch_array(MYSQLI_ASSOC);
	$urut=((int)$row['noagenda'])+1;
	if ($urut < 10){
		$noagenda="0000".$urut;
	} else if ($urut < 100) {
		$noagenda="000".$urut;
	} else if ($urut < 1000) {
		$noagenda = "00".$urut;
	} else if ($urut <10000) {
		$noagenda = "0".$urut;
	} else {
		$noagenda = "".$urut;
	}
} else {
	$noagenda="00001";
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
	if (isset($_GET['edit'])){
		$edit=cek_input($_GET['edit']);
		$sql="select * from tsurat where id=$edit";
		$result=$db->query($sql);
		if ($db->affected_rows > 0) {
			$row=$result->fetch_array(MYSQLI_ASSOC);
			$noagenda = $row['noagenda'];
			$nosurat = $row['nosurat'];
			$tglsurat = $row['tglsurat'];
			$tglterima = $row['tglterima'];
			$asalsurat = $row['asal'];
			$sifat = $row['sifat'];
			$hal = $row['hal'];
		}
	}
	
	if (isset($_GET['hapus'])){
		$hapus=cek_input($_GET['hapus']);
		$sql="delete from tsurat where id=$hapus";
		$db->query($sql);
		if ($db->affected_rows > 0 ) {
			$msg->success('Data berhasil di hapus..!', 'surat.php');
		} else {
			$errmsg = "Error: " . $sql . "<br>" . mysqli_error($db);
			$msg->error($errmsg, 'surat.php');
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
						<legend>Catat Surat Masuk</legend>
					</div>
				</div>
				<div class="row well well-sm">
					<form action="surat.php" method="POST" class="form-horizontal">
					<div class="form-group col-md-12">	
						<label class="col-md-2 text-right" for="nosurat">No. Surat:</label>
						<div class="col-md-4">
							<textarea rows="1" name="nosurat" id="nosurat" class="form-control input-sm" placeholder="Nomer Surat"><?=$nosurat;?></textarea>
						</div>
						<label class="col-md-3 text-right" for="noagenda">No. Agenda:</label>
						<div class="col-md-3">
							<input type="text" name="noagenda" id="noagenda" class="form-control input-sm" value="<?=$noagenda; ?>" readonly>
						</div>
					</div>
					<div class="form-group col-md-12">	
						<label class="col-md-2 text-right" for="tglsurat">Tgl Surat:</label>
						<div class="col-md-3">
							<input type="date" name="tglsurat" id="tglsurat" value="<?=$tglsurat;?>" class="form-control input-sm">
						</div>
						<label class="col-md-3 col-md-offset-1 text-right" for="tglterima">Tgl Terima:</label>
						<div class="col-md-3">
							<input type="date" name="tglterima" id="tglterima" value="<?=$tglterima;?>" class="form-control input-sm">
						</div>
					</div>
					<div class="form-group col-md-12">	
						<label class="col-md-2 text-right" for="asalsurat">Asal Surat:</label>
						<div class="col-md-4">
							<textarea rows="1"  name="asalsurat" id="asalsurat" class="form-control input-sm" placeholder="Asal Surat"><?=$asalsurat;?></textarea>
						</div>
						<label class="col-md-3 text-right" for="sifat">Sifat:</label>
						<div class="col-md-3">
							<select class="form-control input-sm" name="sifat" id="sifat">
								<option selected="selected">Biasa</option>
								<option <?=$sifat == 'Cito' ? ' selected="selected"' : '';?>>Cito</option>
								<option <?=$sifat == 'Rahasia' ? ' selected="selected"' : '';?>>Rahasia</option>
							 </select>
						</div>
					</div>
					<div class="form-group col-md-12">
						<label class="col-md-2 text-right" for="hal">Hal:</label>
						<div class="col-md-10">
							<textarea class="form-control" rows="2" name="hal" id="hal"><?=$hal;?></textarea>
						</div>
					</div>
					<div class="form-group col-md-12 ">
						<div class="col-md-3 col-md-offset-3 col-xs-6">
							<input type="hidden" name="edit" value="<?=$edit?>">
							<button type="submit" class="btn btn-primary  btn-block"><span class="glyphicon glyphicon-save"></span> 
								<?=$edit ? 'Update' : 'Simpan';?> 
							</button>
						</div>
						<div class="col-md-3 col-xs-6">
							<button type="reset" class="btn btn-warning btn-block"><span class="glyphicon glyphicon-refresh"></span> Reset</button>
						</div>
					</div>
					</form>
				</div>
				<div class="row well well-sm">
					<div class=" table-responsive">
                	<table class="table table-striped table-condensed">
						<tr>
							<th>Agenda</th>
							<th>Tgl Terima</th>
							<th class="text-nowrap">No. Surat</th>
							<th>Tgl. Surat</th>
							<th class="text-nowrap"> Asal Surat </th>
							<th>Sifat</th>
							<th class="text-center">Perihal</th>
							<th>Opsi</th>
						</tr>
						<?php
							for( $i = 0; $i < count( $results->data ); $i++ ) : ?>
							<tr>
									<?php $id=$results->data[$i]['id']; ?>
									<td><?php echo $results->data[$i]['noagenda']; ?></td>
									<td><?php echo $results->data[$i]['tglterima']; ?></td>
									<td><?php echo $results->data[$i]['nosurat']; ?></td>
									<td><?php echo $results->data[$i]['tglsurat']; ?></td>
									<td><?php echo $results->data[$i]['asal']; ?></td>
									<td><?php echo $results->data[$i]['sifat']; ?></td>
									<td><?php echo $results->data[$i]['hal']; ?></td>
									<td><?php
									echo "<a href='surat.php?edit=$id' data-toggle=\"tooltip\" title=\"Edit\"><span class=\"glyphicon glyphicon-edit\"></span></a>" ;
									echo "&nbsp";
									echo "<a href='surat.php?hapus=$id' data-toggle=\"tooltip\" title=\"Hapus\"><span class=\"glyphicon glyphicon-trash\" onClick=\"return confirm('Yakin menghapus data tersebut?')\"></span></a>" ;
									?></td>
							</tr>
						<?php endfor; ?>
					</table>
						<?php echo $Paginator->createLinks( $links, 'pagination pagination-sm' ); ?> 
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
