<?php
require_once '../../tools/warframe.php';
is_auth(10);
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
                                        <th>Дата рождения</th>
                                        <th>Мед услуга</th>
                                        <th>Направитель</th>
                                        <th>Тип визита</th>
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
									// prit($db->query("SELECT DISTINCT us.id, vs.id 'visit_id', us.dateBith, vs.route_id, vs.service_id, vs.direction FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 1 AND vs.parent_id = {$_SESSION['session_id']} ORDER BY vs.add_date ASC")->fetchAll());
                                    foreach($db->query("SELECT DISTINCT us.id, vs.id 'visit_id', vs.user_id, vs.parent_id, us.dateBith, vs.route_id, vs.service_id, vs.direction FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 1 AND vs.parent_id = {$_SESSION['session_id']} ORDER BY IFNULL(vs.priced_date, vs.add_date) ASC") as $row) {
                                        ?>
                                        <tr id="PatientFailure_tr_<?= $row['id'] ?>">
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
											<td><?= date('d.m.Y', strtotime($row['dateBith'])) ?></td>
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
                                            	<?php if (division_assist() == 2): ?>
                                            		<a href="<?= up_url($row['visit_id'], 'VisitUpStatus') ?>&user_id=<?= $row['id'] ?>" type="button" class="btn btn-outline-success btn-sm legitRipple" data-userid="<?= $row['user_id'] ?>" data-parentid="<?= $row['parent_id'] ?>" onclick="sendPatient(this)">Принять</a>
                                            	<?php else: ?>
                                            		<button type="button" class="btn btn-outline-success btn-sm legitRipple" data-userid="<?= $row['user_id'] ?>" data-parentid="<?= $row['parent_id'] ?>" onclick="sendPatient(this)">Принять</button>	
                                            		<a href="<?= up_url($row['visit_id'], 'VisitUpStatus') ?>&user_id=<?= $row['id'] ?>" type="button" class="btn btn-outline-info btn-sm legitRipple">Снять</a>
                                            	<?php endif; ?>
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

				<?= PatientFailure::form(); ?>
			</div>
		</div>
	</div>
	<!-- /failure modal -->

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
