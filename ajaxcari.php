<?php
include('dbconfig.php');
include('session.php');


	if (isset($_POST['opt'])) $opt=($_POST['opt']);
	if (isset($_POST['cari'])) $cari=($_POST['cari']);
	
	if ($opt == 1) {
		$sql="select *  from tsurat where hal like '%$cari%' or asal like '%$cari%' ";
		$result=$db->query($sql);
		if ($db->affected_rows > 0) {
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$rows[]=$row;
			}
		}
	} else if ($opt == 2) {
		
		$sql="select *  from tsurat where nosurat like '%$cari%'";
		$result=$db->query($sql);
		if ($db->affected_rows > 0) {
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$rows[]=$row;
			}
		}
	} else if ($opt == 3){
		
		$sql="select *  from tsurat where tglsurat='$cari'";
		$result=$db->query($sql);
		if ($db->affected_rows > 0) {
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$rows[]=$row;
			}
		}
	}	
	?>
	<div class=" table-responsive">
    	<table class="table table-striped">
			<tr>
				<th>Agenda</th>
				<th>Tgl Terima</th>
				<th class="text-nowrap">No. Surat</th>
				<th>Tgl. Surat</th>
				<th class="text-nowrap"> Asal Surat </th>
				<th class="text-center">Perihal</th>
				<th>Opsi</th>
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
				echo "<td>".$row['hal']."</td><td>";
				?>
				<form action="disposisi.php" method="post">
					<input type="hidden" name="cari" value="true"/>
					<input type="hidden" name="noagd" value="<?=$noagd;?>"/>
					<input type="submit" value="Pilih" class="btn btn-primary"/>
				</form>
				<?php
				echo "</td></tr>";
			} 
			}
			?>
		</table>
	</div>		
