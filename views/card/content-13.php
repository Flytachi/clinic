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

						<legend class="font-weight-semibold text-uppercase font-size-sm">
							<i class="icon-bed2 mr-2"></i>Операционный блок
							<?php if ($activity and $patient->direction and is_grant()): ?>
								<a onclick='Update(`<?= up_url(null, "VisitOperationsModel") ?>&patient=<?= json_encode($patient) ?>`)' class="float-right <?= $class_color_add ?>">
									<i class="icon-plus22 mr-1"></i>Добавить
								</a>
							<?php endif; ?>
						</legend>

						<div class="card">

							<div class="table-responsive">
								<table class="table table-hover table-sm">
									<thead class="<?= $classes['table-thead'] ?>">
										<tr>
											<th>Операция</th>
											<th style="width: 12%;">Дата назначения</th>
											<th style="width: 12%;">Дата операции</th>
											<th style="width: 12%;">Дата завершения</th>
											<th class="text-right">Действия</th>
										</tr>
									</thead>
									<tbody>
									<?php
										$tb = new Table($db, "visit_operations");
										$tb->where("visit_id = $patient->visit_id")->order_by('add_date ASC');
										?>
										<?php foreach ($tb->get_table() as $row): ?>
											<tr>
												<td><?= $row->operation_name ?></td>
												<td><?= ($row->add_date) ? date_f($row->add_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
												<?php if (!$row->completed and is_grant()): ?>
													<td class="text-primary" onclick='Update(`<?= up_url($row->id, "VisitOperationsModel", "form_operation_date") ?>`)'>
														<?= ($row->operation_date) ? date_f("$row->operation_date $row->operation_time", 1) : '<span class="text-muted">Нет данных</span>' ?>
													</td>
												<?php else: ?>
													<td><?= ($row->operation_date) ? date_f("$row->operation_date $row->operation_time", 1) : '<span class="text-muted">Нет данных</span>' ?></td>
												<?php endif; ?>
												<td><?= ($row->operation_end_date) ? date_f("$row->operation_end_date $row->operation_end_time", 1) : '<span class="text-muted">Нет данных</span>' ?></td>
												<td class="text-right">
													<?php if ($row->completed): ?>
														<button type="button" onclick='Show_info(`<?= viv("card/operation_info") ?>?pk=<?= $row->id ?>&patient=<?= json_encode($patient) ?>&activity=<?= $activity ?>&type=0`)' class="btn btn-outline-warning btn-sm">До</button>
														<button type="button" onclick='Show_info(`<?= viv("card/operation_info") ?>?pk=<?= $row->id ?>&patient=<?= json_encode($patient) ?>&activity=<?= $activity ?>&type=1`)' class="btn btn-outline-success btn-sm">После</button>
													<?php else: ?>
														<button type="button" onclick='Show_info(`<?= viv("card/operation_info") ?>?pk=<?= $row->id ?>&patient=<?= json_encode($patient) ?>&activity=<?= $activity ?>`)' class="btn btn-outline-primary btn-sm">Информация</button>
													<?php endif; ?>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>

						</div>

						<div class="row" id="content_data"></div>

				    </div>

				    <!-- /content wrapper -->
				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->

	<?php if ($activity): ?>
		<div id="modal_default" class="modal fade" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="<?= $classes['modal-global_content'] ?>" id="form_card"></div>
			</div>
		</div>
	<?php endif; ?>

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

		function Show_info(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#content_data').html(result);
					title_data_url = events;
					EchartsLines.init();
				},
			});
		};
	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
