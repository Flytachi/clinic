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

				<?php include "../profile_card.php"; ?>

				<div class="card border-1 border-info">
				    <div class="card-header text-dark header-elements-inline alpha-info">
				        <h6 class="card-title">Просмотр визита</h6>
				    </div>

				    <div class="card-body">
				        <?php include "content_tabs.php"; ?>

						<div class="card-body">
							<div class="tab-content">
								<div class="tab-pane fade show active" id="bordered-rounded-justified-pill1">
									<div class="card-header bg-transparent header-elements-inline">
										<h6 class="card-title">Информация о койке</h6>
									</div>

									<table class="table tasks-list table-sm">
										<thead class="bg-blue">
											<tr class="text-center">
												<th>ID</th>
												<th>Расположение пациента</th>
												<th>Статус</th>
												<th>Дата размещение</th>
												<th>Дата Выписки</th>
												<th>Сутка</th>
												<th>Сумма</th>
												<th>Статус о выписке</th>
												<th>Действия</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>0001</td>

												<td>
													<div class="font-weight-semibold">Якубов Фарход Абдурасулович</div>
													<div class="text-muted">3-этаж 4-палата 2-койка</div>
												</td>
												<td>
													<div class="btn-group">
														<a href="#" class="dropdown-item active"><span class="badge badge-mark mr-2 bg-success border-success"></span> Размещён</a>
													</div>
												</td>
												<td>
													<div class="d-inline-flex align-items-center">
														<i class="icon-calendar2 mr-2"></i>
														<input type="text" class="form-control datepicker p-0 border-0 bg-transparent" value="13.03.2020 14:20" />
													</div>
												</td>
												<td>
													<div class="d-inline-flex align-items-center">
														<i class="icon-calendar2 mr-2"></i>
														<input type="text" class="form-control datepicker p-0 border-0 bg-transparent" value="16.03.2020 11:20" />
													</div>
												</td>
												<td>4</td>
												<td>400000</td>
												<td>
													<div class="btn-group">
														<a href="#" class="badge bg-danger dropdown-toggle" data-toggle="dropdown">Бронь</a>
														<div class="dropdown-menu dropdown-menu-right">
															<a href="#" class="dropdown-item active"><span class="badge badge-mark mr-2 bg-danger border-primary"></span> Бронь</a>
															<a href="#" class="dropdown-item"><span class="badge badge-mark mr-2 bg-orange border-orange"></span> Выписать</a>
														</div>
													</div>
												</td>

												<td class="text-center">
													<button type="button" class="btn alpha-blue text-blue-800 border-blue-600 legitRipple">Сохранить</button>
												</td>
											</tr>
										</tbody>
									</table>
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
