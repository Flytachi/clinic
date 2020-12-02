<?php
require_once '../../tools/warframe.php';
is_auth(10);
$header = "Амбулаторные пациенты";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>

<body>
	<!-- Main navbar -->
	<?php include '../layout/navbar.php' ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include '../layout/sidebar.php' ?>
		<!-- /main sidebar -->

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">


				<div class="card border-1 border-info">

					<div class="card-header text-dark header-elements-inline alpha-info">
						<h6 class="card-title">Амбулаторные пациенты</h6>
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
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
									if (division_assist() == 2) {
										$sql = "SELECT DISTINCT us.id, vs.id 'visit_id', us.dateBith, vs.route_id, vs.service_id, vs.parent_id, vs.assist_id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NULL AND vs.assist_id IS NOT NULL ORDER BY vs.add_date ASC";
									}elseif (division_assist() == 1) {
										$sql = "SELECT DISTINCT us.id, vs.id 'visit_id', us.dateBith, vs.route_id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NULL AND vs.assist_id IS NOT NULL ORDER BY vs.add_date ASC";
									}else {
										$sql = "SELECT DISTINCT us.id, vs.id 'visit_id', us.dateBith, vs.route_id FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NULL AND vs.parent_id = {$_SESSION['session_id']} ORDER BY vs.add_date ASC";
									}
                                    foreach($db->query($sql) as $row) {
										if (division_assist() == 2) {
											if ($row['parent_id'] == $row['assist_id']) {
												$tr = "";
											}elseif ($row['parent_id'] == $_SESSION['session_id']) {
												$tr = "table-success";
											}else {
												$tr = "table-danger";
											}
										}else {
											$tr = "";
										}
                                        ?>
                                        <tr class="<?= $tr ?>">
                                            <td><?= addZero($row['id']) ?></td>
                                            <td><div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div></td>
                                            <td><?= date('d.m.Y', strtotime($row['dateBith'])) ?></td>
                                            <td>
												<?php
												if (division_assist() == 2) {
													$sql_ser = "SELECT * FROM service WHERE id = {$row['service_id']}";
												}else {
													$sql_ser = "SELECT sc.name FROM visit vs LEFT JOIN service sc ON(vs.service_id=sc.id) WHERE vs.user_id = {$row['id']} AND vs.parent_id = {$_SESSION['session_id']} AND accept_date IS NOT NULL AND completed IS NULL";
												}
                                                foreach ($db->query($sql_ser) as $serv) {
                                                    echo $serv['name']."<br>";
                                                }
                                                ?>
                                            </td>
											<td>
												<?= level_name($row['route_id']) ." ". division_name($row['route_id']) ?>
												<div class="text-muted"><?= get_full_name($row['route_id']) ?></div>
											</td>
                                            <td class="text-center">
												<?php if ($tr != "table-danger"): ?>
													<button onclick="ResultShow('<?= up_url($row['visit_id'], 'VisitReport') ?>&user_id=<?= $row['id'] ?>')" class="btn btn-outline-primary btn-sm"><i class="icon-clipboard3 mr-2"></i>Заключение</button>
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


			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<div id="modal_result_show" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-3 border-info" id="modal_result_show_content">

			</div>
		</div>
	</div>

	<!-- Footer -->
	<?php include '../layout/footer.php' ?>
	<!-- /footer -->

	<script type="text/javascript">

		function ResultShow(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#modal_result_show').modal('show');
					$('#modal_result_show_content').html(result);
				},
			});
		};

	</script>
</body>
</html>
