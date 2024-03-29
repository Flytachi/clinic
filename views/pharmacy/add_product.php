<?php
require_once '../../tools/warframe.php';
$session->is_auth(4);
$header = "Добавить препарат";
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

				<div class="card border-1 border-info">

					<div class="card-header text-dark header-elements-inline alpha-info">
						<h6 class="card-title">Добавить препарат</h6>
					</div>

					<div class="card-body">

						<?php Storage::form() ?>

					</div>

				</div>

				<div class="card border-1 border-info">

					<div class="card-header text-dark header-elements-inline alpha-info">
						<h6 class="card-title">Шаблон</h6>
						<div class="header-elements">
	                  		<div class="list-icons">
								<a href="<?= download_url('Storage', 'Препараты', true) ?>" class="btn">Лист поступления</a>
		                  	</div>
		              	</div>
					</div>

					<div class="card-body">

						<?php Storage::form_template() ?>

					</div>

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
