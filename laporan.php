<!DOCTYPE html>
<html lang="en">
<?php include('header.php'); 
$bulan = $tahun = $stat = '';

?>
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
						<legend>Laporan</legend>
					</div>
				</div>
				<div class="row well well-sm">
					<form action="ajaxlap.php" method="POST" class="form-horizontal" data-surat>
					<div class="col-md-12">
						<div class="col-md-4 col-xs-6">
							<div class="form-group">
							<label class="col-md-4 col-xs-4 text-right" for="tgl">Bln:</label>
							<div class="col-md-8 col-xs-8">
								<select class="form-control input-sm" name="bln" id="bln">
									<option selected="selected">Pilih Bulan</option>
									<?php 
										for ($i = 0; $i <= 11; ++$i) {
											$time = strtotime(sprintf('+%d months', $i));
											$value = date('m', $time);
											$label = date('F', $time);
											if ($bulan == ($i+1)) {
												printf('<option value="%s" selected="selected">%s</option>', $value, $label);
											} else {
												printf('<option value="%s">%s</option>', $value, $label);
											}
										}
										?>
								</select>
							</div>
							</div>
						</div>
						<div class="col-md-4 col-xs-6">
							<div class="form-group">
							<label for="tahun" class="col-md-4 col-xs-4 text-right">Tahun:</label>
							<div class="col-md-8 col-xs-8">
								<select name="tahun" id="tahun" class="form-control input-sm">
									<option selected="selected">Tahun</option>
									<?php 
										$sql="select year(tglentri) as tahun from tsurat group by tahun";
										$result = $db->query($sql);
										if ($result){
										while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
											if ($tahun ==  $row['tahun']){
												printf('<option value="%s" selected="selected">%s</option>', $row['tahun'], $row['tahun']);
											} else {
												printf('<option value="%s">%s</option>', $row['tahun'], $row['tahun']);
											}
										}
										}
									?>
								</select>
							</div>
							</div>
						</div>
						<div class="col-md-4 col-xs-6">
							<div class="form-group">
							<label for="stat" class="col-md-4 col-xs-4 text-right">Status:</label>
							<div class="col-md-8 col-xs-8">
								<select name="stat" id="stat" class="form-control input-sm">
									<option value="" selected="selected">Semua</option>
									<option value="0">Belum Disposisi</option>
									<option value="1">Sudah Disposisi</option>
								</select>
							</div>
							</div>
						</div>
						<div class="col-md-12 col-xs-6">
						<div class="form-group">
							<div class="col-md-3 col-md-offset-4 col-xs-8 col-xs-offset-4">
								<button type="submit" class="btn btn-primary btn-block"><span class="glyphicon glyphicon-eye-open"></span> Tampil</button> 
							</div>
						</div>
						</div>
					</div>
					</form>
				</div>
				<div class="row well well-sm">
					<div class="table-responsive" id="report">
					<!-- Report Result-->
					<b>Pilih bulan, tahun dan status lalu klik tampil</b>
					</div>
				</div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->
	
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
	
	<?php include('footer.php');?>

	<script>
	
	(function($) {
		$.fn.autosubmit = function() {
			this.submit(function(event) {
			  event.preventDefault();
			  var form = $(this);
			  $.ajax({
				type: form.attr('method'),
				url: form.attr('action'),
				data: form.serialize()
			  }).done(function(data) {
				// Optionally alert the user of success here...
				$("#report").html(data);
			  }).fail(function(data) {
				// Optionally alert the user of an error here...
			  });
			});
			return this;
		}
	})(jQuery)

	$(function() {
	  $('form[data-surat]').autosubmit();
	});
	
	function showdetail(noagd) {
		$.ajax({
		type:"post",
		url	:"ajaxdposisi.php",
		data:"noagd="+noagd,
		success:function(data){
			$("#detail").html(data);
			$('#Modaldetail').modal('show');
		}
		});
	}
	</script>
</body>

</html>
