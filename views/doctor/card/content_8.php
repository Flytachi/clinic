<?php
require_once '../../../tools/warframe.php';
is_auth(5);
$header = "Пациент";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../layout/head.php' ?>

<script src="<?= stack('global_assets/js/demo_pages/form_multiselect.js') ?>"></script>

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
								<h6 class="card-title">Препараты</h6>
								<div class="header-elements">
									<div class="list-icons">
										<a class="list-icons-item text-success" data-toggle="modal" data-target="#modal_add">
											<i class="icon-plus22"></i>Добавить
										</a>
									</div>
								</div>
							</div>

							<div class="table-responsive">
								<table class="table table-hover table-sm table-bordered">
									<thead>
										<tr class="bg-info">
											<th style="width: 40px !important;">№ ---</th>
											<th class="text-center" style="width: 350px !important;">Препарат --------------------------------</th>
											<th class="text-center" style="width: 200px !important;">Описание --------------------------</th>
											<th class="text-center" style="width: 150px !important;">Метод введения ------------------------</th>
											<th class="text-center" style="width: 90px !important;">Время -----------</th>
											<th>01.21</th>
											<th>02.21</th>
											<th>03.21</th>
											<th>04.21</th>
											<th>05.21</th>
											<th>06.21</th>
											<th>07.21</th>
											<th>08.21</th>
											<th>09.21</th>
											<th>10.21</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$i=1;
										foreach ($db->query("SELECT * FROM bypass WHERE user_id = $patient->id") as $row) {
											?>
											<tr>
												<td onclick="Check('<?= viv('doctor/bypass') ?>?pk=<?= $row['id'] ?>')"><?= $i++ ?></td>
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
													<?php
													foreach ($db->query("SELECT * FROM bypass_time WHERE bypass_id = {$row['id']}") as $serv) {
														echo date('H:i', strtotime($serv['time']))."<br>";
													}
													?>
												</td>
												<td><input type="checkbox" name="" value=""></td>
												<td><input type="checkbox" name="" value=""></td>
												<td><input type="checkbox" name="" value=""></td>
												<td><input type="checkbox" name="" value=""></td>
												<td><input type="checkbox" name="" value=""></td>
												<td><input type="checkbox" name="" value=""></td>
												<td><input type="checkbox" name="" value=""></td>
												<td><input type="checkbox" name="" value=""></td>
												<td><input type="checkbox" name="" value=""></td>
												<td><input type="checkbox" name="" value=""></td>
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

	<div id="modal_add" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-3 border-info">
				<div class="modal-header bg-info">
					<h5 class="modal-title">Назначить препарат</h5>
					<button type="button" class="close" data-dismiss="modal">×</button>
				</div>

				<?= BypassModel::form() ?>

			</div>
		</div>
	</div>

	<div id="modal_show" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content" id="modal_show_body">

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
					$('#modal_show_body').html(data);
				},
			});
		};
	</script>

    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
