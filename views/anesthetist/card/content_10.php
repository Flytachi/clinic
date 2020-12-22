<?php
require_once '../../../tools/warframe.php';
is_auth(11);
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

						<div class="row">

							<div class="col-md-6">

								<div class="card">

									<div class="card-header header-elements-inline">
										<h5 class="card-title">Осмотр</h5>
										<div class="header-elements">
											<div class="list-icons">
												<a class="list-icons-item text-success mr-1" data-toggle="modal" data-target="#modal_add_inspection">
													<i class="icon-plus22"></i>Осмотр
												</a>
											</div>
										</div>
									</div>

									<div class="table-responsive">
										<table class="table table-hover table-sm">
											<thead>
												<tr class="bg-info">
													<th>Дата и время осмотра</th>
													<th>Врач</th>
													<th class="text-right" style="width: 50%">Действия</th>
												</tr>
											</thead>
											<tbody>
												<?php if ($patient->direction): ?>
													<?php foreach ($db->query("SELECT * FROM visit_inspection WHERE visit_id = $patient->visit_id AND status_anest IS NOT NULL ORDER BY add_date DESC") as $row): ?>
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

							</div>

							<div class="col-md-6">

								<div class="card">

									<div class="card-header header-elements-inline">
										<h5 class="card-title">Препараты</h5>
										<div class="header-elements">
											<div class="list-icons">
												<a class="list-icons-item <?= $class_color_add ?>" data-toggle="modal" data-target="#modal_add">
													<i class="icon-plus22"></i>Добавить
												</a>
											</div>
										</div>
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

	<div id="modal_add" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-3 border-info">
				<div class="modal-header bg-info">
					<h5 class="modal-title">Добавить расходный материал</h5>
					<button type="button" class="close" data-dismiss="modal">×</button>
				</div>

				<?= StoragePreparatAnestForm::form() ?>

			</div>
		</div>
	</div>

	<div id="modal_add_inspection" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-info">
					<h6 class="modal-title">Осмотр</h6>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<?php VisitInspectionModel::form_anest() ?>

			</div>
		</div>
	</div>

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
