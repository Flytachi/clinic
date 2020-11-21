<?php
require_once '../../../tools/warframe.php';
is_auth(5);
$header = "Пациент";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../layout/head.php' ?>

<body>
	<!-- Main navbar -->
	<?php include '../../layout/navbar.php' ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">
		<!-- Main sidebar -->
		<?php include '../../layout/sidebar.php' ?>
		<!-- /main sidebar -->

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

				<?php include "profile.php"; ?>

				<div class="card border-1 border-info">
				    <div class="card-header text-dark header-elements-inline alpha-info">
				        <h6 class="card-title">Просмотр визита</h6>
				    </div>

				    <div class="card-body">

				        <?php include "content_tabs.php"; ?>

						<div class="card">

							<div class="card-header header-elements-inline">
								<h5 class="card-title">Состояние</h5>
							</div>

							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr class="bg-info">
											<th>Дата и время</th>
											<th>Состояние пациента</th>
											<th>Медсестра ФИО</th>
											<th>давление</th>
											<th>Пульс</th>
											<th>Температура</th>

										</tr>
									</thead>
									<tbody>
										<tr>
											<td>13.03.2020 13:04</td>
											<td>Хорошо</td>
											<td>Ахмедова З</td>
										</tr>
									</tbody>
								</table>
							</div>

						</div>

				    </div>

				    <!-- /content wrapper -->
				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->

    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
