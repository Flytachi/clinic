<?php
require_once 'callback.php';
is_module('module_laboratory');
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
							<i class="icon-fire2 mr-2"></i>Анализы
							<?php if ($activity and permission(5)): ?>
								<a onclick='Route(`<?= up_url(null, "VisitRoute", "form_labaratory") ?>&patient=<?= json_encode($patient) ?>`)' class="float-right <?= $class_color_add ?>">
									<i class="icon-plus22 mr-1"></i>Добавить
								</a>
							<?php else: ?>
								<a onclick="PrePrint('<?= prints('document-2') ?>?id=<?= $patient->visit_id ?>')" type="button" class="float-right mr-1"><i class="icon-printer2"></i></a>
							<?php endif; ?>
							<a onclick="AnalizeCheck(<?= $patient->visit_id ?>)" class="float-right text-info mr-2">
								<i class="icon-drawer3 mr-1"></i>Сводка анализов
							</a>
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
											<th class="text-center">Действия</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$tb = new Table($db, "visit_services");
										$tb->set_data("id, division_id, route_id, parent_id, accept_date, completed, service_name, status")->where("visit_id = $patient->visit_id AND level = 6")->order_by('add_date DESC');
										?>
										<?php foreach ($tb->get_table(1) as $row): ?>
											<tr id="TR_<?= $row->id ?>" onclick="Change_lab(this, <?= $row->id ?>)" data-stat="0">
												<td><?= $row->count ?></td>
												<td>
													<?php if($row->parent_id): ?>
														<?= $db->query("SELECT title FROM divisions WHERE id = $row->division_id")->fetchColumn() ?>
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
													<button type="button" class="<?= $classes['btn-viewing'] ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Просмотр</button>
	                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
														<?php if( $activity and ( (!$patient->direction and $row->status == 1) or ( $patient->direction and $row->status == 2 and ($row->route_id == $session->session_id or is_grant()) ) ) ): ?>
															<a onclick="Delete('<?= del_url($row->id, 'VisitServicesModel') ?>', '#TR_<?= $row->id ?>')" class="dropdown-item"><i class="icon-x"></i>Отмена</a>
														<?php endif; ?>
														<?php if ( in_array($row->status, [3,7]) ): ?>
															<a onclick="Check('<?= viv('laboratory/report') ?>?pk=<?= $row->id ?>')" class="dropdown-item"><i class="icon-eye"></i>Просмотр</a>
															<a <?= ($row->completed) ? 'onclick="Print(\''. prints('document-2').'?pk='. $row->id. '\')"' : 'class="text-muted dropdown-item"' ?> class="dropdown-item"><i class="icon-printer2"></i> Печать</a>
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

		function AnalizeCheck(visit) {
			$.ajax({
				type: "GET",
				url: "<?= viv('laboratory/report') ?>?visit_pk="+visit,
				success: function (data) {
					$('#modal_default').modal('show');
					$('#form_card').html(data);
				},
			});
		}

		function Check(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (data) {
					$('#modal_default').modal('show');
					$('#form_card').html(data);
				},
			});
		};

		function Delete(url, tr) {
            event.preventDefault();
            $.ajax({
				type: "GET",
				url: url,
				success: function (result) {
					var data = JSON.parse(result);

					if (data.status == "success") {
						$(tr).css("background-color", "rgb(244, 67, 54)");
						$(tr).css("color", "white");
						$(tr).fadeOut(900, function() {
							$(tr).remove();
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

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
