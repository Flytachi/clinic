<?php
require_once 'callback.php';
is_module('module_diagnostic');
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

						<legend class="font-weight-semibold font-size-sm">
							<i class="icon-fire2 mr-2"></i><span class="text-uppercase">Диагностика</span>
							<?php if ($activity and permission(5)): ?>
								<a class="float-right text-uppercase <?= $class_color_add ?>" data-toggle="modal" data-target="#modal_route">
									<i class="icon-plus22 mr-1"></i>Добавить
								</a>
								<?php if (module('module_zetta_pacs')): ?>
									<?php $zeT = zeTTa_data(); ?>
									<a href="zetta://URL=http://<?= $zeT->IP ?>&LID=<?= $zeT->LID ?>&LPW=<?= $zeT->LPW ?>&LICD=<?= $zeT->LICD ?>&PID=<?= $patient->id ?>&VTYPE=<?= $zeT->VTYPE ?>" class="float-right text-violet mr-2">
										ZeTTa-PACS
									</a>
								<?php endif; ?>
							<?php endif; ?>
						</legend>

						<div class="card">

							<div class="table-responsive">
								<table class="table table-hover table-sm">
									<thead class="<?= $classes['table-thead'] ?>">
										<tr>
											<th>№</th>
				                            <th>Отдел/Специалист</th>
											<th>Дата визита</th>
											<th>Дата завершения</th>
				                            <th>Мед услуга</th>
											<th>Статус</th>
											<th class="text-right">Действия</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$tb = new Table($db, "visit_services");
										$tb->set_data("id, division_id, parent_id, accept_date, completed, service_name, status")->where("visit_id = $patient->visit_id AND level = 10")->order_by('add_date DESC');
										?>
										<?php foreach ($tb->get_table(1) as $row): ?>
											<tr id="TR_<?= $row->id ?>">
												<td><?= $row->count ?></td>
												<td>
													<?php if($row->parent_id): ?>
														<?= division_title($row->parent_id) ?>
														<div class="text-muted"><?= get_full_name($row->parent_id) ?></div>
													<?php else: ?>
														<?= $db->query("SELECT title FROM divisions WHERE id = $row->division_id")->fetchColumn() ?>
													<?php endif; ?>
												</td>
												<td><?= ($row->accept_date) ? date_f($row->accept_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
												<td><?= ($row->completed) ? date_f($row->completed, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
												<td><?= $row->service_name ?></td>
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
													<button type="button" class="<?= $classes['btn_viewing'] ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Просмотр</button>
	                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
														<?php if( $activity and $row->status == 1 ): ?>
															<a onclick="Delete('<?= del_url($row->id, 'VisitServicesModel') ?>', '#TR_<?= $row->id ?>')" class="dropdown-item"><i class="icon-x"></i>Отмена</a>
														<?php endif; ?>
														<?php if ( in_array($row->status, [3,5,7]) ): ?>
															<a onclick="Check('<?= viv('doctor/report') ?>?pk=<?= $row->id ?>')" class="dropdown-item"><i class="icon-eye"></i>Просмотр</a>
															<a <?= ($row->completed) ? 'onclick="Print(\''. viv('prints/document_1').'?id='. $row->id. '\')"' : 'class="text-muted dropdown-item"' ?> class="dropdown-item"><i class="icon-printer2"></i> Печать</a>
														<?php endif; ?>
														
														<?php /*if ($patient->direction and !$row['accept_date'] and ($_SESSION['session_id'] == $row['route_id'] or $_SESSION['session_id'] == $patient->grant_id)): ?>
															<a onclick="Delete('<?= del_url($row['id'], 'VisitModel') ?>', '#TR_<?= $row['id'] ?>')" class="dropdown-item"><i class="icon-x"></i>Отмена</a>
														<?php endif;*/ ?>
													</div>
												</td>
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
							(new VisitRoute)->form_sta_diagnostic();
						} else {
							(new VisitRoute)->form_out_diagnostic();
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

		function Delete(events, tr) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					var data = JSON.parse(result);

					if (data.status == "success") {

						$(tr).css("background-color", "red");
						$(tr).css("color", "white");
						$(tr).fadeOut('slow', function() {
							$(this).remove();
						});
						new Noty({
							text: data.message,
							type: 'success'
						}).show();
						
					}else {

						new Noty({
							text: data.message,
							type: 'error'
						}).show();
						
					}
				},
			});
		};
	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>