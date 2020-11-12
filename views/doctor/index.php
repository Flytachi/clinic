<?php
require_once '../../tools/warframe.php';
is_auth();
$header = "Мои пациенты";
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

				<ul class="nav nav-tabs nav-tabs-bottom nav-justified">
					<li class="nav-item"><a href="#colored-rounded-justified-tab1" class="nav-link rounded-left legitRipple active show" data-toggle="tab">Амбулаторные пациенти</a></li>
					<li class="nav-item"><a href="#colored-rounded-justified-tab2" class="nav-link legitRipple" data-toggle="tab">Стационарные пациенти</a></li>
				</ul>

				<div class="tab-content">

					<div class="tab-pane fade active show" id="colored-rounded-justified-tab1">

						<div class="card">

							<div class="card-header header-elements-inline">
								<h5>Список Пациетов</h5>
						        <div class="header-elements">
									<div class="dataTables_filter">
										<label>
											<span>Поиск:</span>
											<input type="search" class="form-control border-success" placeholder="Введите ID или имя" >
										</label>
									</div>
						        </div>
							</div>

							<div class="card-body">

								<div class="table-responsive shadow-0 mb-0">
									<table class="table table-hover table-columned">
										<thead>
											<tr class="bg-blue text-center">
												<th>ID</th>
												<th>ФИО</th>
												<th>Дата визита</th>
												<th>Возраст</th>
												<th>Мед услуга</th>
												<th>Тип визита</th>
												<th>Направление</th>
												<th class="text-center">Действия</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td>2</td>

												<td>5</td>
												<td>6</td>
												<td>7</td>
												<td>8</td>
												<td>9</td>
												<td class="text-center">
													<button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
													<div class="dropdown-menu dropdown-menu-right">
														<a href="outpatient.php" class="dropdown-item"><i class="icon-fire2"></i> Анализи Лаборатория</a>
														<a href="#" class="dropdown-item"><i class="icon-add"></i> Добавить визит</a>
														<a href="#" class="dropdown-item"><i class="icon-repo-forked"></i> Осмотр Врача</a>
														<a href="#" class="dropdown-item"><i class="icon-plus-circle2"></i> Другие визити</a>
													</div>
												</td>
											</tr>
											<tr>
												<td>1</td>
												<td>2</td>

												<td>5</td>
												<td>5</td>
												<td>6</td>
												<td>7</td>
												<td>8</td>
												<td class="text-center">
													<button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>				  <div class="dropdown-menu dropdown-menu-right">
														<a href="outpatient.php" class="dropdown-item"><i class="icon-fire2"></i> Анализи Лаборатория</a>
														<a href="#" class="dropdown-item"><i class="icon-add"></i> Добавить визит</a>
														<a href="#" class="dropdown-item"><i class="icon-repo-forked"></i> Осмотр Врача</a>
														<a href="#" class="dropdown-item"><i class="icon-plus-circle2"></i> Другие визити</a>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>

							</div>

						</div>

					</div>

					<div class="tab-pane fade" id="colored-rounded-justified-tab2">

						<div class="card">

							<div class="card-header header-elements-inline">
								<h5>Список Пациетов</h5>
						        <div class="header-elements">
									<div class="dataTables_filter">
										<label>
											<span>Поиск:</span>
											<input type="search" class="form-control border-success" placeholder="Введите ID или имя" >
										</label>
									</div>
						        </div>
							</div>

							<div class="card-body">

								<div class="table-responsive shadow-0 mb-0">
									<table class="table table-hover table-columned">
										<thead>
											<tr class="bg-blue text-center">
												<th>ID</th>
												<th>Имя</th>
												<th>Фамилия</th>
												<th>Отчество</th>
												<th>Дата визита</th>
												<th>Суток</th>
												<th>Койка</th>
												<th>Возраст</th>
												<th class="text-center">Действия</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td>2</td>
												<td>3</td>
												<td>4</td>
												<td>5</td>
												<td>6</td>
												<td>7</td>
												<td>8</td>
												<td class="text-center">
													<button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
													<div class="dropdown-menu dropdown-menu-right">
														<a href="hospital.php" class="dropdown-item"><i class="icon-user-plus"></i>Обход</a>
														<a href="#" class="dropdown-item"><i class="icon-fire2"></i> Анализи Лаборатория</a>
														<a href="#" class="dropdown-item"><i class="icon-clipboard3"></i>Назначение врача</a>
														<a href="#" class="dropdown-item"><i class="icon-clipboard2"></i> Записи медсестры</a>
														<a href="#" class="dropdown-item"><i class="icon-diff-ignored"></i> Анестизиолог</a>
														<a href="#" class="dropdown-item"><i class="icon-file-eye"></i> Операционные</a>
													</div>
												</td>
											</tr>
											<tr>
												<td>1</td>
												<td>2</td>
												<td>3</td>
												<td>4</td>
												<td>5</td>
												<td>6</td>
												<td>7</td>
												<td>8</td>
												<td class="text-center">
													<button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
													<div class="dropdown-menu dropdown-menu-right">
														<a href="hospital" class="dropdown-item"><i class="icon-user-plus"></i>Обход</a>
														<a href="#" class="dropdown-item"><i class="icon-fire2"></i> Анализи Лаборатория</a>
														<a href="#" class="dropdown-item"><i class="icon-clipboard3"></i>Назначение врача</a>
														<a href="#" class="dropdown-item"><i class="icon-clipboard2"></i> Записи медсестры</a>
														<a href="#" class="dropdown-item"><i class="icon-diff-ignored"></i> Анестизиолог</a>
														<a href="#" class="dropdown-item"><i class="icon-file-eye"></i> Операционные</a>
													</div>
												</td>
											</tr>
											<tr>
												<td>1</td>
												<td>2</td>
												<td>3</td>
												<td>4</td>
												<td>5</td>
												<td>6</td>
												<td>7</td>
												<td>8</td>
												<td class="text-center">
													<button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
													<div class="dropdown-menu dropdown-menu-right">
														<a href="#" class="dropdown-item"><i class="icon-user-plus"></i>Обход</a>
														<a href="#" class="dropdown-item"><i class="icon-fire2"></i> Анализи Лаборатория</a>
														<a href="#" class="dropdown-item"><i class="icon-clipboard3"></i>Назначение врача</a>
														<a href="#" class="dropdown-item"><i class="icon-clipboard2"></i> Записи медсестры</a>
														<a href="#" class="dropdown-item"><i class="icon-diff-ignored"></i> Анестизиолог</a>
														<a href="#" class="dropdown-item"><i class="icon-file-eye"></i> Операционные</a>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>

							</div>

						</div>

					</div>

				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->





    <!-- Footer -->
    <?php include 'layout/footer.php' ?>
    <!-- /footer -->

</body>
</html>
