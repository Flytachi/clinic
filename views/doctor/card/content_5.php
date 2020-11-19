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

						<h4 class="card-title">Анализ Пациента</h4>
						<div class="card">
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr class="bg-blue text-center">
											<th>№</th>
											<th>Специалист</th>
											<th>Дата и время</th>
											<th>Услуга</th>
											<th>Анализ</th>
											<th>Результаты</th>
											<th>Норматив</th>
											<th>Примечание</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$i = 1;
										foreach ($db->query("SELECT vs.parent_id, vs.completed, sr.name 'service_name', lat.name, lat.standart, la.result, la.description FROM laboratory_analyze la LEFT JOIN laboratory_analyze_type lat ON (lat.id=la.analyze_id) LEFT JOIN visit vs ON (vs.id=la.visit_id) LEFT JOIN service sr ON (sr.id=lat.service_id) WHERE la.user_id = $patient->user_id ORDER BY la.id DESC") as $row) {
										?>
											<tr class="text-center">
												<td><?= $i++ ?></td>
												<td><?= get_full_name($row['parent_id']) ?></td>
												<td><?= date('d.m.Y H:i', strtotime($row['completed'])) ?></td>
												<td><?= $row['service_name'] ?></td>
												<td><?= $row['name'] ?></td>
												<td><?= $row['result'] ?></td>
												<td><?= $row['standart'] ?></td>
												<td><?= $row['description'] ?></td>
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
