<?php
require_once '../../../tools/warframe.php';
is_auth(7);
$header = "Пациент";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../layout/head.php' ?>
<script src="<?= stack("global_assets/js/plugins/visualization/echarts/echarts.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/charts/echarts/lines.js") ?>"></script>

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

						<div class="row">

							<?php if ($patient->oper_date): ?>
								<div class="col-md-7">

									<div class="card border-1 border-success">
										<div class="card-header header-elements-inline alpha-success">
											<h5 class="card-title">Динамика показателей</h5>
											<div class="header-elements">
												<div class="list-icons">
													<a class="list-icons-item" data-action="collapse"></a>
												</div>
											</div>
										</div>

										<div class="card-body">
											<div class="chart-container">
												<div class="chart has-fixed-height" id="line_stat"></div>

												<div style="display:none;">
													<?php foreach ($db->query("SELECT pressure, pulse, temperature, saturation, add_date FROM user_stats WHERE visit_id=$patient->visit_id AND status = 2 ORDER BY add_date DESC") as $row): ?>
														<span class="chart_date"><?= date('H:i', strtotime($row['add_date'])) ?></span>
														<span class="chart_pressure"><?= $row['pressure'] ?></span>
														<span class="chart_pulse"><?= $row['pulse'] ?></span>
														<span class="chart_temperature"><?= $row['temperature'] ?></span>
														<span class="chart_saturation"><?= $row['saturation'] ?></span>
													<?php endforeach; ?>
												</div>

											</div>
										</div>
									</div>

									<div class="card">

										<div class="card-header header-elements-inline">
											<h5 class="card-title">Препараты Анестезиолога</h5>
										</div>

										<div class="table-responsive">
											<table class="table table-hover table-sm">
											   <thead>
												   <tr class="bg-info">
													   <th style="width: 40px !important;">№</th>
													   <th>Препарат</th>
													   <th style="width: 200px;">Цена ед.</th>
													   <th style="width: 200px;">Сумма</th>
													   <th style="width: 100px;">Сегоня</th>
													   <th style="width: 100px;">Всего</th>
												   </tr>
											   </thead>
											   <tbody>
												   <?php
												   $sql = "SELECT DISTINCT vp.item_id,
															 vp.item_name,
															 vp.item_cost,
															 vp.item_cost * (SELECT COUNT(*) FROM visit_price WHERE visit_id = $patient->visit_id AND item_type = 4 AND item_id = vp.item_id) 'price',
															 (SELECT COUNT(*) FROM visit_price WHERE visit_id = $patient->visit_id AND item_type = 4 AND item_id = vp.item_id AND DATE_FORMAT(add_date, '%Y-%m-%d') = CURRENT_DATE()) 'count_every',
															 (SELECT COUNT(*) FROM visit_price WHERE visit_id = $patient->visit_id AND item_type = 4 AND item_id = vp.item_id) 'total_count_all'
														 FROM visit_price vp
														 WHERE vp.visit_id = $patient->visit_id AND vp.item_type = 4";
												   $total_total_price = $total_count_every = $total_count_all = 0;
												   ?>
												   <?php $i=1; foreach ($db->query($sql) as $row): ?>
													   <tr>
														   <td><?= $i++ ?></td>
														   <td><?= $row['item_name'] ?></td>
														   <td><?= $row['item_cost'] ?></td>
														   <td>
															 <?php
																 $total_total_price += $row['price'];
																 echo number_format($row['price']);
															 ?>
														   </td>
														   <td>
															 <?php
																 $total_count_every += $row['count_every'];
																 echo number_format($row['count_every']);
															 ?>
														   </td>
														   <td>
															   <?php
																 $total_count_all += $row['total_count_all'];
																 echo number_format($row['total_count_all']);
																 ?>
														   </td>
													   </tr>
												   <?php endforeach; ?>

												   <tr class="table-primary">
													   <td colspan="3">Итог:</td>
													   <td><?= number_format($total_total_price) ?></td>
													   <td><?= $total_count_every ?></td>
													   <td><?= $total_count_all ?></td>
												   </tr>
											   </tbody>
										   </table>
									   </div>

									</div>

								</div>

								<div class="col-md-5">

									<div class="card">

										<div class="card-header header-elements-inline">
											<h5 class="card-title">Операционный осмотр</h5>
										</div>

										<div class="table-responsive">
											<table class="table table-hover table-sm">
												<thead>
													<tr class="bg-info">
														<th>Дата и время осмотра</th>
														<th class="text-right">Действия</th>
													</tr>
												</thead>
												<tbody>
													<?php if ($patient->direction): ?>
														<?php foreach ($db->query("SELECT * FROM visit_inspection WHERE visit_id = $patient->visit_id AND status = 2 ORDER BY add_date DESC") as $row): ?>
															<tr>
																<td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
																<td class="text-right">
																	<button onclick="Check('<?= viv('doctor/inspection') ?>?pk=<?= $row['id'] ?>')" type="button" class="btn btn-outline-info btn-sm legitRipple"><i class="icon-eye mr-2"></i> Просмотр</button>
																</td>
															</tr>
														<?php endforeach; ?>
													<?php endif; ?>
												</tbody>
											</table>
										</div>

									</div>

									<div class="card">

										<div class="card-header header-elements-inline">
											<h5 class="card-title">Осмотр Анестезиолога</h5>
										</div>

										<div class="table-responsive">
											<table class="table table-hover table-sm">
												<thead>
													<tr class="bg-info">
														<th>Дата и время осмотра</th>
														<th>Врач</th>
														<th class="text-right">Действия</th>
													</tr>
												</thead>
												<tbody>
													<?php if ($patient->direction): ?>
														<?php foreach ($db->query("SELECT * FROM visit_inspection WHERE visit_id = $patient->visit_id AND status = 1 ORDER BY add_date DESC") as $row): ?>
															<tr>
																<td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
																<td><?= get_full_name($row['parent_id']) ?></td>
																<td class="text-right">
																	<button onclick="Check('<?= viv('doctor/inspection') ?>?pk=<?= $row['id'] ?>')" type="button" class="btn btn-outline-info btn-sm legitRipple"><i class="icon-eye mr-2"></i> Просмотр</button>
																</td>
															</tr>
														<?php endforeach; ?>
													<?php endif; ?>
												</tbody>
											</table>
										</div>

									</div>

									<div class="card">

										<div class="card-header header-elements-inline">
											<h5 class="card-title">Персонал</h5>
										</div>

										<div class="table-responsive">
											<table class="table table-hover table-sm">
												<thead>
													<tr class="bg-info">
														<th>ФИО</th>
													</tr>
												</thead>
												<tbody>
													<?php if ($patient->direction): ?>
														<?php foreach ($db->query("SELECT * FROM visit_member WHERE visit_id = $patient->visit_id") as $row): ?>
															<tr>
																<td><?= get_full_name($row['member_id']) ?></td>
															</tr>
														<?php endforeach; ?>
													<?php endif; ?>
												</tbody>
											</table>
										</div>

									</div>

								</div>
							<?php else: ?>
								<div class="col-md-12">
									<div class="alert alert-warning" role="alert">
										Операция не назначена
									</div>
								</div>
							<?php endif; ?>

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

	<div id="modal_show" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-3 border-info" id="div_show">

			</div>
		</div>
	</div>

	<script type="text/javascript">
		function Check(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (data) {
					$('#modal_show').modal('show');
					$('#div_show').html(data);
				},
			});
		};
	</script>

    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
