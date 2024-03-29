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

				        <?php include "content_tabs.php"; ?>

						<legend class="font-weight-semibold text-uppercase font-size-sm">
							<i class="icon-add mr-2"></i>Назначенные Визиты
							<?php if ($activity and !$patient->direction or ($patient->direction and $patient->grant_id == $_SESSION['session_id'])): ?>
								<a class="float-right <?= $class_color_add ?>" data-toggle="modal" data-target="#modal_route">
									<i class="icon-plus22 mr-1"></i>Добавить
								</a>
							<?php endif; ?>
						</legend>

						<div class="card">

							<div class="table-responsive">
								<table class="table table-hover table-sm">
									<thead>
										<tr class="bg-info">
											<th>№</th>
				                            <th>Специалист</th>
											<th>Дата визита</th>
											<th>Дата завершения</th>
				                            <th>Мед услуга</th>
											<th>Тип визита</th>
											<th>Статус</th>
											<th class="text-center">Действия</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$i = 1;
										if ($patient->completed) {
											$sql_table = "SELECT vs.id, vs.parent_id, vs.direction, vs.accept_date, vs.completed, vs.status, sc.name, vs.route_id
															FROM visit vs LEFT JOIN service sc ON(vs.service_id=sc.id)
															WHERE vs.user_id = $patient->id AND vs.route_id = $patient->grant_id AND vs.laboratory IS NULL AND vs.diagnostic IS NULL AND vs.physio IS NULL
																AND vs.manipulation IS NULL AND (DATE_FORMAT(vs.add_date, '%Y-%m-%d %H:%i:%s') BETWEEN \"$patient->add_date\" AND \"$patient->completed\") ORDER BY vs.id DESC";
										} else {
											$sql_table = "SELECT vs.id, vs.parent_id, vs.direction, vs.accept_date, vs.completed, vs.status, sc.name, vs.route_id
															FROM visit vs LEFT JOIN service sc ON(vs.service_id=sc.id)
															WHERE vs.user_id = $patient->id AND vs.route_id = $patient->grant_id AND vs.laboratory IS NULL AND vs.diagnostic IS NULL AND vs.physio IS NULL
															AND vs.manipulation IS NULL AND (DATE_FORMAT(vs.add_date, '%Y-%m-%d %H:%i:%s') BETWEEN \"$patient->add_date\" AND \"CURRENT_TIMESTAMP()\") ORDER BY vs.id DESC";
										}
										foreach ($db->query($sql_table) as $row) {
										?>
											<tr id="TR_<?= $row['id'] ?>">
												<td><?= $i++ ?></td>
												<td>
													<?= level_name($row['parent_id']) ." ". division_name($row['parent_id']) ?>
													<div class="text-muted"><?= get_full_name($row['parent_id']) ?></div>
												</td>
												<td><?= ($row['accept_date']) ? date('d.m.Y H:i', strtotime($row['accept_date'])) : '<span class="text-muted">Нет данных</span>' ?></td>
												<td><?= ($row['completed']) ? date('d.m.Y H:i', strtotime($row['completed'])) : '<span class="text-muted">Нет данных</span>' ?></td>
												<td><?= $row['name'] ?></td>
												<td><?= ($row['direction']) ? "Стационарный" : "Амбулаторный" ?></td>
												<td>
													<?php if ($row['completed']): ?>
														<span style="font-size:15px;" class="badge badge-flat border-success text-success">Завершена</span>
													<?php else: ?>
														<?php if ($row['status'] == 0): ?>
															<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Оплачивается</span>
														<?php elseif ($row['status'] == 1): ?>
															<span style="font-size:15px;" class="badge badge-flat border-orange text-orange">Ожидание</span>
														<?php elseif ($row['status'] == 2): ?>
															<span style="font-size:15px;" class="badge badge-flat border-success text-success">У специалиста</span>
														<?php else: ?>
															<span style="font-size:15px;" class="badge badge-flat border-secondary text-secondary">Закрытый</span>
														<?php endif; ?>
													<?php endif; ?>
												</td>
												<td class="text-center">
													<button type="button" class="btn btn-outline-info btn-sm legitRipple dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Просмотр</button>
	                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
														<a onclick="Check('<?= viv('doctor/report') ?>?pk=<?= $row['id'] ?>')" class="dropdown-item"><i class="icon-eye"></i>Просмотр</a>
														<a <?= ($row['completed']) ? 'onclick="Print(\''. viv('prints/document_1').'?id='. $row['id']. '\')"' : 'class="text-muted dropdown-item"' ?> class="dropdown-item"><i class="icon-printer2"></i> Печать</a>
														<?php if ($patient->direction and !$row['accept_date'] and ($_SESSION['session_id'] == $row['route_id'] or $_SESSION['session_id'] == $patient->grant_id)): ?>
															<a onclick="Delete('<?= del_url($row['id'], 'VisitModel') ?>', '#TR_<?= $row['id'] ?>')" class="dropdown-item"><i class="icon-x"></i>Отмена</a>
														<?php endif; ?>
													</div>
												</td>
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

	<?php if ($activity): ?>
		<div id="modal_route" class="modal fade" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header bg-info">
						<h6 class="modal-title">Назначить визит</h6>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<div class="modal-body">

						<?php
						if ($patient->direction) {
							VisitRoute::form_sta();
						} else {
							VisitRoute::form_out();
						}
						?>

					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div id="modal_report_show" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg" id="modal_class_show">
			<div class="modal-content border-3 border-info" id="report_show">

			</div>
		</div>
	</div>

	<script type="text/javascript">
		function Check(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (data) {
					$('#modal_report_show').modal('show');
					$('#report_show').html(data);
				},
			});
		};

		function Delete(url, tr) {
            event.preventDefault();
            $.ajax({
				type: "GET",
				url: url,
				success: function (data) {
                    $(tr).css("background-color", "rgb(244, 67, 54)");
                    $(tr).css("color", "white");
                    $(tr).fadeOut(900, function() {
                        $(tr).remove();
                    });
				},
			});
        };
	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
