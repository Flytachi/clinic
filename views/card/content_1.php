<?php
require_once '../../tools/warframe.php';
$session->is_auth();
$header = "Пациент";
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

				<?php include "profile.php"; ?>

				<div class="card border-1 border-info">
				    <div class="card-header text-dark header-elements-inline alpha-info">
				        <h6 class="card-title">Просмотр визита</h6>
				    </div>

				    <div class="card-body">

						<?php
						include "content_tabs.php";
						if ($patient->direction) {
							$title = "Обход";
							$table_label = "Мед Услуга / Дата и время осмотра";
							if ($activity) {
								$table_sql = "SELECT vs.id, vs.report_title, sc.name, vs.completed, vs.service_id FROM visit vs LEFT JOIN service sc ON (vs.service_id = sc.id) WHERE vs.user_id = $patient->id AND vs.parent_id = {$_SESSION['session_id']} AND vs.accept_date IS NOT NULL AND vs.completed IS NULL";
							} else {
								if ($patient->completed) {
									$table_sql = "SELECT vs.id, vs.report_title, sc.name, vs.completed, vs.service_id FROM visit vs LEFT JOIN service sc ON (vs.service_id = sc.id)
													WHERE vs.user_id = $patient->id AND vs.parent_id = $patient->grant_id AND vs.accept_date IS NOT NULL AND service_id != 1 AND (DATE_FORMAT(vs.add_date, '%Y-%m-%d %H:%i:%s') BETWEEN \"$patient->add_date\" AND \"$patient->completed\")";
								} else {
									$table_sql = "SELECT vs.id, vs.report_title, sc.name, vs.completed, vs.service_id FROM visit vs LEFT JOIN service sc ON (vs.service_id = sc.id)
													WHERE vs.user_id = $patient->id AND vs.parent_id = $patient->grant_id AND vs.accept_date IS NOT NULL AND service_id != 1 AND (DATE_FORMAT(vs.add_date, '%Y-%m-%d %H:%i:%s') BETWEEN \"$patient->add_date\" AND \"CURRENT_TIMESTAMP()\")";
								}

							}

							$table_tr = "table-info";
						} else {
							$title = "Осмотр";
							$table_label = "Мед Услуга";
							$table_sql = "SELECT vs.id, vs.report_title, sc.name, vs.completed FROM visit vs LEFT JOIN service sc ON (vs.service_id = sc.id) WHERE vs.user_id = $patient->id AND vs.parent_id = {$_SESSION['session_id']} AND vs.accept_date IS NOT NULL AND vs.completed IS NULL";
							$table_tr = "";
						}
						?>

						<legend class="font-weight-semibold text-uppercase font-size-sm">
							<i class="icon-repo-forked mr-2"></i><?= $title ?>
							<?php if ($activity and $patient->direction and $patient->grant_id == $_SESSION['session_id']): ?>
								<a class="float-right text-info" data-toggle="modal" data-target="#modal_add_inspection">
									<i class="icon-plus22 mr-1"></i>Осмотр
								</a>
								<a class="float-right <?= $class_color_add ?> mr-2" data-toggle="modal" data-target="#modal_add_service">
									<i class="icon-plus22 mr-1"></i>Услуга
								</a>
							<?php endif; ?>
							<?php if ($activity and permission(5)): ?>
								<a href="#" class="float-right text-teal mr-2" data-toggle="modal" data-target="#modal_package">
									<i class="icon-bag mr-1"></i>Пакеты
								</a>
							<?php endif; ?>
						</legend>

						<div class="card">

							<div class="table-responsive">
								<table class="table table-hover table-sm">
									<thead>
										<tr class="bg-info">
											<th><?= $table_label ?></th>
											<?php if ($patient->direction): ?>
												<th>Врач</th>
											<?php endif; ?>
											<th class="text-right" style="width: 50%">Действия</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($db->query($table_sql) as $row): ?>
											<tr class="<?= ($row['service_id'] == 1) ? "table-warning" :$table_tr ?>">
												<td colspan="<?= ($patient->direction) ? 2 : 1 ?>"><?= $row['name'] ?></td>
												<td class="text-right">
													<?php if ($row['report_title']): ?>
														<?php if ($row['service_id'] == 1): ?>
															<button onclick="UpdateFinish('<?= up_url($row['id'], 'VisitReport') ?>')" type="button" class="btn btn-outline-danger btn-sm legitRipple">Выписка</button>
														<?php else: ?>
															<button onclick="Check('<?= viv('doctor/report') ?>?pk=<?= $row['id'] ?>')" type="button" class="btn btn-outline-info btn-sm legitRipple"><i class="icon-eye mr-2"></i> Просмотр</button>
															<?php if ($activity): ?>
																<button onclick="Update('<?= up_url($row['id'], 'VisitReport') ?>')" type="button" class="btn btn-outline-success btn-sm legitRipple">Редактировать</button>
															<?php endif; ?>
														<?php endif; ?>
													<?php else: ?>
														<?php if ($row['service_id'] == 1): ?>
															<button onclick="UpdateFinish('<?= up_url($row['id'], 'VisitReport') ?>')" type="button" class="btn btn-outline-danger btn-sm legitRipple">Выписка</button>
														<?php else: ?>
															<button onclick="Update('<?= up_url($row['id'], 'VisitReport') ?>')" type="button" class="btn btn-outline-success btn-sm legitRipple">Провести</button>
														<?php endif; ?>
													<?php endif; ?>
												</td>
											</tr>
										<?php endforeach; ?>

										<?php if ($patient->direction): ?>
											<?php foreach ($db->query("SELECT * FROM visit_inspection WHERE visit_id = $patient->visit_id ORDER BY add_date DESC") as $row): ?>
												<tr>
													<td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
													<td><?= get_full_name($row['parent_id']) ?></td>
													<td class="text-right">
														<button onclick="Check('<?= viv('doctor/inspection') ?>?pk=<?= $row['id'] ?>')" type="button" class="btn btn-outline-info btn-sm legitRipple"><i class="icon-eye mr-2"></i> Просмотр</button>
													</td>
												</tr>
											<?php endforeach; ?>
										<?php endif; ?>

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

	<?php if ($activity): ?>
		<div id="modal_report_add" class="modal fade" tabindex="-1">
			<div class="modal-dialog modal-lg" style="max-width: 1200px !important;">
				<div class="modal-content border-3 border-info" id="form_card">

					<?php // VisitReport::form(); ?>

				</div>
			</div>
		</div>

		<div id="modal_report_finish" class="modal fade" tabindex="-1">
			<div class="modal-dialog modal-lg" style="max-width: 1200px !important;">
				<div class="modal-content border-3 border-info" id="form_card_finish">

					<?php // VisitReport::form_finish(); ?>

				</div>
			</div>
		</div>

		<div id="modal_add_service" class="modal fade" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header bg-info">
						<h6 class="modal-title">Назначить услугу</h6>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<div class="modal-body">

						<?php VisitRoute::form_sta_doc() ?>

					</div>
				</div>
			</div>
		</div>

		<div id="modal_add_inspection" class="modal fade" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header bg-info">
						<h6 class="modal-title">Осмотр</h6>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<?php VisitInspectionModel::form() ?>

				</div>
			</div>
		</div>

		<div id="modal_package" class="modal fade" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header bg-info">
						<h6 class="modal-title">Назначить пакет</h6>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<?php VisitRoute::form_package() ?>

				</div>
			</div>
		</div>
	<?php endif; ?>

	<div id="modal_report_show" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-3 border-info" id="report_show">

			</div>
		</div>
	</div>

	<?php if ($activity): ?>
		<script type="text/javascript">

			function Update(events) {
				$.ajax({
					type: "GET",
					url: events,
					success: function (result) {
						$('#modal_report_add').modal('show');
						$('#form_card').html(result);
					},
				});
			};

			function UpdateFinish(events) {
				$.ajax({
					type: "GET",
					url: events,
					success: function (result) {
						$('#modal_report_finish').modal('show');
						$('#form_card_finish').html(result);
					},
				});
			};

		</script>
	<?php endif; ?>

	<script type="text/javascript">
		function Check(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#modal_report_show').modal('show');
					$('#report_show').html(result);
				},
			});
		};

	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
