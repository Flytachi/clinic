<?php
require_once '../../../tools/warframe.php';
is_auth(5);
$header = "Пациент";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../layout/head.php' ?>

<body>

	<!-- Main navbar -->
	<?php include '../../layout/navbar.php' ?>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">
		<!-- Main sidebar -->
		<?php include '../../layout/sidebar.php' ?>
		<!-- /main sidebar -->

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

				<?php include "profile.php"; ?>

				<div class="card border-1 border-info">
				    <div class="card-header text-dark header-elements-inline alpha-info">
				        <h6 class="card-title">Просмотр визита</h6>
				    </div>

				    <div class="card-body">
				        <?php
						include "content_tabs.php";
						if($_SESSION['message']){
				            echo $_SESSION['message'];
				            unset($_SESSION['message']);
				        }
						?>

						<div class="card">

							<div class="card-header header-elements-inline">
								<h5 class="card-title">Назначенные Визиты</h5>
								<div class="header-elements">
									<div class="list-icons">
										<a class="list-icons-item text-success" data-toggle="modal" data-target="#modal_route">
											<i class="icon-plus22"></i>Добавить
										</a>
									</div>
								</div>
							</div>

							<div class="table-responsive">
								<table class="table table-togglable table-hover">
									<thead>
										<tr class="bg-info text-center">
											<th>#</th>
				                            <th>Специалист</th>
											<th>Дата визита</th>
											<th>Дата завершения</th>
				                            <th>Мед услуга</th>
											<th>Тип визита</th>
											<th>Статус</th>
											<th class="text-center">Действия</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$i = 1;
										foreach ($db->query("SELECT id, parent_id, direction, accept_date, completed, status, laboratory FROM visit WHERE user_id = $patient->user_id AND route_id = {$_SESSION['session_id']} ORDER BY id DESC") as $row) {
										?>
											<tr class="text-center">
												<td><?= $i++ ?></td>
												<td><?= get_full_name($row['parent_id']) ?></td>
												<td><?= ($row['accept_date']) ? date('d.m.Y  H:i', strtotime($row['accept_date'])) : '<span class="text-muted">Не активный</span>'?></td>
												<td><?= ($row['completed']) ? date('d.m.Y  H:i', strtotime($row['completed'])) : '<span class="text-muted">Не активный</span>'?></td>
												<td>
	                                                <?php
	                                                foreach ($db->query('SELECT sr.name FROM visit_service vsr LEFT JOIN service sr ON (vsr.service_id = sr.id) WHERE visit_id ='. $row['id']) as $serv) {
	                                                    echo $serv['name']."<br>";
	                                                }
	                                                ?>
	                                            </td>
												<td><?= ($row['direction']) ? "Стационарный" : "Амбулаторный" ?></td>
												<td>
													<?php
													if ($row['completed']) {
														?>
														<span style="font-size:15px;" class="badge badge-flat border-success text-success">Завершена</span>
														<?php
													} else {
														switch ($row['status']):
															case 1:
																?>
																<span style="font-size:15px;" class="badge badge-flat border-orange text-orange">Ожидание</span>
																<?php
																break;
															case 2:
																?>
																<span style="font-size:15px;" class="badge badge-flat border-success text-success">У специолиста</span>
																<?php
																break;
															default:
																?>
																<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Оплачивается</span>
																<?php
																break;
														endswitch;
													}
													?>
												</td>
												<td class="text-center">
													<button type="button" class="btn btn-outline-info btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
													<div class="dropdown-menu dropdown-menu-right">
														<?php
														if ($row['laboratory']) {
															?>
															<a onclick="Check('<?= viv('laboratory/report') ?>?pk=<?= $row['id'] ?>', 1)" class="dropdown-item"><i class="icon-fire2"></i>Анализы</a>
															<?php
														} else {
															?>
															<a onclick="Check('<?= viv('doctor/report') ?>?pk=<?= $row['id'] ?>')" class="dropdown-item"><i class="icon-paste2"></i>Заключения врача</a>
															<?php
														}
														?>
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

	<div id="modal_route" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-info">
					<h6 class="modal-title">Назначить визит</h6>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">

					<?php
					if ($patient->direction) {
						PatientRouteStationary::form();
					} else {
						PatientRoute::form();
					}
					?>

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
		function Check(events, imp='') {
			$.ajax({
				type: "GET",
				url: events,
				success: function (data) {
					if (imp) {
						$('#modal_class_show').removeClass("modal-lg");
						$('#modal_class_show').addClass("modal-full");
					}else {
						$('#modal_class_show').removeClass("modal-full");
						$('#modal_class_show').addClass("modal-lg");
					}
					$('#modal_report_show').modal('show');
					$('#report_show').html(data);
				},
			});
		};
	</script>

    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
