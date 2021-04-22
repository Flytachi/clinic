<?php
require_once '../../tools/warframe.php';
$session->is_auth(13);
$header = "Приём пациетов";
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
						<h6 class="card-title">Пациенты на приём</h6>
						<div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
							</div>
						</div>
					</div>

					<div class="card-body">

						<div class="table-responsive">
							<table class="table table-hover table-sm datatable-basic">
                                <thead>
                                    <tr class="bg-info">
                                        <th>ID</th>
                                        <th>ФИО</th>
										<th>Возраст</th>
                                        <th>Дата назначения</th>
                                        <th>Мед услуга</th>
                                        <th>Направитель</th>
										<th>Тип визита</th>
                                        <th class="text-center" style="width: 30px">Кол-во</th>
                                        <th class="text-center">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php foreach ($db->query("SELECT DISTINCT us.id, vs.service_id, vs.direction, us.dateBith, vs.complaint
											FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE
												vs.completed IS NULL AND vs.status = 1 AND vs.manipulation IS NOT NULL
											ORDER BY IFNULL(vs.priced_date, vs.add_date) ASC") as $div): ?>
											<?php $row = $db->query("SELECT COUNT(vs.id) 'qty', us.id, vs.id 'visit_id', vs.add_date, vs.route_id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 1 AND vs.manipulation IS NOT NULL AND vs.user_id = {$div['id']} AND vs.service_id = {$div['service_id']} ORDER BY IFNULL(vs.priced_date, vs.add_date) ASC")->fetch(); ?>
											<tr id="PatientFailure_tr_<?= $row['visit_id'] ?>">
	                                            <td><?= addZero($row['id']) ?></td>
	                                            <td>
													<div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div>
													<div class="text-muted">
														<?php
														if($stm = $db->query('SELECT wd.floor, wd.ward, bd.bed FROM beds bd LEFT JOIN wards wd ON(wd.id=bd.ward_id) WHERE bd.user_id='.$row['id'])->fetch()){
															echo $stm['floor']." этаж ".$stm['ward']." палата ".$stm['bed']." койка";
														}
														?>
													</div>
												</td>
												<td><?= date('d.m.Y', strtotime($div['dateBith'])) ?></td>
												<td><?= ($row['add_date']) ? date('d.m.Y H:i', strtotime($row['add_date'])) : '<span class="text-muted">Нет данных</span>' ?></td>
	                                            <td><?= $db->query("SELECT name FROM service WHERE id = {$div['service_id']}")->fetch()['name'] ?></td>
												<td>
													<?= level_name($row['route_id']) ." ". division_name($row['route_id']) ?>
													<div class="text-muted"><?= get_full_name($row['route_id']) ?></div>
												</td>
	                                            <td class="text-center">
	                                                <?php
	                                                if($div['direction']){
	                                                    ?>
	                                                    <span style="font-size:15px;" class="badge badge-flat border-danger text-danger-600">Стационарный</span>
	                                                    <?php
	                                                }else{
	                                                    ?>
	                                                    <span style="font-size:15px;" class="badge badge-flat border-primary text-primary">Амбулаторный</span>
	                                                    <?php
	                                                }
	                                                ?>
	                                            </td>
												<td class="text-center"><?= $row['qty'] ?></td>
	                                            <td class="text-center">
	                                            	<?php if (!division_assist()): ?>
	                                            		<a href="<?= up_url($row['visit_id'], 'VisitUpStatus') ?>&user_id=<?= $row['id'] ?>&route_id=<?= $row['route_id'] ?>" type="button" class="btn btn-outline-success btn-sm legitRipple">Принять</a>
	                                            	<?php else: ?>
	                                            		<button type="button" class="btn btn-outline-success btn-sm legitRipple" data-userid="<?= $row['user_id'] ?>" data-parentid="<?= $row['parent_id'] ?>"
															<?php if (!$row['direction']): ?>
																onclick="sendPatient(this)"
															<?php endif; ?>
	                                            			>Принять</button>
	                                            		<a href="<?= up_url($row['visit_id'], 'VisitUpStatus') ?>&user_id=<?= $row['id'] ?>" type="button" class="btn btn-outline-info btn-sm legitRipple">Снять</a>
	                                            	<?php endif; ?>
													<?php if ($div['complaint']): ?>
														<button onclick="swal('<?= $div['complaint'] ?>')" type="button" class="btn btn-outline-warning btn-sm legitRipple">Жалоба</button>
													<?php endif; ?>
													<button onclick="$('#vis_id').val(<?= $row['visit_id'] ?>); $('#vis_title').text('<?= get_full_name($row['id']) ?>');$('#renouncement').attr('data-userid', '<?= $row['user_id'] ?>'); $('#renouncement').attr('data-parentid', '<?= $row['parent_id'] ?>');" data-userid="<?= $row['user_id'] ?>" data-parentid="<?= $row['parent_id'] ?>" data-toggle="modal" data-target="#modal_failure" type="button" class="btn btn-outline-danger btn-sm legitRipple">Отказ</button>
	                                            </td>
	                                        </tr>
									<?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

					</div>

				</div>
			</td>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

    <!-- Failure modal -->
	<div id="modal_failure" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content border-1 border-danger">

				<div class="modal-header bg-danger">
					<h5 class="modal-title">Отказ приёма: <span id="vis_title"></h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<?= VisitFailure::form(); ?>
			</div>
		</div>
	</div>
	<!-- /failure modal -->

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
