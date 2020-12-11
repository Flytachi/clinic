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
								<h5 class="card-title">Осмотр</h5>
								<?php if ($patient->direction and $patient->grant_id == $_SESSION['session_id']): ?>
									<div class="header-elements">
										<div class="list-icons">
											<a class="list-icons-item text-success" data-toggle="modal" data-target="#modal_add">
												<i class="icon-plus22"></i>Добавить
											</a>
										</div>
									</div>
								<?php endif; ?>
							</div>

							<div class="table-responsive">
								<table class="table table-hover table-sm">
	                                <thead>
	                                    <tr class="bg-info">
	                                        <th>Мед Услуга</th>
											<th class="text-right" style="width: 25%">Действия</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
										<?php
										foreach ($db->query("SELECT vs.id, vs.report_description, sc.name, vs.completed FROM visit vs LEFT JOIN service sc ON (vs.service_id = sc.id) WHERE vs.user_id = $patient->id AND vs.parent_id = {$_SESSION['session_id']} AND accept_date IS NOT NULL AND vs.completed IS NULL") as $row) {
										?>
		                                    <tr>
		                                        <td><?= $row['name'] ?></td>
												<td class="text-right">
													<?php
													if ($row['report_description']) {
														?>
														<button onclick="Check('<?= viv('doctor/report') ?>?pk=<?= $row['id'] ?>')" type="button" class="btn btn-outline-info btn-sm legitRipple"><i class="icon-eye mr-2"></i> Просмотр</button>
														<button onclick="Update('<?= up_url($row['id'], 'VisitReport') ?>')" type="button" class="btn btn-outline-success btn-sm legitRipple">Редактировать</button>
														<?php
													}else {
														?>
														<button onclick="CleanForm('<?= $row['id'] ?>', '<?= $row['name'] ?>')" type="button" class="btn btn-outline-success btn-sm legitRipple">Провести</button>
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

				<?php VisitReport::form(); ?>

			</div>
		</div>
	</div>

	<div id="modal_add" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-info">
					<h6 class="modal-title">Назначить услугу</h6>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body">

					<?php VisitRoute::form_sta_doc() ?>

				</div>
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

		function CleanForm(id, name) {
			$('#report_editor').html('');
			$('#rep_id').val(id);
			$('#modal_report_add').modal('show');
			if (name) {
				$('#report_title').val(name);
			}
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

		function Update(events, name) {
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
