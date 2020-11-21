<?php
require_once '../../../tools/warframe.php';
is_auth(5);
$header = "Пациент";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../layout/head.php' ?>
<script src="<?= stack('ckeditor/ckeditor.js') ?>"></script>

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
								<h5 class="card-title">Осмотр</h5>
							</div>

							<div class="table-responsive">
								<table class="table table-togglable table-hover">
	                                <thead>
	                                    <tr class="bg-info">
	                                        <th>Мед Услуга</th>
											<th class="text-right" style="width: 25%">Действия</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
										<?php
										foreach ($db->query("SELECT vs.id, ser.name, vs.completed FROM visit_service vs LEFT JOIN service ser ON (vs.service_id = ser.id) WHERE vs.visit_id = $patient->id") as $row) {
										?>
		                                    <tr>
		                                        <td><?= $row['name'] ?></td>
												<td class="text-right">
													<?php
													if ($row['completed']) {
														?>
														<button onclick="Check('<?= viv('doctor/report') ?>?pk=<?= $row['id'] ?>')" type="button" class="btn btn-outline-info btn-sm legitRipple"><i class="icon-eye mr-2"></i> Просмотр</button>
														<button onclick="Update('<?= up_url($row['id'], 'PatientReport') ?>')" type="button" class="btn btn-outline-success btn-sm legitRipple">Редактировать</button>
														<?php
													}else {
														?>
														<button onclick="CleanForm('<?= $row['id'] ?>')" type="button" class="btn btn-outline-success btn-sm legitRipple">Провести</button>
														<?php
													}
													?>
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

	<div id="modal_report_add" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-3 border-info" id="form_card">

				<?php PatientReport::form(); ?>

			</div>
		</div>
	</div>

	<div id="modal_report_show" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-3 border-info" id="report_show">

			</div>
		</div>
	</div>

	<script type="text/javascript">

		function CleanForm(id) {
			$('#report_editor').html('');
			$('#rep_id').val(id);
			$('#modal_report_add').modal('show');
		}

		function Check(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#modal_report_show').modal('show');
					$('#report_show').html(result);
				},
			});
		};

		function Update(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#modal_report_add').modal('show');
					$('#form_card').html(result);
				},
			});
		};

	</script>

    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
