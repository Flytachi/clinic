<?php
require_once '../../../tools/warframe.php';
is_auth(7);
$header = "Пациент";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../layout/head.php' ?>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switch.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>

<script src="<?= stack('global_assets/js/demo_pages/form_multiselect.js') ?>"></script>
<script src="<?= stack('global_assets/js/demo_pages/form_checkboxes_radios.js') ?>"></script>

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
							   <h6 class="card-title">Примечание Врача</h6>
						   </div>

						   <div class="table-responsive">
 							  <table class="table table-hover table-sm table-bordered">
 								  <thead>
 									  <tr class="bg-info">
 										  <th style="width: 40px !important;">№</th>
 										  <th style="width: 400px;">Препарат</th>
 										  <th>Описание</th>
 										  <th class="text-center" style="width: 150px;">Метод введения </th>
 										  <th class="text-right" style="width: 150px;">Действия</th>
 									  </tr>
 								  </thead>
 								  <tbody>
 									  <?php
 									  $i=1;
 									  foreach ($db->query("SELECT * FROM bypass WHERE user_id = $patient->id") as $row) {
 										  ?>
 										  <tr>
 											  <td><?= $i++ ?></td>
 											  <td>
 												  <?php
 												  foreach ($db->query("SELECT * FROM bypass_preparat WHERE bypass_id = {$row['id']}") as $serv) {
 													  echo $serv['preparat_id']." Препарат -------------<br>";
 												  }
 												  ?>
 											  </td>
 											  <td><?= $row['description'] ?></td>
 											  <td><?= $row['method'] ?></td>
 											  <td>
 												  <button type="button" class="btn btn-outline-info btn-sm legitRipple" data-toggle="modal" data-target="#modal_test">Подробнее</button>
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

	<div id="modal_test" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-3 border-info">
				<div class="modal-header bg-info">
					<h5 class="modal-title">Назначение</h5>
					<button type="button" class="close" data-dismiss="modal">×</button>
				</div>

				<div class="modal-body">

					<!-- Circle empty -->
					<div class="card card-body border-top-1 border-top-success">
						<div class="list-feed list-feed-rhombus list-feed-solid">
							<div class="list-feed-item border-info">
								<strong>Врач: </strong>Якубов Фарход Хврвргврйцгв
							</div>

							<div class="list-feed-item border-info">
								<strong>Метод: </strong>В/В
							</div>

							<div class="list-feed-item border-info">
								<strong>Последнее обновление: </strong>21.03.2019 16:00
							</div>

							<div class="list-feed-item border-info">
								<strong>Препарат: </strong>1 Препарат -------------
							</div>

							<div class="list-feed-item border-info">
								<strong>Описание: </strong>2 раза в день 1/2 таб
							</div>
						</div>
					</div>
					<!-- /circle empty -->

					<div class="table-responsive">
						<table class="table table-xs table-bordered">
							<thead>
								<tr class="bg-info">
									<th style="width: 50%">Дата</th>
									<th style="width: 30%">Время</th>
									<th colspan="2" class="text-center">Коструктор</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td rowspan="2">12.21.2019</td>
									<td>01:00</td>
									<td class="text-success text-center">
										<i style="font-size:1.5rem;" class="icon-checkmark-circle2" data-popup="tooltip" data-placement="bottom" data-original-title="Комментарий медсестры"></i>
									</td>
									<td class="text-center">
										<div class="form-check form-check-right form-check-switchery">
											<label class="form-check-label">
												<input type="checkbox" class="form-check-input-switchery" checked data-fouc disabled>
											</label>
										</div>
									</td>
								</tr>
								<tr>
									<td>07:00</td>
									<td class="text-success text-center">
										<i style="font-size:1.5rem;" class="icon-checkmark-circle2" data-popup="tooltip" data-placement="bottom" data-original-title="Комментарий медсестры"></i>
									</td>
									<td class="text-center">
										<div class="form-check form-check-right form-check-switchery">
											<label class="form-check-label">
												<input type="checkbox" class="form-check-input-switchery" checked data-fouc>
											</label>
										</div>
									</td>
								</tr>

								<tr>
									<td rowspan="2">13.21.2019</td>
									<td>01:00</td>
									<td class="text-success text-center">
		                                <i style="font-size:1.5rem;" class="icon-checkmark-circle2" data-popup="tooltip" data-placement="bottom" data-original-title="Комментарий медсестры"></i>
									</td>
									<td class="text-center">
										<div class="form-check form-check-right form-check-switchery">
											<label class="form-check-label">
												<input type="checkbox" class="form-check-input-switchery" data-fouc>
											</label>
										</div>
									</td>
								</tr>
								<tr>
									<td>07:00</td>
									<td class="text-secondary text-center">
		                                <i style="font-size:1.5rem;" class="icon-close2"></i>
									</td>
									<td class="text-center">
										<div class="form-check form-check-right form-check-switchery">
											<label class="form-check-label">
												<input type="checkbox" class="form-check-input-switchery" data-fouc>
											</label>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>

				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-outline-info btn-sm legitRipple" data-dismiss="modal">Закрыть</button>
				</div>

			</div>
		</div>
	</div>

    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
