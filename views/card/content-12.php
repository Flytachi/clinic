<?php
require_once 'callback.php';
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>
<script src="<?= stack("global_assets/js/plugins/visualization/echarts/echarts.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/charts/echarts/lines.js") ?>"></script>

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

				<?php include "profile.php"; ?>

				<div class="<?= $classes['card'] ?>">
				    <div class="<?= $classes['card-header'] ?>">
				        <h6 class="card-title">Просмотр визита</h6>
				    </div>

				    <div class="card-body">

				        <?php include "content_tabs.php"; ?>

						<!-- Zoom option -->
						<legend class="font-weight-semibold text-uppercase font-size-sm">
							<i class="icon-pulse2 mr-2"></i>Динамика показателей
						</legend>

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

						<legend class="font-weight-semibold text-uppercase font-size-sm">
							<i class="icon-clipboard2 mr-2"></i>Состояние
							<?php if ($activity and permission(7)): ?>
								<a onclick='Update(`<?= up_url($patient->visit_id, "VisitStatsModel") ?>`)' class="float-right text-primary">
									<i class="icon-plus22 mr-1"></i>Добавить
								</a>
							<?php endif; ?>
						</legend>

						<div class="card">

							<div class="table-responsive">
								<table class="table table-hover table-sm">
									<thead class="<?= $classes['table-thead'] ?>">
										<tr>
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
										$tb = new Table($db, "visit_stats");
										$tb->where("visit_id = $patient->visit_id")->order_by('add_date DESC');
										?>
										<?php foreach ($tb->get_table() as $row): ?>
											<?php
											switch ($row->stat):
												case 1:
													$stat = "Пассив";
													$class_tr = "table-danger";
													break;
												default:
													$stat = "Актив";
													$class_tr = "table-success";
													break;
											endswitch;	
											?>
											<tr class="<?= $class_tr ?> tolltip" data-popup="tooltip" title="<?= $row->description ?>">
												<td class="chart_date"><?= date_f($row->add_date, 1) ?></td>
												<td><?= $stat ?></td>
												<td><?= get_full_name($row->parent_id) ?></td>
												<td class="chart_pressure"><?= $row->pressure ?></td>
												<td class="chart_pulse"><?= $row->pulse ?></td>
												<td class="chart_temperature"><?= $row->temperature ?></td>
												<td class="chart_saturation"><?= $row->saturation ?></td>
												<td><?= $row->breath ?></td>
												<td><?= $row->urine ?></td>
											</tr>
										<?php endforeach; ?>
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

	<?php if ($activity and permission(7)): ?>

		<div id="modal_default" class="modal fade" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="<?= $classes['modal-global_content'] ?>" id="form_card"></div>
			</div>
		</div>

		<script type="text/javascript">

			function Update(events) {
				$.ajax({
					type: "GET",
					url: events,
					success: function (result) {
						$('#modal_default').modal('show');
						$('#form_card').html(result);
					},
				});
			};

		</script>
		
	<?php endif; ?>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
