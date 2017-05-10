<?php
include('dbconfig.php');
include('session.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['bln'])) $bln=$_POST['bln'];
	if (isset($_POST['tahun'])) $tahun=$_POST['tahun'];
	if (isset($_POST['stat'])) $stat=$_POST['stat'];
	
	if ($bln !== '' && $tahun !== '') {
		if ($stat !== '') {
			$sql="select * from tsurat where month(tglterima)='$bln' and year(tglterima)='$tahun' and status=$stat";
		} else {
			$sql="select * from tsurat where month(tglterima)='$bln' and year(tglterima)='$tahun'";
		}
		$result=$db->query($sql);
		if ($db->affected_rows > 0) {
			echo "<table class='table table-striped'>";
			echo 	"<tr>
					<th>Agenda</th>
					<th>Tgl Terima</th>
					<th class='text-nowrap'>No. Surat</th>
					<th>Tgl. Surat</th>
					<th class='text-nowrap'> Asal Surat </th>
					<th>Sifat</th>
					<th class='text-center'>Perihal</th>
					<th>Detail</th>
					</tr>";
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				echo "<tr>";
				$noagd=$row['noagenda'];
				echo "<td>".$noagd."</td>";
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
			echo "</table>";
		} else {
			echo "<b>Data tidak ditemukan..!</b>";
		}
	}
}
?>
	<script>
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();   
	});
	</script>