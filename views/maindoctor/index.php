<?php
require_once '../../tools/warframe.php';
$session->is_auth(8);
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

			<script src="<?= stack("global_assets/js/demo_pages/dashboard.js") ?>"></script>

			<!-- Content area -->
			<div class="content">

				<div id="barObjects">
					<div class="text-muted text-center">Loading...</div>
				</div>
				<div id="barPatients">
					<div class="text-muted text-center">Loading...</div>
				</div>
				<div id="barDivisions">
					<div class="text-muted text-center">Loading...</div>
				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<script>
		$(document).ready(() => {
			$.ajax({
				type: "GET",
				url: "<?= viv('maindoctor/bars/objects') ?>",
				success: function (response) {
					$("#barObjects").html(response);
					StatisticWidgets.init();

					$.ajax({
						type: "GET",
						url: "<?= viv('maindoctor/bars/patients') ?>",
						success: function (response) {
							$("#barPatients").html(response);
							$.ajax({
								type: "GET",
								url: "<?= viv('maindoctor/bars/divisions') ?>",
								success: function (response) {
									$("#barDivisions").html(response);
								},
							});
						},
					});
				},
			});

		});
	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
