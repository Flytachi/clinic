<?php
require_once '../../../tools/warframe.php';
is_auth(11);
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

						<?php include "content_tabs.php"; ?>

						<div class="card">

							<div class="card-header header-elements-inline">
								<h5 class="card-title">Обход</h5>
							</div>

							<div class="table-responsive">
								<table class="table table-hover table-sm">
									<thead>
										<tr class="bg-info">
											<th>Дата и время осмотра</th>
											<th>Врач</th>
											<th class="text-right" style="width: 50%">Действия</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($db->query("SELECT * FROM visit_inspection WHERE visit_id = $patient->visit_id AND status_anest IS NULL ORDER BY add_date DESC") as $row): ?>
											<tr>
												<td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
												<td><?= get_full_name($row['parent_id']) ?></td>
												<td class="text-right">
													<button onclick="Check('<?= viv('doctor/inspection') ?>?pk=<?= $row['id'] ?>')" type="button" class="btn btn-outline-info btn-sm legitRipple"><i class="icon-eye mr-2"></i> Просмотр</button>
												</td>
											</tr>
										<?php endforeach; ?>
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

	<div id="modal_show" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-3 border-info" id="div_show">

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
	</script>
    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
