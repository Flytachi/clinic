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
							<i class="icon-clipboard6 mr-2"></i>Другие визиты
							<?php if(module('module_laboratory')): ?>
								<a onclick="PrePrint('<?= viv('prints/document_2') ?>?id=<?= $patient->id ?>')" type="button" class="float-right mr-1"><i class="icon-printer2"></i></a>
    						<?php endif; ?>
						</legend>

						<!-- <div class="alert bg-warning alert-styled-left alert-dismissible">
							<span class="font-weight-semibold">Технические работы</span>
						</div> -->

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
											<th>Напрвитель</th>
											<th>Статус</th>
											<th class="text-right">Действия</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$tb = new Table($db, "visit_services");
										$tb->set_data("id, route_id, division_id, parent_id, accept_date, completed, service_name, status")->where("visit_id = $patient->visit_id AND route_id != $session->session_id AND parent_id != $session->session_id")->order_by('add_date DESC');
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
													<?= division_title($row->route_id) ?>
													<div class="text-muted"><?= get_full_name($row->route_id) ?></div>
												</td>
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
														<?php if ( in_array($row->status, [3,5,7]) ): ?>
															<a onclick="Check('<?= viv('doctor/report') ?>?pk=<?= $row->id ?>')" class="dropdown-item"><i class="icon-eye"></i>Просмотр</a>
															<a <?= ($row->completed) ? 'onclick="Print(\''. viv('prints/document_1').'?id='. $row->id. '\')"' : 'class="text-muted dropdown-item"' ?> class="dropdown-item"><i class="icon-printer2"></i> Печать</a>
														<?php endif; ?>
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
	</script>

	<?php if(module('module_laboratory')): ?>
		<script type="text/javascript">

			items = [];

			function Change_lab(tbody, id) {
				if (tbody.dataset.stat == 1) {
					tbody.dataset.stat = "0";
					tbody.className = "";

					for(let a = 0; a < items.length; a++){
						if(items[a] == id ){
							items.splice(a, 1);
						}
					}

				}else {
					tbody.dataset.stat = "1";
					tbody.className = "table-warning";
					items.push(id);
				}
			}

			function PrePrint(url) {
				if (items.length != 0) {
					Print(url+`&items=[${items}]`);
				}
			}

		</script>
	<?php endif; ?>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
