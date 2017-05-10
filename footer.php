<!-- jQuery Js -->
	<script src="assets/js/jquery-2.2.4.min.js"></script>
<!-- jQuery ui -->
	<script src="assets/js/jquery-ui-1.12.1.min.js"></script>
<!-- Bootstrap -->
    <script src="assets/js/bootstrap.min.js"></script>
<!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
<!-- Tooltip -->
	<script>
		$(document).ready(function(){
			$('[data-toggle="tooltip"]').tooltip();   
		});
		
		$(document).ajaxStart(function ()
		{
			$('body').addClass('wait');

		}).ajaxComplete(function () {

			$('body').removeClass('wait');

		});

	</script>