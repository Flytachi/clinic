<?php
require_once '../../../tools/warframe.php';
is_auth(11);
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
																<button type="button" onclick="Show_info('<?= viv('doctor/operation_info') ?>?pk=<?= $row['id'] ?>&type=0')" class="btn btn-outline-warning btn-sm">До</button>
																<button type="button" onclick="Show_info('<?= viv('doctor/operation_info') ?>?pk=<?= $row['id'] ?>&type=1')" class="btn btn-outline-success btn-sm">После</button>
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
	</script>

    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
