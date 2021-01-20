<?php
require_once '../../../tools/warframe.php';
is_auth([5,8]);
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
				        <?php include "content_tabs.php"; ?>

						<div class="row">

							<div class="col-md-12">

								<div class="card">

									<div class="card-header header-elements-inline">
										<h5 class="card-title">Операционный блок</h5>
										<?php if ($patient->direction and $patient->grant_id == $_SESSION['session_id']): ?>
											<div class="header-elements">
												<div class="list-icons">
													<a class="list-icons-item <?= $class_color_add ?>" data-toggle="modal" data-target="#modal_add_operation">
														<i class="icon-plus22"></i>Добавить
													</a>
												</div>
											</div>
										<?php endif; ?>
									</div>

									<div class="table-responsive">
										<table class="table table-hover table-sm">
											<thead>
												<tr class="bg-info">
						                            <th>Операция</th>
													<th>Оператор</th>
													<th style="width: 12%;">Дата назначения</th>
													<th style="width: 12%;">Дата операции</th>
													<th style="width: 12%;">Дата завершения</th>
													<th class="text-right">Действия</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($db->query("SELECT op.id, sc.name, op.parent_id, op.add_date, op.oper_date, op.completed FROM operation op LEFT JOIN service sc ON(sc.id=op.service_id) WHERE op.visit_id = $patient->visit_id AND op.user_id = $patient->id") as $row): ?>
													<tr>
														<td><?= $row['name'] ?></td>
														<td><?= get_full_name($row['parent_id']) ?></td>
														<td><?= ($row['add_date']) ? date('d.m.Y H:i', strtotime($row['add_date'])) : '<span class="text-muted">Нет данных</span>' ?></td>
														<?php if (!$row['completed'] and $patient->grant_id == $_SESSION['session_id']): ?>
															<td class="text-primary" onclick="Oper_date('<?= $row['id'] ?>', '<?= date('Y-m-d', strtotime($row['oper_date'])) ?>', '<?= date('H:i', strtotime($row['oper_date'])) ?>')">
																<?= ($row['oper_date']) ? date('d.m.Y H:i', strtotime($row['oper_date'])) : '<span class="text-muted">Нет данных</span>' ?>
															</td>
														<?php else: ?>
															<td><?= ($row['oper_date']) ? date('d.m.Y H:i', strtotime($row['oper_date'])) : '<span class="text-muted">Нет данных</span>' ?></td>
														<?php endif; ?>
														<td><?= ($row['completed']) ? date('d.m.Y H:i', strtotime($row['completed'])) : '<span class="text-muted">Нет данных</span>' ?></td>
														<td class="text-right">
															<?php if ($row['completed']): ?>
																<button type="button" onclick="Show_info('<?= viv('doctor/operation_info') ?>?pk=<?= $row['id'] ?>')" class="btn btn-outline-primary btn-sm">До</button>
																<button type="button" class="btn btn-outline-primary btn-sm">После</button>
															<?php else: ?>
																<button type="button" onclick="Show_info('<?= viv('doctor/operation_info') ?>?pk=<?= $row['id'] ?>')" class="btn btn-outline-primary btn-sm">Информация</button>
																<?php if ($patient->grant_id == $_SESSION['session_id'] and strtotime($row['oper_date']) <= strtotime(date('Y-m-d H:i'))): ?>
																	<a href="<?= up_url($row['id'], 'OperationModel') ?>&finish=1" class="btn btn-outline-success btn-sm">Завершить</a>
																<?php endif; ?>
															<?php endif; ?>
														</td>
													</tr>
												<?php endforeach; ?>
											</tbody>
										</table>
									</div>

								</div>

							</div>

						</div>

						<div class="row" id="content_data">

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

	<div id="modal_add_operation" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-3 border-info">
				<div class="modal-header bg-info">
					<h5 class="modal-title">Назначить операцию</h5>
					<button type="button" class="close" data-dismiss="modal">×</button>
				</div>

				<div class="modal-body">
					<?= OperationModel::form() ?>
				</div>

			</div>
		</div>
	</div>

	<div id="modal_oper_date" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-md">
			<div class="modal-content border-3 border-info">
				<div class="modal-header bg-info">
					<h5 class="modal-title">Переназначить дату операций</h5>
					<button type="button" class="close" data-dismiss="modal">×</button>
				</div>

				<form method="post" action="<?= add_url() ?>">
					<input type="hidden" name="model" value="OperationModel">
					<input type="hidden" name="id" id="oper_id">

					<div class="modal-body">

						<div class="form-group row">
							<div class="col-md-6">
								<label>Дата:</label>
								<input type="date" class="form-control" name="oper_date" id="oper_date">
							</div>

							<div class="col-md-6">
								<label>Время:</label>
								<input type="time" class="form-control" name="oper_time" id="oper_time">
							</div>
						</div>

					</div>

					<div class="modal-footer">
						<button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
					</div>

				</form>

			</div>
		</div>
	</div>

	<script type="text/javascript">
		function Show_info(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#content_data').html(result);
					EchartsLines.init();
				},
			});
		};

		function Oper_date(pk, date, time) {
			$('#modal_oper_date').modal('show');
			$('#oper_id').val(pk);
			$('#oper_date').val(date);
			$('#oper_time').val(time);
		};
	</script>

    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
