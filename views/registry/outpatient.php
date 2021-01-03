<?php
require_once '../../tools/warframe.php';
is_auth(2);
$header = "Рабочий стол";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<body>
	<!-- Main navbar -->
	<?php include layout('navbar') ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">
		<!-- Main sidebar -->
		<?php include layout('sidebar') ?>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include layout('header') ?>
			<!-- /page header -->

			<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js") ?>"></script>
			<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js") ?>"></script>

			<script src="<?= stack("global_assets/js/demo_pages/form_inputs.js") ?>"></script>
			<script src="<?= stack("global_assets/js/demo_pages/form_layouts.js") ?>"></script>
			<script src="<?= stack("global_assets/js/demo_pages/form_select2.js") ?>"></script>

			<!-- Content area -->
			<div class="content">

				<?php include 'tabs.php' ?>

				<div class="card border-1 border-info">

					<div class="card-header text-dark header-elements-inline alpha-info">
						<h6 class="card-title">Амбулаторная</h6>
						<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                	</div>
	                	</div>
					</div>

					<div class="card-body">
						<?php VisitModel::form_out(); ?>
					</div>

				</div>


			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->


	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
