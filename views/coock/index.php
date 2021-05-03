<?php
require_once '../../tools/warframe.php';
$session->is_auth(9);
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

				<div class="row">

					<?php foreach ($DIET_TIME as $time): ?>
						<div class="col-md-4">
							<div class="<?= $classes['card'] ?>">

								<div class="<?= $classes['card-header'] ?>">
									<h5 class="card-title"><?= $time ?></h5>
									<div class="header-elements">
										<button type="button" class="btn bg-blue btn-icon legitRipple"><i class="icon-cog2"></i></button>
										<button type="button" class="btn bg-success btn-icon ml-2 legitRipple"><i class="icon-task"></i></button>
									</div>
								</div>

								<div class="card-body">
									
								</div>

							</div>
						</div>
					<?php endforeach; ?>

				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->


	<!-- Footer -->
    <?php include '../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
