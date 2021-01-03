<?php
require_once '../../tools/warframe.php';
is_auth(7);
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

			<!-- Content area -->
			<div class="content">

				<ul class="nav nav-tabs nav-tabs-solid nav-justified rounded border-0">
					<li class="nav-item"><a href="#basic-justified-tab1" class="nav-link legitRipple active show" data-toggle="tab">1 Этаж</a></li>
					<li class="nav-item"><a href="#basic-justified-tab2" class="nav-link legitRipple" data-toggle="tab">2 Этаж</a></li>
					<li class="nav-item"><a href="#basic-justified-tab3" class="nav-link legitRipple" data-toggle="tab">3 Этаж</a></li>
				</ul>

				<div class="tab-content">

					<div class="tab-pane fade active show" id="basic-justified-tab1">
						<?php include 'tabs/floor_1.php' ?>
					</div>

					<div class="tab-pane fade" id="basic-justified-tab2">
						<?php include 'tabs/floor_2.php' ?>
					</div>

					<div class="tab-pane fade" id="basic-justified-tab3">
						<?php include 'tabs/floor_3.php' ?>
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
