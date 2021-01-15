<?php
require_once '../../tools/warframe.php';
is_auth(5);
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
							<table class="table table-hover table-sm">
                                <thead>
                                    <tr class="bg-info">
                                        <th>ID</th>
                                        <th>ФИО</th>
										<th>Возраст</th>
                                        <th>Дата назначения</th>
                                        <th>Мед услуга</th>
                                        <th>Направитель</th>
                                        <th>Тип визита</th>
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
									$sql = "SELECT DISTINCT vs.id 'visit_id', us.id,
												vs.user_id, vs.parent_id, vs.add_date,
												vs.route_id, vs.service_id, vs.direction,
												(
													(YEAR(CURRENT_DATE) - YEAR(us.dateBith)) -
													(DATE_FORMAT(CURRENT_DATE, '%m%d') < DATE_FORMAT(us.dateBith, '%m%d'))
												) 'age'
											FROM users us
												LEFT JOIN visit vs ON(us.id=vs.user_id)
											WHERE vs.completed IS NULL AND vs.status = 1 AND vs.parent_id = {$_SESSION['session_id']}
											ORDER BY IFNULL(vs.priced_date, vs.add_date) ASC";
                                    foreach($db->query($sql) as $row) {
                                        ?>
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
											<td><?= $row['age'] ?></td>
											<td><?= ($row['add_date']) ? date('d.m.Y H:i', strtotime($row['add_date'])) : '<span class="text-muted">Нет данных</span>' ?></td>
                                            <td><?= $db->query("SELECT name FROM service WHERE id = {$row['service_id']}")->fetch()['name'] ?></td>
											<td>
												<?= level_name($row['route_id']) ." ". division_name($row['route_id']) ?>
												<div class="text-muted"><?= get_full_name($row['route_id']) ?></div>
											</td>
                                            <td class="text-center">
                                                <?php
                                                if($row['direction']){
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
                                            <td class="text-center">
												<a href="<?= up_url($row['visit_id'], 'VisitUpStatus') ?>&user_id=<?= $row['id'] ?>" type="button" class="btn btn-outline-success btn-sm legitRipple" data-chatid="<?= $row['user_id'] ?>" data-userid="<?= $row['user_id'] ?>" data-parentid="<?= $row['parent_id'] ?>"
													<?php if (!$row['direction']): ?>
														onclick="sendPatient(this)"
													<?php endif; ?>
													>Принять</a>
                                                <button onclick="$('#vis_id').val(<?= $row['visit_id'] ?>); $('#vis_title').text('<?= get_full_name($row['id']) ?>');" data-toggle="modal" data-target="#modal_failure" type="button" class="btn btn-outline-danger btn-sm legitRipple">Отказ</button>
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
