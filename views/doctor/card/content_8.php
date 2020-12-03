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
								<div class="header-elements">
									<div class="list-icons">
										<a class="list-icons-item text-success" data-toggle="modal" data-target="#modal_add">
											<i class="icon-plus22"></i>Добавить
										</a>
									</div>
								</div>
							</div>

							<div class="table-responsive">
								<table class="table table-hover table-sm">
									<thead>
										<tr class="bg-info">
											<th style="width: 40px;">№</th>
											<th>Дата и время</th>
											<th>Записки врача</th>
											<th class="text-center">Действия</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$i=1;
										foreach ($db->query("SELECT * FROM bypass WHERE user_id = $patient->id") as $row) {
											?>
											<tr onclick="Check('<?= viv('doctor/bypass') ?>?pk=<?= $row['id'] ?>')">
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

				    <!-- /content wrapper -->
				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->

	<div id="modal_add" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-full">
			<div class="modal-content border-3 border-info">
				<div class="modal-header bg-info">
					<h5 class="modal-title">Добавить примечание</h5>
					<button type="button" class="close" data-dismiss="modal">×</button>
				</div>

            	<div class="modal-body">
					<div class="row">

						<div class="col-md-10 offset-md-1">
							<?= BypassModel::form() ?>
						</div>

						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table table-hover table-sm table-bordered">
									<thead>
										<tr class="bg-info">
											<th style="width: 40px;">№</th>
											<th style="width: 600px;">Препарат</th>
											<th>12.22</th>
											<th>12.22</th>
											<th>12.22</th>
											<th>12.22</th>
											<th>12.22</th>
											<th>12.22</th>
										</tr>
									</thead>
									<tbody>
										<?php $i =1; foreach ($db as $key => $value): ?>

										<?php endforeach; ?>
										<tr>
											<th>1</th>
											<th>1</th>
											<th>1</th>
											<th>1</th>
											<th>1</th>
											<th>1</th>
											<th>1</th>
											<th>1</th>
										</tr>
									</tbody>
								</table>
							</div>
						</div>

					</div>
				</div>

				<div class="modal-footer">
	                <button class="btn btn-outline-info legitRipple" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Закрыть</button>
	            </div>

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
