<?php
require_once '../../tools/warframe.php';
$session->is_auth(8);
$header = "Рабочий стол";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<!-- Theme JS files -->
<script src="<?= stack("global_assets/js/demo_pages/widgets_stats.js") ?>"></script>
<script src="<?= stack("vendors/js/jquery.chained.js") ?>"></script>
<!-- /theme JS files -->

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

                		<?php 
				$registrators = [];
				$regData = $db->query("SELECT id FROM users WHERE user_level IN (2, 32)")->fetchAll();
				foreach ($regData as $arr_users) $registrators[] = $arr_users['id'];

				//include 'bars/bar_1.php';
				// include 'bars/bar_2.php';
				include 'bars/bar_3.php';
				?>

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
