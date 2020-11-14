<?php
require_once '../../tools/warframe.php';
is_auth(2);
$header = "Рабочий стол";
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
					<li class="nav-item"><a href="#basic-justified-tab1" class="nav-link legitRipple active show" data-toggle="tab">Регистрация</a></li>
					<li class="nav-item"><a href="#basic-justified-tab2" class="nav-link legitRipple" data-toggle="tab">Стационарная</a></li>
					<li class="nav-item"><a href="#basic-justified-tab3" class="nav-link legitRipple" data-toggle="tab">Амбулаторная</a></li>
					<li class="nav-item"><a href="#basic-justified-tab4" class="nav-link legitRipple" data-toggle="tab">Список пациетов</a></li>
				</ul>

				<div class="tab-content">

					<div class="tab-pane fade active show" id="basic-justified-tab1">

						<div class="card border-1 border-info">

							<div class="card-header text-dark header-elements-inline alpha-info">
								<h6 class="card-title">Регистрация</h6>
								<div class="header-elements">
									<div class="list-icons">
				                		<a class="list-icons-item" data-action="collapse"></a>
				                	</div>
			                	</div>
							</div>

							<div class="card-body" style="" id="form_up">
								<?php PatientForm::form(); ?>
							</div>

						</div>

					</div>

					<div class="tab-pane fade" id="basic-justified-tab2">

						<div class="card border-1 border-info">

							<div class="card-header text-dark header-elements-inline alpha-info">
								<h6 class="card-title">Стационарная</h6>
								<div class="header-elements">
									<div class="list-icons">
				                		<a class="list-icons-item" data-action="collapse"></a>
				                	</div>
			                	</div>
							</div>

							<div class="card-body">
								<?php StationaryTreatmentForm::form(); ?>
							</div>

						</div>

					</div>

					<div class="tab-pane fade" id="basic-justified-tab3">

						<div class="card border-1 border-info">

							<div class="card-header text-dark header-elements-inline alpha-info">
								<h6 class="card-title">Амбулаторная</h6>
								<div class="header-elements">
									<div class="list-icons">
				                		<a class="list-icons-item" data-action="collapse"></a>
				                	</div>
			                	</div>
							</div>

							<div class="card-body">
								<?php OutpatientTreatmentForm::form(); ?>
							</div>

						</div>

					</div>

					<div class="tab-pane fade" id="basic-justified-tab4">

						<div class="card border-1 border-info">

							<div class="card-header text-dark header-elements-inline alpha-info">
								<h6 class="card-title">Список Пациетов</h6>
								<div class="header-elements">
									<form action="#">
										<div class="form-group-feedback form-group-feedback-right">
											<input type="search" class="form-control wmin-200" placeholder="Search...">
											<div class="form-control-feedback">
												<i class="icon-search4 font-size-base text-muted"></i>
											</div>
										</div>
									</form>
			                	</div>
							</div>

							<div class="card-body" style="">

								<div class="table-responsive">
									<table class="table table-hover table-sm table-bordered">
										<thead>
											<tr class="bg-info">
												<th>ID</th>
												<th>ФИО</th>
												<th>Дата рождение</th>
												<th>Телефон</th>
												<th>Регион</th>
												<th>Дата визита</th>
												<th>Тип визита</th>
												<th>Статус</th>
												<th class="text-center">Действия</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$i = 1;
											foreach($db->query('SELECT * FROM users WHERE user_level = 15 ORDER BY add_date DESC') as $row) {
												?>
												<tr>
													<td><?= addZero($row['id']) ?></td>
													<td>
														<div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div>
														<div class="text-muted">
															<?php
															if($stm = $db->query('SELECT floor, ward, num FROM beds WHERE user_id='.$row['id'])->fetch()){
																echo $stm['floor']." этаж ".$stm['ward']." палата ".$stm['num']." койка";
															}
															?>
														</div>
													</td>
													<td><?= $row['dateBith'] ?></td>
													<td><?= $row['numberPhone'] ?></td>
													<td><?= $row['region'] ?></td>
													<td><?= $row['add_date'] ?></td>
													<?php
													if($stm_dr = $db->query('SELECT direction, status FROM visit WHERE completed IS NULL AND user_id='.$row['id'])->fetch()){
														if($stm_dr['direction']){
															?>
															<td>
																<span style="font-size:15px;" class="badge badge-flat border-danger text-danger-600">Стационарный</span>
															</td>
															<td>
																<?php
																switch ($stm_dr['status']):
																    case 1:
																		?>
																		<span style="font-size:15px;" class="badge badge-flat border-success text-success">Размещён</span>
																		<?php
																        break;
																    case 2:
																		?>
																		<span style="font-size:15px;" class="badge badge-flat border-success text-success">Активный</span>
																		<?php
																        break;
																	default:
																		?>
																		<span style="font-size:15px;" class="badge badge-flat border-secondary text-secondary">Закрытый</span>
																		<?php
																		break;
																endswitch;
																?>
															</td>
															<?php
														}else{
															?>
															<td>
																<span style="font-size:15px;" class="badge badge-flat border-primary text-primary">Амбулаторный</span>
															</td>
															<td>
																<?php
																switch ($stm_dr['status']):
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
																?>
															</td>
															<?php
														}
													}else {
														?>
															<td>
																<span style="font-size:15px;" class="badge badge-flat border-grey text-grey-600">Закрытый</span>
															</td>
															<td>
																<span style="font-size:15px;" class="badge badge-flat border-grey text-grey-300">Не активный</span>
															</td>
														<?php
													}
												  	?>
													<td class="text-center">
														<button onclick="Update('<?= up_url($row['id'], 'PatientForm') ?>')" type="button" class="btn btn-outline-primary btn-sm legitRipple">Редактировать</button>
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

	<script type="text/javascript">
		function Update(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#form_up').html(result);
					TabControl('basic-justified-tab1');
				},
			});
		};
	</script>

</body>
</html>
