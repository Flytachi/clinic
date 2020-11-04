<?php
require_once 'tools/warframe.php';
is_auth();
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'layout/head.php' ?>

<body>

	<!-- Main navbar -->
	<?php include 'layout/navbar.php' ?>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include 'layout/sidebar.php' ?>
		<!-- /main sidebar -->


		<!-- Main content -->

		<div class="content-wrapper">
			<!-- Content area -->
			<div class="content">

				<?php
				if(permission(1)){
					include('docs/admin.php');
				}elseif (permission(2)) {
					include('docs/registratura.php');
				}
				?>

			</div>
            <!-- /content area -->
            
		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->


    <!-- Footer -->

    <script src="../vendors/js/cookie.js"></script>
    <script src="../vendors/js/Timer.js"></script>

    <?php include 'layout/footer.php' ?>
  
    <!-- /footer -->

</body>
</html>
