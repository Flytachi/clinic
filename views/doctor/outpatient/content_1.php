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

				<?php include "../profile_card.php"; ?>

				<div class="card border-1 border-info">
				    <div class="card-header text-dark header-elements-inline alpha-info">
				        <h6 class="card-title">Просмотр визита</h6>
				    </div>

				    <div class="card-body">

				        <?php include "content_tabs.php"; ?>

                        <div class="card">
                            <table class="table table-togglable table-hover">
                                <thead>
                                    <tr class="bg-blue">
                                        <th>Мед Услуга</th>
                                        <th style="width: 10%">Статус</th>
										<th style="width: 10%">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php
									// prit($db->query("SELECT vs.id, ser.name, vs.completed FROM visit_service vs LEFT JOIN service ser ON (vs.service_id = ser.id) WHERE vs.visit_id = $patient->id")->fetchAll());
									foreach ($db->query("SELECT vs.id, ser.name, vs.completed FROM visit_service vs LEFT JOIN service ser ON (vs.service_id = ser.id) WHERE vs.visit_id = $patient->id") as $row) {
									?>
	                                    <tr>
	                                        <td><?= $row['name'] ?></td>
	                                        <td><span class="badge badge-success">Оплачено</span></td>
											<td class="text-center">
												<?php
												if ($row['completed']) {
													?>
													<button onclick="Update('<?= viv('doctor/report') ?>?id=<?= $_GET['id'] ?>')" class="btn btn-outline-primary btn-sm legitRipple">Просмотр</button> <!-- data-toggle="modal" data-target="#modal_report_show" -->
													<?php
												}else {
													?>
													<button onclick="$('#rep_id').val(this.dataset.id);" type="button" class="btn btn-outline-success btn-sm legitRipple" data-id="<?= $row['id'] ?>" data-toggle="modal" data-target="#modal_report_add">Провести</button>
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

				    <!-- /content wrapper -->
				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->

	<div id="modal_report_add" class="modal fade" tabindex="-1">events
		<div class="modal-dialog modal-full">
			<div class="modal-content">
				<div class="modal-body">

					<?php PatientReport::form(); ?>

				</div>
			</div>
		</div>
	</div>

	<div id="modal_report_show" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-full">
			<div class="modal-content">
				<div class="modal-body">

					<div class="card" id="report_show">

					</div>

				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		function Update(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (data) {
					$('#modal_report_show').modal('show');
					$('#report_show').html(data);
				},
			});
		};
	</script>

    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
