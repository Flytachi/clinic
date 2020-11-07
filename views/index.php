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
                switch (level()):
                    case 1:
                        include('docs/index/admin.php');
                        break;
					case 2:
						include('docs/index/registratura.php');
						break;
					case 4:
						include('docs/index/kassa.php');
						break;
					case 5:
						include('docs/index/anestiziolog.php');
						break;
					case 6:
						include('docs/index/laboratory.php');
						break;
					case 7:
                        include('docs/index/ambulator.php');
                        break;
                    case 8:
                        include('docs/index/nurse.php');
                        break;
                endswitch;
                ?>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->


    <!-- Footer -->

    <?php include 'layout/footer.php' ?>

    <!-- /footer -->

</body>
</html>
