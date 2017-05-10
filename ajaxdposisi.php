<?php
include('dbconfig.php');
include('session.php');

if (isset($_POST['noagd'])){
	$noagd = $_POST['noagd'];
	$sql="SELECT tdposisi.tgldposisi, tdposisi.dposisi, tdari.satker as dari, ttuju.satker as tujuan 
		FROM tdposisi 
		LEFT JOIN tsatker as tdari on tdposisi.dari=tdari.id 
		LEFT JOIN tsatker as ttuju on tdposisi.tujuan=ttuju.id
		WHERE noagenda='$noagd'";
	$result=$db->query($sql);
	if ($db->affected_rows > 0) {
		echo "<table class='table table-striped'>";
		echo "<tr>";
		echo "<th>Tanggal</th>";
		echo "<th>Asal Dari</th>";
		echo "<th>Tujuan</th>";
		echo "<th>Disposisi</th>";
		echo "</tr>";
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			echo "<tr>";
			echo "<td>".$row['tgldposisi']."</td>";
			echo "<td>".$row['dari']."</td>";
			echo "<td>".$row['tujuan']."</td>";
			echo "<td>".$row['dposisi']."</td>";
			echo "</tr>";
		}
		echo "</table>";
		//print_f $array;
		//echo json_encode($array);
	} 	
}
?>