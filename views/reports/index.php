<?php
require_once '../../tools/warframe.php';
$session->is_auth();
$header = "Отчёты";
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
					<div class="<?= $classes['card-header'] ?>">
						<h5 class="card-title">Отчёты</h5>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-sm-6 col-lg-3">

								<div class="mb-3">
									<h6 class="font-weight-semibold">Регистратура</h6>
									<ul class="list list-unstyled">
										<li><a href="<?= viv('reports/registry/content_1') ?>">Отчёт по областям</a></li>
									</ul>
								</div>
								<div class="mb-3">
									<h6 class="font-weight-semibold">Касса</h6>
									<ul class="list list-unstyled">
										<li><a href="<?= viv('reports/cashbox/content_1') ?>">Отчет по платежам</a></li>
									</ul>
								</div>

								<div class="mb-3">
									<h6 class="font-weight-semibold">Врачи</h6>
									<ul class="list list-unstyled">
										<li><a href="<?= viv('reports/doctor/content_1') ?>">Отчет по услугам</a></li>
									</ul>
								</div>
								<div class="mb-3">
									<h6 class="font-weight-semibold">Лаборатория</h6>
									<ul class="list list-unstyled">
										<li><a href="<?= viv('reports/laboratory/content_1') ?>">Отчет по услугам</a></li>
									</ul>
								</div>
								<div class="mb-3">
									<h6 class="font-weight-semibold">Диагностика</h6>
									<ul class="list list-unstyled">
										<li><a href="<?= viv('reports/diagnostic/content_1') ?>">Отчет по услугам</a></li>
									</ul>
								</div>
								<div class="mb-3">
									<h6 class="font-weight-semibold">Физиотерапия</h6>
									<ul class="list list-unstyled">
										<li><a href="<?= viv('reports/physio/content_1') ?>">Отчет по услугам</a></li>
									</ul>
								</div>

							</div>
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
