<?php
require_once 'callback.php';
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

				<div class="<?= $classes['card'] ?>">
				    <div class="<?= $classes['card-header'] ?>">
				        <h6 class="card-title">Просмотр визита</h6>
				    </div>

				    <div class="card-body">

						<?php include "content_tabs.php"; ?>

						<legend class="font-weight-semibold text-uppercase font-size-sm">
							<i class="icon-googleplus5 mr-2"></i>Физиотерапия
							<?php if ( ($activity and !$patient->direction) or ($patient->direction and permission(5)) ): ?>
								<a onclick='Route(`<?= up_url(null, "VisitRoute", "form_physio") ?>&patient=<?= json_encode($patient) ?>`)' class="float-right <?= $class_color_add ?>">
									<i class="icon-plus22 mr-1"></i>Добавить
								</a>
							<?php endif; ?>
						</legend>

						<div class="card">

							<div class="table-responsive">
								<table class="table table-hover table-sm">
									<thead class="<?= $classes['table-thead'] ?>">
										<tr>
											<th>№</th>
				                            <th>Мед услуга</th>
											<th>Дата визита</th>
											<th>Дата завершения</th>
											<th>Статус</th>
											<th class="text-right">Действия</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$tb = new Table($db, "visit_services");
										$tb->set_data("id, division_id, parent_id, accept_date, completed, service_name, status")->where("visit_id = $patient->visit_id AND level = 12")->order_by('add_date DESC');
										?>
										<?php foreach ($tb->get_table(1) as $row): ?>
											<tr id="TR_<?= $row->id ?>">
												<td><?= $row->count ?></td>
												<td><?= $row->service_name ?></td>
												<td><?= ($row->accept_date) ? date_f($row->accept_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
												<td><?= ($row->completed) ? date_f($row->completed, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
												<td>
													<?php if ($row->status == 1): ?>
														<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Оплачивается</span>
													<?php elseif ($row->status == 2): ?>
														<span style="font-size:15px;" class="badge badge-flat border-orange text-orange">Ожидание</span>
													<?php elseif ($row->status == 3): ?>
														<span style="font-size:15px;" class="badge badge-flat border-success text-success">У специалиста</span>
													<?php elseif ($row->status == 5): ?>
														<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Возврат</span>
													<?php elseif ($row->status == 6): ?>
														<span style="font-size:15px;" class="badge badge-flat border-secondary text-secondary">Отменённый</span>
													<?php elseif ($row->status == 7): ?>
														<span style="font-size:15px;" class="badge badge-flat border-success text-success">Завершён</span>
													<?php else: ?>
														<span style="font-size:15px;" class="badge badge-flat border-secondary text-secondary">Неизвестный</span>
													<?php endif; ?>
												</td>
												<td class="text-right">
													<button type="button" class="<?= $classes['btn-viewing'] ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Просмотр</button>
	                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
														<?php if( $activity and ((!$patient->direction and $row->status == 1) or ($patient->direction and $row->status == 2) ) ): ?>
															<a onclick="Delete('<?= del_url($row->id, 'VisitServicesModel') ?>', '#TR_<?= $row->id ?>')" class="dropdown-item"><i class="icon-x"></i>Отмена</a>
														<?php endif; ?>
														
														<?php /*if ($patient->direction and !$row['accept_date'] and ($_SESSION['session_id'] == $row['route_id'] or $_SESSION['session_id'] == $patient->grant_id)): ?>
															<a onclick="Delete('<?= del_url($row['id'], 'VisitModel') ?>', '#TR_<?= $row['id'] ?>')" class="dropdown-item"><i class="icon-x"></i>Отмена</a>
														<?php endif;*/ ?>
													</div>
												</td>
											</tr>
										<?php endforeach; ?>
										<?php /*
										$i = 1;
										if ( isset($patient->completed) ) {
											$sql_table = "SELECT vs.id, vs.parent_id, vs.direction, vs.accept_date, vs.completed, vs.status, sc.name, vs.physio, vs.manipulation, vs.route_id
															FROM visit vs LEFT JOIN service sc ON(vs.service_id=sc.id)
															WHERE vs.user_id = $patient->id AND (vs.physio IS NOT NULL OR vs.manipulation IS NOT NULL) AND (DATE_FORMAT(vs.add_date, '%Y-%m-%d %H:%i:%s') BETWEEN \"$patient->add_date\" AND \"$patient->completed\") ORDER BY vs.id DESC";
										} else {
											$sql_table = "SELECT vs.id, vs.parent_id, vs.direction, vs.accept_date, vs.completed, vs.status, sc.name, vs.physio, vs.manipulation, vs.route_id
															FROM visit vs LEFT JOIN service sc ON(vs.service_id=sc.id)
															WHERE vs.user_id = $patient->id AND (vs.physio IS NOT NULL OR vs.manipulation IS NOT NULL) AND (DATE_FORMAT(vs.add_date, '%Y-%m-%d %H:%i:%s') BETWEEN \"$patient->add_date\" AND \"CURRENT_TIMESTAMP()\") ORDER BY vs.id DESC";
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
														<?php if ($row['physio']): ?>
															<a onclick="Check('<?= viv('physio/report') ?>?pk=<?= $row['id'] ?>')" class="dropdown-item"><i class="icon-eye"></i>Просмотр</a>
														<?php elseif ($row['manipulation']): ?>
															<a onclick="Check('<?= viv('manipulation/report') ?>?pk=<?= $row['id'] ?>')" class="dropdown-item"><i class="icon-eye"></i>Просмотр</a>
														<?php endif; ?>
														<?php if ($patient->direction and !$row['accept_date'] and ($_SESSION['session_id'] == $row['route_id'] or $_SESSION['session_id'] == $patient->grant_id)): ?>
															<a onclick="Delete('<?= del_url($row['id'], 'VisitModel') ?>', '#TR_<?= $row['id'] ?>')" class="dropdown-item"><i class="icon-x"></i>Отмена</a>
														<?php endif; ?>
													</div>
												</td>
											</tr>
										<?php
										}*/
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

	<div id="modal_default" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="<?= $classes['modal-global_content'] ?>" id="form_card"></div>
		</div>
	</div>

	<script type="text/javascript">

		function Route(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#modal_default').modal('show');
					$('#form_card').html(result);
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
