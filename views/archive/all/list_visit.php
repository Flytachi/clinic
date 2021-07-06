<?php
require_once '../../../tools/warframe.php';
$session->is_auth();

if (is_numeric($_GET['id'])) {
	$header = "Пациент ".addZero($_GET['id']);
	$patient = $db->query("SELECT * FROM users WHERE id = {$_GET['id']}")->fetch(PDO::FETCH_OBJ);
} else {
	$patient = False;
	echo "err";
}
if (!$patient) {
	Mixin\error('404');
}
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

                <div class="<?= $classes['card'] ?>">

                    <div class="<?= $classes['card-header'] ?>">
                        <h5 class="card-title"><b><?= get_full_name($patient->id) ?></b></h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-3">
                                <div class="card-img-actions">
                                    <img class="card-img-top img-fluid" src="<?= stack("vendors/image/user3.jpg")?>" alt="">
                                </div>
                            </div>

							<div class="col-md-9" style="font-size: 0.9rem">

				                <fieldset class="mb-3 row">

									<div class="col-md-6">

									   <div class="form-group row">

										   <label class="col-md-4"><b>Статус:</b></label>
										   <div class="col-md-8 text-right">
											   <?php if ($patient->status): ?>
												   <span style="font-size:15px;" class="badge badge-flat border-success text-success">Активный</span>
											   <?php else: ?>
												   <span style="font-size:15px;" class="badge badge-flat border-secondary text-secondary">Закрытый</span>
											   <?php endif; ?>
										   </div>

										   <label class="col-md-4"><b>Адрес проживание:</b></label>
										   <div class="col-md-8 text-right">
											   <?= $patient->region ?> <?= $patient->address_residence ?>
										   </div>

										   <label class="col-md-4"><b>Адрес прописки:</b></label>
										   <div class="col-md-8 text-right">
											   <?= $patient->region ?> <?= $patient->address_registration ?>
										   </div>

									   </div>

								   	</div>

							   		<div class="col-md-6">

									   <div class="form-group row">

										   <label class="col-md-3"><b>ID:</b></label>
										   <div class="col-md-9 text-right">
											   <?= addZero($patient->id) ?>
										   </div>

										   <label class="col-md-3"><b>Телефон:</b></label>
										   <div class="col-md-9 text-right">
											   <?= $patient->phone_number ?>
										   </div>

										   <label class="col-md-4"><b>Дата рождение:</b></label>
										   <div class="col-md-8 text-right">
											   <?= date_f($patient->birth_date) ?>
										   </div>

										   <label class="col-md-3"><b>Пол:</b></label>
										   <div class="col-md-9 text-right">
											   <?= ($patient->gender) ? "Мужской": "Женский" ?>
										   </div>

								   		</div>

							   		</div>

				                    <div class="col-md-6">

				                        <div class="form-group row">

											<label class="col-md-8"><b>Количество курсов лечения:</b></label>
				    						<div class="col-md-4 text-right">
				    							100
				    						</div>

											<label class="col-md-8"><b>Количество стационарных курсов лечения:</b></label>
				    						<div class="col-md-4 text-right">
				    							100
				    						</div>

											<label class="col-md-8"><b>Количество амбулаторных курсов лечения:</b></label>
				    						<div class="col-md-4 text-right">
				    							100
				    						</div>

				                        </div>

				                    </div>

				                    <div class="col-md-6">

										<div class="form-group row">

 										   <label class="col-md-8"><b>Количество визитов:</b></label>
 										   <div class="col-md-4 text-right">
 											   100
 										   </div>

 										   <label class="col-md-8"><b>Количество стационарных визитов:</b></label>
 										   <div class="col-md-4 text-right">
 											   100
 										   </div>

 										   <label class="col-md-8"><b>Количество амбулаторных визитов:</b></label>
 										   <div class="col-md-4 text-right">
 											   100
 										   </div>

								   		</div>

									</div>

				                </fieldset>

				            </div>

                        </div>

                    </div>

                </div>

				<div class="<?= $classes['card'] ?>">

					<div class="<?= $classes['card-header'] ?>">
						<h6 class="card-title">Визиты</h6>
						<?php if(module('module_laboratory')): ?>
							<div class="header-elements">
								<div class="list-icons">
									<button onclick="PrePrint('<?= viv('prints/document_2') ?>?id=<?= $patient->id ?>')" type="button" class="btn btn-sm btn-outline-info">Печать</button>
								</div>
							</div>
						<?php endif; ?>
					</div>

					<div class="card-body">

						<?php
						if( isset($_SESSION['message']) ){
				            echo $_SESSION['message'];
				            unset($_SESSION['message']);
				        }
						?>

						<div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr class="<?= $classes['table-thead'] ?>">
                                        <th>№</th>
										<th style="width: 16%">№ Визита</th>
			                            <th>Жалоба</th>
										<th style="width: 11%">Дата визита</th>
										<th style="width: 11%">Дата завершения</th>
										<th>Тип визита</th>
										<th>Статус</th>
                                        <th class="text-right" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>

									<?php
									$tb = new Table($db, "visits");
									$search = $tb->get_serch();
									$search_array = array(
										"user_id = $patient->id", 
										"user_id = $patient->id"
									);
									$tb->where_or_serch($search_array)->order_by('add_date DESC')->set_limit(20);
									?>
									<?php foreach($tb->get_table(1) as $row): ?>
										<tr>
                                            <td><?= $row->count ?></td>
                                            <td><?= $row->id ?></td>
                                            <td><?= $row->complaint ?></td>
                                            <td><?= date_f($row->add_date, 1) ?></td>
                                            <td><?= date_f($row->completed, 1) ?></td>
											<td>
												<?php if ($row->direction): ?>
													<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Стационарный</span>
												<?php else: ?>
													<span style="font-size:15px;" class="badge badge-flat border-primary text-primary">Амбулаторный</span>
												<?php endif; ?>
											</td>
											<td>
												<?php if ($row->completed): ?>
													<span style="font-size:15px;" class="badge badge-flat border-success text-success">Завершён</span>
												<?php else: ?>
													<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Не завершён</span>
												<?php endif; ?>
											</td>
											<td class="text-right">
												<a href="<?= viv('card/content_4') ?>?pk=<?= $row->id ?>" type="button" class="<?= $classes['btn-viewing'] ?>">Просмотр</a>
											</td>
                                        </tr>
									<?php endforeach; ?>

                                    <?php
									/*
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
												vs.user_id = {$_GET['id']} AND
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
												<button type="button" class="<?= $classes['btn_detail'] ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Просмотр</button>
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
                                    }*/
                                    ?>
                                </tbody>
                            </table>
                        </div>

					</div>

				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<div id="modal_update" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-3 border-info">
				<div class="modal-header bg-info">
					<h5 class="modal-title">Обновить Даные<span id="vis_title"></h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body" id="update_card">

				</div>
			</div>
		</div>
	</div>

	<div id="modal_report_show" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg" id="modal_class_show">
			<div class="modal-content border-3 border-info" id="report_show">

			</div>
		</div>
	</div>

	<script type="text/javascript">

		function Update(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#modal_update').modal('show');
					$('#update_card').html(result);
				},
			});
		};

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
