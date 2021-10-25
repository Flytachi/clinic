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

                <?php include 'bars/objects.php'; ?>
				<?php include 'bars/patients.php'; ?>
				<?php include 'bars/divisions.php'; ?>

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
