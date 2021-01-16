<?php
require_once '../../../tools/warframe.php';
is_auth([5,8]);
$header = "Пациент";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../layout/head.php' ?>
<script src="<?= stack("global_assets/js/plugins/forms/selects/bootstrap_multiselect.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/components_popups.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/form_multiselect.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_checkboxes_radios.js") ?>"></script>

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
								<h6 class="card-title">Лист назначений</h6>
								<div class="header-elements">
									<div class="list-icons">
										<a onclick="List('<?= viv('doctor/bypass_list') ?>?pk=<?= $patient->visit_id ?>')" class="list-icons-item text-info mr-2">
											<i class="icon-list"></i> Лист
										</a>
										<?php if ($patient->direction and $patient->grant_id == $_SESSION['session_id']): ?>
											<a class="list-icons-item <?= $class_color_add ?>" data-toggle="modal" data-target="#modal_add">
												<i class="icon-plus22"></i>Добавить
											</a>
										<?php endif; ?>
									</div>
								</div>
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
										foreach ($db->query("SELECT * FROM bypass WHERE user_id = $patient->id AND visit_id = $patient->visit_id") as $row) {
											?>
											<tr>
												<td><?= $i++ ?></td>
												<td>
													<?php
													foreach ($db->query("SELECT pt.product_code FROM bypass_preparat bp LEFT JOIN products pt ON(bp.preparat_id=pt.product_id) WHERE bp.bypass_id = {$row['id']}") as $serv) {
														echo $serv['product_code']."<br>";
													}
													?>
												</td>
												<td><?= $row['description'] ?></td>
												<td><?= $methods[$row['method']] ?></td>
												<td>
													<button onclick="Check('<?= viv('doctor/bypass') ?>?pk=<?= $row['id'] ?>')" type="button" class="btn btn-outline-info btn-sm legitRipple">Подробнее</button>
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
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-3 border-info" id="div_show">

			</div>
		</div>
	</div>

	<div id="modal_list" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-3 border-info" id="div_list">

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

		function List(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (data) {
					$('#modal_list').modal('show');
					$('#div_list').html(data);
				},
			});
		};
	</script>

    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
