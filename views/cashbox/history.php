<?php
require_once '../../tools/warframe.php';
is_auth(3);
$header = "Рабочий стол";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>

<body>

	<!-- Main navbar -->
	<?php include '../layout/navbar.php' ?>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include '../layout/sidebar.php' ?>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

				<ul class="nav nav-tabs nav-tabs-highlight nav-justified">
					<li class="nav-item"><a href="#highlighted-tab3" class="nav-link active" data-toggle="tab">История платежей</a></li>
					<li class="nav-item"><a href="#highlighted-tab4" class="nav-link" data-toggle="tab">Возврат</a></li>
				</ul>

				<!-- Highlighted tabs -->
				<div class="tab-content">

					<div class="tab-pane fade show active" id="highlighted-tab3">
						<?php
							include 'tabs/kassa_3.php';
						?>
					</div>

					<div class="tab-pane fade" id="highlighted-tab4">
						<?php
							include 'tabs/kassa_4.php';
						?>
					</div>

				</div>
				<!-- /highlighted tabs -->

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
