<?php
require_once '../../tools/warframe.php';
is_auth(10);
$header = "Амбулаторные пациенты";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<script src="<?= stack("global_assets/js/plugins/forms/selects/bootstrap_multiselect.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/content_cards_header.js") ?>"></script>

<body>
	<!-- Main navbar -->
	<?php include layout('navbar') ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include layout('sidebar') ?>
		<!-- /main sidebar -->

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include layout('header') ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">


				<div class="card border-1 border-info">

					<div class="card-header text-dark header-elements-inline alpha-info">
						<h6 class="card-title">Амбулаторные пациенты</h6>
						<div class="header-elements">
							<form action="#">
								<div class="wmin-sm-200">
									<select class="form-control form-control-multiselect" multiple="multiple" data-fouc>
										<option value="cheese">Cheese</option>
										<option value="tomatoes">Tomatoes</option>
										<option value="mozarella">Mozzarella</option>
										<option value="mushrooms">Mushrooms</option>
										<option value="pepperoni">Pepperoni</option>
										<option value="onions">Onions</option>
									</select>
								</div>
							</form>
						</div>
					</div>

					<div class="card-body">

						<div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr class="bg-info">
                                        <th>ID</th>
                                        <th>ФИО</th>
										<th>Дата рождения</th>
                                        <th>Мед услуга</th>
                                        <th>Направитель</th>
                                        <th class="text-center" style="width:300px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
									if (division_assist() == 2) {
										$sql = "SELECT DISTINCT us.id, vs.id 'visit_id', vs.route_id, sc.name, vs.complaint, vs.parent_id, vs.assist_id,
												us.dateBith
												FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) LEFT JOIN service sc ON(sc.id=vs.service_id)
												WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NULL AND vs.assist_id IS NOT NULL ORDER BY vs.accept_date ASC";
									} else {
										$sql = "SELECT DISTINCT us.id, vs.id 'visit_id', vs.route_id, sc.name, vs.complaint,
												us.dateBith
												FROM users us LEFT JOIN visit vs ON(us.id=vs.user_id) LEFT JOIN service sc ON(sc.id=vs.service_id)
												WHERE vs.completed IS NULL AND vs.status = 2 AND vs.direction IS NULL AND vs.parent_id = {$_SESSION['session_id']} ORDER BY vs.accept_date ASC";
									}
                                    foreach($db->query($sql) as $row) {
										if (division_assist() == 2) {
											if ($row['parent_id'] == $row['assist_id']) {
												$tr = "";
											}elseif ($row['parent_id'] == $_SESSION['session_id']) {
												$tr = "table-success";
											}else {
												$tr = "table-danger";
											}
										}else {
											$tr = "";
										}
                                        ?>
                                        <tr class="<?= $tr ?>">
                                            <td><?= addZero($row['id']) ?></td>
                                            <td><div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div></td>
											<td><?= date('d.m.Y', strtotime($row['dateBith'])) ?></td>
                                            <td><?= $row['name']; ?></td>
											<td>
												<?= level_name($row['route_id']) ." ". division_name($row['route_id']) ?>
												<div class="text-muted"><?= get_full_name($row['route_id']) ?></div>
											</td>
                                            <td class="text-center">
												<?php if ($row['complaint']): ?>
													<button onclick="swal('<?= $row['complaint'] ?>')" type="button" class="btn btn-outline-warning btn-sm legitRipple">Жалоба</button>
												<?php endif; ?>
												<?php if ($tr != "table-danger"): ?>
													<button onclick="ResultShow('<?= up_url($row['visit_id'], 'VisitReport') ?>&user_id=<?= $row['id'] ?>', '<?= $row['name'] ?>')" class="btn btn-outline-primary btn-sm"><i class="icon-clipboard3 mr-2"></i>Заключение</button>
												<?php endif; ?>
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
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<div id="modal_result_show" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-3 border-info" id="modal_result_show_content">

			</div>
		</div>
	</div>

	<!-- Footer -->
	<?php include layout('footer') ?>
	<!-- /footer -->

	<script type="text/javascript">

		function ResultShow(events, title) {

			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#modal_result_show').modal('show');
					$('#modal_result_show_content').html(result);
					$('#report_title').val(title);
				},
			});
		};

	</script>
</body>
</html>
