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
							<i class="icon-clipboard6 mr-2"></i>Другие визиты
							<a onclick="PrePrint('<?= viv('prints/document_2') ?>?id=<?= $patient->id ?>')" type="button" class="float-right mr-1"><i class="icon-printer2"></i></a>
						</legend>

						<!-- <div class="alert bg-warning alert-styled-left alert-dismissible">
							<span class="font-weight-semibold">Технические работы</span>
						</div> -->

						<div class="card">

							<div class="table-responsive">
								<table class="table table-hover table-sm">
									<thead>
										<tr class="bg-info">
											<th>№</th>
											<th style="width: 16%">Специолист</th>
											<th style="width: 11%">Дата визита</th>
											<th style="width: 11%">Дата завершения</th>
											<th>Мед услуга</th>
											<th style="width: 16%">Напрвитель</th>
											<th>Тип визита</th>
											<th>Статус</th>
											<th class="text-right" style="width:210px">Действия</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$i = 1;
										$sql = "SELECT
													vs.id, vs.route_id,
													vs.parent_id, vs.grant_id,
													vs.direction, vs.add_date,
													vs.status, vs.completed,
													sc.name, vs.laboratory,
													vs.service_id
												FROM visit vs
													LEFT JOIN service sc ON(vs.service_id=sc.id)
												WHERE
													vs.user_id = $patient->id AND 
													vs.id != $patient->visit_id AND 
													(vs.status != 5 OR vs.status IS NULL) AND
													(
														vs.direction IS NULL OR
														(vs.direction IS NOT NULL AND vs.service_id = 1)
													)
												ORDER BY vs.add_date DESC";
										foreach($db->query($sql) as $row) {
											?>
											<?php if ($row['laboratory']): ?>
												<tr onclick="Change_lab(this, <?= $row['id'] ?>)" data-stat="0">
											<?php else: ?>
												<tr>
											<?php endif; ?>
												<td><?= $i++ ?></td>
												<td>
													<?= level_name($row['parent_id']) ." ". division_name($row['parent_id']) ?>
													<div class="text-muted"><?= get_full_name($row['parent_id']) ?></div>
												</td>
												<td><?= ($row['add_date']) ? date('d.m.Y H:i', strtotime($row['add_date'])) : '<span class="text-muted">Нет данных</span>' ?></td>
												<td><?= ($row['completed']) ? date('d.m.Y H:i', strtotime($row['completed'])) : '<span class="text-muted">Нет данных</span>' ?></td>
												<td><?= $row['name'] ?></td>
												<td>
													<?= level_name($row['route_id']) ." ". division_name($row['route_id']) ?>
													<div class="text-muted"><?= get_full_name($row['route_id']) ?></div>
												</td>
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
												<td class="text-right">
													<button type="button" class="btn btn-outline-info btn-sm legitRipple dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Просмотр</button>
													<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
														<?php if (module('module_laboratory') and $row['laboratory']): ?>
															<a onclick="Check('<?= viv('laboratory/report') ?>?pk=<?= $row['id'] ?>')" class="dropdown-item"><i class="icon-eye"></i> Просмотр</a>
															<a <?= ($row['completed']) ? 'onclick="Print(\''. viv('prints/document_2').'?id='. $row['id']. '\')"' : 'class="text-muted dropdown-item"' ?> class="dropdown-item"><i class="icon-printer2"></i> Печать</a>
														<?php else: ?>
															<?php if ($row['direction'] and $row['service_id'] == 1): ?>
																<a href="<?= viv('card/content_1') ?>?pk=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-eye"></i>История</a>
																<a <?= ($row['completed']) ? 'onclick="Print(\''. viv('prints/document_3').'?id='. $row['id']. '\')"' : 'class="text-muted dropdown-item"' ?> class="dropdown-item"><i class="icon-printer2"></i>Выписка</a>
																<a <?= ($row['completed']) ? 'onclick="Print(\''. viv('prints/document_4').'?id='. $row['id']. '\')"' : 'class="text-muted dropdown-item"' ?> class="dropdown-item"><i class="icon-printer"></i>Акт сверки</a>
															<?php else: ?>
																<a onclick="Check('<?= viv('doctor/report') ?>?pk=<?= $row['id'] ?>')" class="dropdown-item"><i class="icon-eye"></i> Просмотр</a>
																<?php if (permission([2,32]) and (level($row['route_id']) == 2 or level($row['route_id']) == 32)): ?>
																	<a onclick="Update('<?= up_url($row['id'], 'VisitModel') ?>')" class="dropdown-item"><i class="icon-users"></i> Направитель</a>
																<?php endif; ?>
																<a <?= ($row['completed']) ? 'onclick="Print(\''. viv('prints/document_1').'?id='. $row['id']. '\')"' : 'class="text-muted dropdown-item"' ?> class="dropdown-item"><i class="icon-printer2"></i> Печать</a>
															<?php endif; ?>
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
