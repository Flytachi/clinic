<?php

use Mixin\Hell;

require_once '../../tools/warframe.php';
$session->is_auth(24);
is_module('pharmacy');

if ( isset($_GET['pk']) and is_numeric($_GET['pk'])) {
	$supply = (new WarehouseSupplyModel)->Data("responsible_id, uniq_key")->byId($_GET['pk']);
	$form = new WarehouseSupplyModel;
	$_GET['form'] = 'table';
	$header = "Аптека / Поставка $supply->uniq_key";
}else Hell::error('404');
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

				<div class="<?= $classes['card'] ?>">

					<?php $form->get_or_404($_GET['pk']) ?>

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