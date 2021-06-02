<?php
require_once '../../tools/warframe.php';
$session->is_auth(5);
$header = "Приём пациетов";

$tb = new Table($db, "visit_services vs");
$tb->set_data("vs.id, vs.user_id, us.birth_date, vs.add_date, vs.service_name, vs.route_id")->additions("LEFT JOIN users us ON(us.id=vs.user_id)");
$search = $tb->get_serch();
$search_array = array(
	"vs.status = 2 AND ( (vs.parent_id IS NOT NULL AND vs.parent_id = $session->session_id) OR (vs.parent_id IS NULL AND vs.division_id == $session->session_division) )", 
	"vs.status = 2 AND ( (vs.parent_id IS NOT NULL AND vs.parent_id = $session->session_id) OR (vs.parent_id IS NULL AND vs.division_id == $session->session_division) )"
);
$tb->where_or_serch($search_array)->order_by('vs.id ASC')->set_limit(20);
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
                                    <tr class="<?= $classes['table-thead'] ?>">
                                        <th>ID</th>
                                        <th>ФИО</th>
										<th>Дата рождения</th>
                                        <th>Дата назначения</th>
                                        <th>Мед услуга</th>
                                        <th>Направитель</th>
                                        <th>Тип визита</th>
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
									dd($tb->get_table());                  


									$sql = "SELECT DISTINCT vs.id 'visit_id', us.id,
												vs.user_id, vs.parent_id, vs.add_date,
												vs.route_id, vs.service_id, vs.direction,
												us.dateBith
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
											<td><?= date('d.m.Y', strtotime($row['dateBith'])) ?></td>
											<td><?= ($row['add_date']) ? date('d.m.Y H:i', strtotime($row['add_date'])) : '<span class="text-muted">Нет данных</span>' ?></td>
                                            <td><?= $db->query("SELECT name FROM service WHERE id = {$row['service_id']}")->fetch()['name'] ?></td>
											<td>
												<?= level_name($row['route_id']) ." ". division_name($row['route_id']) ?>
												<div class="text-muted"><?= get_full_name($row['route_id']) ?></div>
											</td>
                                            <td class="text-center">
												<?php if($row['direction']): ?>
                                                    <span style="font-size:15px;" class="badge badge-flat border-danger text-danger-600">Стационарный</span>
												<?php else: ?>
                                                    <span style="font-size:15px;" class="badge badge-flat border-primary text-primary">Амбулаторный</span>
												<?php endif; ?>
                                            </td>
                                            <td class="text-center">
												<a href="<?= up_url($row['visit_id'], 'VisitUpStatus') ?>&user_id=<?= $row['id'] ?>" type="button" class="btn btn-outline-success btn-sm legitRipple" data-chatid="<?= $row['user_id'] ?>" data-userid="<?= $row['user_id'] ?>" data-parentid="<?= $row['parent_id'] ?>"
													<?php if (!$row['direction']): ?>
														onclick="sendPatient(this)"
													<?php endif; ?>
													>Принять</a>

                                                <button onclick="$('#vis_id').val(<?= $row['visit_id'] ?>); $('#vis_title').text('<?= get_full_name($row['id']) ?>'); $('#renouncement').attr('data-userid', '<?= $row['user_id'] ?>'); $('#renouncement').attr('data-parentid', '<?= $row['parent_id'] ?>');" data-toggle="modal" data-target="#modal_failure" type="button" data-userid="<?= $row['user_id'] ?>" data-parentid="<?= $row['parent_id'] ?>" class="btn btn-outline-danger btn-sm legitRipple">Отказ</button>
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

				<?= (new VisitFailure)->form(); ?>
			</div>
		</div>
	</div>
	<!-- /failure modal -->

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
