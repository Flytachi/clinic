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
				        <?php include "content_tabs.php"; ?>

						<div class="card">

							<div class="card-header header-elements-inline">
								<h5 class="card-title">Анализы Пациента</h5>
							</div>

							<div class="table-responsive">
								<table class="table table-hover table-sm">
									<thead>
										<tr class="bg-info">
											<th>№</th>
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
										foreach ($db->query("SELECT vs.id, vs.parent_id, vs.direction, vs.accept_date, vs.completed, vs.status, sc.name FROM visit vs LEFT JOIN service sc ON(vs.service_id=sc.id) WHERE vs.user_id = $patient->id AND vs.laboratory IS NOT NULL ORDER BY vs.id DESC") as $row) {
										?>
											<tr>
												<td><?= $i++ ?></td>
												<td>
													<?= level_name($row['parent_id']) ." ". division_name($row['parent_id']) ?>
													<div class="text-muted"><?= get_full_name($row['parent_id']) ?></div>
												</td>
												<td><?= ($row['accept_date']) ? date('d.m.Y  H:i', strtotime($row['accept_date'])) : '<span class="text-muted">Не принят</span>'?></td>
												<td><?= ($row['completed']) ? date('d.m.Y  H:i', strtotime($row['completed'])) : '<span class="text-muted">Не завершён</span>'?></td>
												<td><?= $row['name'] ?></td>
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
													<button onclick="Check('<?= viv('laboratory/report') ?>?pk=<?= $row['id'] ?>', 1)" class="btn btn-outline-info btn-sm legitRipple"><i class="icon-eye mr-2"></i> Просмотр</button>
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
