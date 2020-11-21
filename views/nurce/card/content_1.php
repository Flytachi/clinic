<?php
require_once '../../../tools/warframe.php';
is_auth(7);
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
				        <?php
						include "content_tabs.php";

						if($_SESSION['message']){
				            echo $_SESSION['message'];
				            unset($_SESSION['message']);
				        }
						?>

						<div class="row">

							<div class="col-md-6">
								<div class="card">
									<div class="card-header header-elements-inline">
										<h5 class="card-title">Примечание Врача</h5>
									</div>
									<div class="table-responsive">
										<table class="table">
											<thead class="bg-info">
												<tr>
													<th style="width: 40px;">№</th>
													<th>Дата и время</th>
													<th>Записки врача</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$i=1;
												foreach ($db->query("SELECT * FROM bypass WHERE status IS NOT NULL AND user_id = $patient->user_id") as $row) {
													?>
													<tr onclick="Check('<?= viv('nurce/bypass') ?>?pk=<?= $row['id'] ?>')">
														<td><?= $i++ ?></td>
														<td><?= date('d.m.Y  H:i', strtotime($row['add_date'])) ?></td>
														<td class="text-primary"><?= get_full_name($row['parent_id']) ?></td>
													</tr>
													<?php
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="card">

									<div class="card-header header-elements-inline">
										<h5 class="card-title">Примечание Медсестры</h5>
										<div class="header-elements">
											<div class="list-icons">
												<a class="list-icons-item text-success" data-toggle="modal" data-target="#modal_add">
													<i class="icon-plus22"></i>Добавить
												</a>
											</div>
										</div>
									</div>

									<div class="table-responsive">
										<table class="table">
											<thead class="bg-info">
												<tr>
													<th style="width: 40px;">№</th>
													<th>Дата и время</th>
													<th>Записки медсестры</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$i=1;
												foreach ($db->query("SELECT * FROM bypass WHERE status IS NULL AND user_id = $patient->user_id") as $row) {
													?>
													<tr onclick="Check('<?= viv('nurce/bypass') ?>?pk=<?= $row['id'] ?>')">
														<td><?= $i++ ?></td>
														<td><?= date('d.m.Y  H:i', strtotime($row['add_date'])) ?></td>
														<td class="text-primary"><?= get_full_name($row['parent_id']) ?></td>
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

				    <!-- /content wrapper -->
				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->

	<div id="modal_add" class="modal fade" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content border-3 border-info">
				<div class="modal-header bg-info">
					<h5 class="modal-title">Добавить примечание</h5>
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
