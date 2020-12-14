<?php
require_once '../../tools/warframe.php';
is_auth(2);
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

			<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js") ?>"></script>
			<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js") ?>"></script>

			<script src="<?= stack("global_assets/js/demo_pages/widgets_stats.js") ?>"></script>
			<script src="<?= stack("global_assets/js/demo_pages/form_inputs.js") ?>"></script>
			<script src="<?= stack("global_assets/js/demo_pages/form_layouts.js") ?>"></script>
			<script src="<?= stack("global_assets/js/demo_pages/form_select2.js") ?>"></script>

			<!-- Content area -->
			<div class="content">

				<?php include 'tabs.php' ?>

				<div class="card border-1 border-info">

					<div class="card-header text-dark header-elements-inline alpha-info">
						<h6 class="card-title">Стационарная</h6>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                	</div>
	                	</div>
					</div>

					<div class="card-body">
						<?php VisitModel::form_sta(); ?>
					</div>

				</div>

				<div class="row">
					<div class="col-sm-6 col-xl-3">

						<!-- Invitation stats colored -->
						<div class="card text-center bg-blue-400 has-bg-image">
							<div class="card-body">
								<h6 class="font-weight-semibold mb-0 mt-1">Информация о койках</h6>
								<div class="opacity-75 mb-3">свободно</div>
								<div class="svg-center position-relative mb-1" id="progress_percentage_one"></div>
							</div>

							<div class="card-body border-top-0 pt-0">
								<div class="row">
									<div class="col-4">
										<div class="text-uppercase font-size-xs">Все</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_one_all">
											<?= $db->query("SELECT id FROM beds")->rowCount() ?>
										</h5>
									</div>

									<div class="col-4">
										<div class="text-uppercase font-size-xs">Свободные</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_one_open">
											<?= $db->query("SELECT id FROM beds WHERE user_id IS NULL")->rowCount() ?>
										</h5>
									</div>

									<div class="col-4">
										<div class="text-uppercase font-size-xs">Занятые</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_one_close">
											<?= $db->query("SELECT id FROM beds WHERE user_id IS NOT NULL")->rowCount() ?>
										</h5>
									</div>
								</div>
							</div>
						</div>
						<!-- /invitation stats colored -->

					</div>

					<div class="col-sm-6 col-xl-3">

						<!-- Invitation stats white -->
						<div class="card text-center">
							<div class="card-body">
								<h6 class="font-weight-semibold mb-0 mt-1">1 Этаж</h6>
								<div class="text-muted mb-3">свободно</div>
								<div class="svg-center position-relative mb-1" id="progress_percentage_two"></div>
							</div>

							<div class="card-body border-top-0 pt-0">
								<div class="row">
									<div class="col-4">
										<div class="text-uppercase font-size-xs">Все</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_two_all">
											<?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = 1")->rowCount() ?>
										</h5>
									</div>

									<div class="col-4">
										<div class="text-uppercase font-size-xs">Свободные</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_two_open">
											<?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = 1 AND user_id IS NULL")->rowCount() ?>
										</h5>
									</div>

									<div class="col-4">
										<div class="text-uppercase font-size-xs">Занятые</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_two_close">
											<?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = 1 AND user_id IS NOT NULL")->rowCount() ?>
										</h5>
									</div>
								</div>
							</div>
						</div>
						<!-- /invitation stats white -->

					</div>

					<div class="col-sm-6 col-xl-3">

						<!-- Tickets stats white -->
						<div class="card text-center">
							<div class="card-body">
								<h6 class="font-weight-semibold mb-0 mt-1">2 Этаж</h6>
								<div class="text-muted mb-3">свободно</div>
								<div class="svg-center position-relative mb-1" id="progress_percentage_three"></div>
							</div>

							<div class="card-body border-top-0 pt-0">
								<div class="row">
									<div class="col-4">
										<div class="text-uppercase font-size-xs">Все</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_three_all">
											<?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = 2")->rowCount() ?>
										</h5>
									</div>

									<div class="col-4">
										<div class="text-uppercase font-size-xs">Свободные</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_three_open">
											<?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = 2 AND user_id IS NULL")->rowCount() ?>
										</h5>
									</div>

									<div class="col-4">
										<div class="text-uppercase font-size-xs">Занятые</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_three_close">
											<?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = 2 AND user_id IS NOT NULL")->rowCount() ?>
										</h5>
									</div>
								</div>
							</div>
						</div>
						<!-- /tickets stats white -->

					</div>

					<div class="col-sm-6 col-xl-3">

						<!-- Tickets stats colored -->
						<div class="card text-center">
							<div class="card-body">
								<h6 class="font-weight-semibold mb-0 mt-1">3 Этаж</h6>
								<div class="text-muted mb-3">свободно</div>
								<div class="svg-center position-relative mb-1" id="progress_percentage_four"></div>
							</div>

							<div class="card-body border-top-0 pt-0">
								<div class="row">
									<div class="col-4">
										<div class="text-uppercase font-size-xs">Все</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_four_all">
											<?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = 3")->rowCount() ?>
										</h5>
									</div>

									<div class="col-4">
										<div class="text-uppercase font-size-xs">Свободные</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_four_open">
											<?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = 3 AND user_id IS NULL")->rowCount() ?>
										</h5>
									</div>

									<div class="col-4">
										<div class="text-uppercase font-size-xs">Занятые</div>
										<h5 class="font-weight-semibold line-height-1 mt-1 mb-0" id="progress_percentage_four_close">
											<?= $db->query("SELECT bd.id FROM beds bd LEFT JOIN wards wd ON(bd.ward_id=wd.id) WHERE wd.floor = 3 AND user_id IS NOT NULL")->rowCount() ?>
										</h5>
									</div>
								</div>
							</div>
						</div>
						<!-- /tickets stats colored -->

					</div>
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
