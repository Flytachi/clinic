<?php
require_once '../../tools/warframe.php';
is_auth();
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
								$table_sql = "SELECT vs.id, vs.report_description, sc.name, vs.completed, vs.service_id FROM visit vs LEFT JOIN service sc ON (vs.service_id = sc.id) WHERE vs.user_id = $patient->id AND vs.parent_id = $patient->grant_id AND vs.accept_date IS NOT NULL AND vs.completed IS NULL";
							} else {
								$table_sql = "SELECT vs.id, vs.report_description, sc.name, vs.completed, vs.service_id FROM visit vs LEFT JOIN service sc ON (vs.service_id = sc.id) WHERE vs.user_id = $patient->id AND vs.parent_id = $patient->grant_id AND vs.accept_date IS NOT NULL AND service_id != 1";
							}

							$table_tr = "table-info";
						} else {
							$title = "Осмотр";
							$table_label = "Мед Услуга";
							$table_sql = "SELECT vs.id, vs.report_description, sc.name, vs.completed FROM visit vs LEFT JOIN service sc ON (vs.service_id = sc.id) WHERE vs.user_id = $patient->id AND vs.parent_id = $patient->grant_id AND vs.accept_date IS NOT NULL AND vs.completed IS NULL";
							$table_tr = "";
						}
						?>

						<div class="card">

							<div class="card-header header-elements-inline">
								<h5 class="card-title"><?= $title ?></h5>
								<?php if ($activity): ?>
									<?php if ($patient->direction and $patient->grant_id == $_SESSION['session_id']): ?>
										<div class="header-elements">
											<div class="list-icons">
												<a class="list-icons-item <?= $class_color_add ?> mr-3" data-toggle="modal" data-target="#modal_add_service">
													<i class="icon-plus22"></i>Услуга
												</a>
												<a class="list-icons-item text-info mr-1" data-toggle="modal" data-target="#modal_add_inspection">
													<i class="icon-plus22"></i>Осмотр
												</a>
											</div>
										</div>
									<?php endif; ?>
								<?php endif; ?>
							</div>

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
													<?php if ($row['report_description']): ?>
														<?php if ($row['service_id'] == 1): ?>
															<button onclick="UpdateFinish('<?= up_url($row['id'], 'VisitReport') ?>')" type="button" class="btn btn-outline-success btn-sm legitRipple">Редактировать</button>
														<?php else: ?>
															<button onclick="Check('<?= viv('doctor/report') ?>?pk=<?= $row['id'] ?>')" type="button" class="btn btn-outline-info btn-sm legitRipple"><i class="icon-eye mr-2"></i> Просмотр</button>
															<?php if ($activity): ?>
																<button onclick="Update('<?= up_url($row['id'], 'VisitReport') ?>')" type="button" class="btn btn-outline-success btn-sm legitRipple">Редактировать</button>
															<?php endif; ?>
														<?php endif; ?>
													<?php else: ?>
														<?php if ($row['service_id'] == 1): ?>
															<button onclick="CleanFormFinish('<?= $row['id'] ?>', '<?= $row['name'] ?>')" type="button" class="btn btn-outline-info btn-sm legitRipple">Дополнить</button>
														<?php else: ?>
															<button onclick="CleanForm('<?= $row['id'] ?>', '<?= $row['name'] ?>')" type="button" class="btn btn-outline-success btn-sm legitRipple">Провести</button>
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
			<div class="modal-dialog modal-lg">
				<div class="modal-content border-3 border-info" id="form_card">

					<?php VisitReport::form(); ?>

				</div>
			</div>
		</div>

		<div id="modal_report_finish" class="modal fade" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content border-3 border-info" id="form_card_finish">

					<?php VisitReport::form_finish(); ?>

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
	<?php endif; ?>

	<div id="modal_report_show" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-3 border-info" id="report_show">

			</div>
		</div>
	</div>

	<?php if ($activity): ?>
		<script type="text/javascript">

			function CleanFormFinish(id, name) {
				$('#report_editor').html('');
				$('#repfun_id').val(id);
				$('#modal_report_finish').modal('show');
				if (name) {
					$('#report_title').val(name);
				}
			}

			function CleanForm(id, name) {
				$('#report_editor').html('');
				$('#rep_id').val(id);
				$('#modal_report_add').modal('show');
				if (name) {
					$('#report_title').val(name);
				}
			}

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
