<?php
require_once '../../../tools/warframe.php';
$session->is_auth();
$header = "Пациент ".addZero($_GET['id']);
$patient = $db->query("SELECT * FROM users WHERE id = {$_GET['id']}")->fetch(PDO::FETCH_OBJ);
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

                <div class="card border-1 border-info">

                    <div class="card-header text-dark header-elements-inline alpha-info">
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
											   <?= $patient->region ?> <?= $patient->residenceAddress ?>
										   </div>

										   <label class="col-md-4"><b>Адрес прописки:</b></label>
										   <div class="col-md-8 text-right">
											   <?= $patient->region ?> <?= $patient->registrationAddress ?>
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
											   <?= $patient->numberPhone ?>
										   </div>

										   <label class="col-md-4"><b>Дата рождение:</b></label>
										   <div class="col-md-8 text-right">
											   <?= date('d.m.Y', strtotime($patient->dateBith)) ?>
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

				<div class="card border-1 border-info">

					<div class="card-header text-dark header-elements-inline alpha-info">
						<h6 class="card-title">Визиты</h6>
						<div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
							</div>
						</div>
					</div>

					<div class="card-body">

						<div class="table-responsive card">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr class="bg-info">
                                        <th>№</th>
			                            <th>Напрвитель</th>
			                            <th>Тип визита</th>
										<th>Дата визита</th>
										<th>Дата завершения</th>
			                            <th>Мед услуга</th>
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php $sql = "SELECT
														vs.id, vs.route_id,
														vs.parent_id, vs.grant_id,
														vs.direction, vs.add_date,
														vs.status, vs.completed,
														sc.name, vs.laboratory,
														vs.service_id
														FROM visit vs
															LEFT JOIN service sc ON(vs.service_id=sc.id)
														WHERE
															vs.user_id = {$_GET['id']} AND (vs.status != 5 OR vs.status IS NULL) AND
															(
																vs.direction IS NULL OR
																(vs.direction IS NOT NULL AND vs.service_id = 1)
															)
														AND vs.parent_id = {$_SESSION['session_id']} AND vs.completed IS NOT NULL ORDER BY vs.add_date DESC"; ?>
									<?php $i=1;foreach ($db->query($sql) as $row): ?>
										<tr>
                                            <td><?= $i++ ?></td>
											<td>
												<?= level_name($row['route_id']) ." ". division_name($row['route_id']) ?>
												<div class="text-muted"><?= get_full_name($row['route_id']) ?></div>
											</td>
											<td><?= ($row['direction']) ? "Стационарный" : "Амбулаторный" ?></td>
											<td><?= ($row['add_date']) ? date('d.m.Y H:i', strtotime($row['add_date'])) : '<span class="text-muted">Нет данных</span>' ?></td>
											<td><?= ($row['completed']) ? date('d.m.Y H:i', strtotime($row['completed'])) : '<span class="text-muted">Нет данных</span>' ?></td>
                                            <td><?= $row['name'] ?></td>
                                            <td class="text-center">
												<button type="button" class="btn btn-outline-info btn-sm legitRipple dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i> Просмотр</button>
                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
													<?php if ($row['laboratory']): ?>
														<a onclick="Check('<?= viv('laboratory/report') ?>?pk=<?= $row['id'] ?>')" class="dropdown-item"><i class="icon-eye"></i> Просмотр</a>
														<a <?= ($row['completed']) ? 'onclick="Print(\''. viv('prints/document_2').'?id='. $row['id']. '\')"' : 'class="text-muted dropdown-item"' ?> class="dropdown-item"><i class="icon-printer2"></i> Печать</a>
													<?php else: ?>
														<?php if ($row['direction'] and $row['service_id'] == 1): ?>
															<a href="<?= viv('card/content_1') ?>?pk=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-eye"></i>История</a>
															<a <?= ($row['completed']) ? 'onclick="Print(\''. viv('prints/document_3').'?id='. $row['id']. '\')"' : 'class="text-muted dropdown-item"' ?> class="dropdown-item"><i class="icon-printer2"></i>Выписка</a>
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
									<?php endforeach; ?>
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

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
