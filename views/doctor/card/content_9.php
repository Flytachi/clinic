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
								<table class="table table-hover">
									<thead>
										<tr class="bg-info">
											<th>Дата и время</th>
											<th>Состояние пациента</th>
											<th>Медсестра ФИО</th>
											<th>Давление</th>
											<th>Пульс</th>
											<th>Температура</th>
											<th>Сатурация</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($db->query("SELECT * FROM user_stats WHERE visit_id=$patient->visit_id") as $row) {
											?>
											<tr>
												<td><?= date('d.m.Y  H:i', strtotime($row['add_date'])) ?></td>
												<td>
													<?php
													switch ($row['stat']) {
														case 1:
															echo "Актив";
															break;
														case 2:
															echo "Пассив";
															break;
														default:
															echo "Норма";
															break;
													}
													?>
												</td>
												<td><?= get_full_name($row['parent_id']) ?></td>
												<td><?= $row['pressure'] ?></td>
												<td><?= $row['pulse'] ?></td>
												<td><?= $row['temperature'] ?></td>
												<td><?= $row['saturation'] ?></td>
											</tr>
											<?php
										}
										?>
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
