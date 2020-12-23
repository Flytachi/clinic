<?php
require_once '../../../tools/warframe.php';
is_auth(7);
$header = "Пациент";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../layout/head.php' ?>
<script src="<?= stack("global_assets/js/plugins/visualization/echarts/echarts.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/charts/echarts/lines.js") ?>"></script>

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
						<?php
	 	   				include "content_tabs.php";

	 	   				if($_SESSION['message']){
	 	   					echo $_SESSION['message'];
	 	   					unset($_SESSION['message']);
	 	   				}
	 	   				?>

						<!-- Zoom option -->
						<div class="card border-1 border-warning">
							<div class="card-header header-elements-inline alpha-warning">
								<h5 class="card-title">Динамика показателей</h5>
								<div class="header-elements">
									<div class="list-icons">
										<a class="list-icons-item" data-action="collapse"></a>
									</div>
								</div>
							</div>

							<div class="card-body">
								<div class="chart-container">
									<div class="chart has-fixed-height" id="line_stat"></div>
								</div>
							</div>
						</div>
						<!-- /zoom option -->

						<div class="card">

							<div class="card-header header-elements-inline">
								<h5 class="card-title">Состояние</h5>
								<div class="header-elements">
									<div class="list-icons">
										<a class="list-icons-item text-success" data-toggle="modal" data-target="#modal_add">
											<i class="icon-plus22"></i>Добавить
										</a>
									</div>
								</div>
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
											<th>Дыхание</th>
											<th>Моча</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach ($db->query("SELECT * FROM user_stats WHERE visit_id=$patient->visit_id ORDER BY add_date DESC") as $row) {
											switch ($row['stat']):
												case 1:
													$stat = "Актив";
													$class_tr = "table-success";
													break;
												case 2:
													$stat = "Пассив";
													$class_tr = "table-danger";
													break;
												default:
													$stat = "Норма";
													$class_tr = "";
													break;
											endswitch;
											?>
											<tr class="<?= $class_tr ?> tolltip" data-popup="tooltip" title="<?= $row['description'] ?>">
												<td class="chart_date"><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
												<td><?= $stat ?></td>
												<td><?= get_full_name($row['parent_id']) ?></td>
												<td class="chart_pressure"><?= $row['pressure'] ?></td>
												<td class="chart_pulse"><?= $row['pulse'] ?></td>
												<td class="chart_temperature"><?= $row['temperature'] ?></td>
												<td class="chart_saturation"><?= $row['saturation'] ?></td>
												<td><?= $row['breath'] ?></td>
												<td><?= $row['urine'] ?></td>
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

	<div id="modal_add" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content border-3 border-info">
				<div class="modal-header bg-info">
					<h5 class="modal-title">Добавить примечание</h5>
					<button type="button" class="close" data-dismiss="modal">×</button>
				</div>

				<?= PatientStatsModel::form() ?>

			</div>
		</div>
	</div>

    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
