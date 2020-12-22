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
												<tr>
													<?php for($i=0; $i < 5; $i++): ?>
														<tr>
															<td>1212</td>
															<td>1212</td>
															<td>
																<button class="btn btn-outline-info btn-sm">Подробнее</button>
															</td>
														</tr>
													<?php endfor; ?>
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
