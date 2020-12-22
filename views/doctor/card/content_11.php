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

						<div class="row">

							<div class="col-md-12">

								<div class="card">

									<div class="card-header header-elements-inline">
										<h5 class="card-title"><?= $title ?></h5>
										<div class="header-elements">
											<div class="list-icons">
												<a class="list-icons-item">
													<i class="icon-plus22"></i>Добавить
												</a>
											</div>
										</div>
									</div>

									<div class="table-responsive">
										<table class="table table-hover table-sm">
											<thead>
												<tr class="bg-info">
													<th>1212</th>
													<th>1212</th>
													<th class="text-right" style="width: 50px">Действия</th>
												</tr>
											</thead>
											<tbody>
												<?php for($i=0; $i < 1; $i++): ?>
													<tr>
														<td>1212</td>
														<td>1212</td>
														<td>
															<button class="btn btn-outline-info btn-sm">Подробнее</button>
														</td>
													</tr>
												<?php endfor; ?>
											</tbody>
										</table>
									</div>

								</div>

							</div>

							<div class="col-md-6">

								<div class="card">

									<div class="card-header header-elements-inline">
										<h5 class="card-title"><?= $title ?></h5>
										<div class="header-elements">
											<div class="list-icons">
												<a class="list-icons-item">
													<i class="icon-plus22"></i>Добавить
												</a>
											</div>
										</div>
									</div>

									<div class="table-responsive">
										<table class="table table-hover table-sm">
											<thead>
												<tr class="bg-info">
													<th>1212</th>
													<th>1212</th>
													<th class="text-right" style="width: 50px">Действия</th>
												</tr>
											</thead>
											<tbody>
												<?php for($i=0; $i < 5; $i++): ?>
													<tr>
														<td>1212</td>
														<td>1212</td>
														<td>
															<button class="btn btn-outline-info btn-sm">Подробнее</button>
														</td>
													</tr>
												<?php endfor; ?>
											</tbody>
										</table>
									</div>

								</div>

							</div>

							<div class="col-md-6">

								<div class="card">

									<div class="card-header header-elements-inline">
										<h5 class="card-title">Препараты</h5>
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

    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
