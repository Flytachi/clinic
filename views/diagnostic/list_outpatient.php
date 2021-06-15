<?php
require_once '../../tools/warframe.php';
$session->is_auth(10);
is_module('module_diagnostic');
if (division_assist() == 1) {
	Mixin\error('423');
}
$header = "Амбулаторные пациенты";

$tb = new Table($db, "visit_services vs");
$tb->set_data("vs.id, vs.user_id, us.birth_date, vs.accept_date, vs.route_id, v.complaint, vs.service_title, vs.service_name, vs.parent_id")->additions("LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id)");
$search = $tb->get_serch();
$search_array = array(
	"vs.status = 3 AND v.direction IS NULL AND ( vs.parent_id = $session->session_id OR vs.assist_id IS NOT NULL )",
	"vs.status = 3 AND v.direction IS NULL AND ( vs.parent_id = $session->session_id OR vs.assist_id IS NOT NULL ) AND (us.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$search%') OR LOWER(vs.service_name) LIKE LOWER('%$search%') )"
);
$tb->where_or_serch($search_array)->order_by('vs.accept_date DESC')->set_limit(20);
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

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


				<div class="<?= $classes['card'] ?>">

					<div class="<?= $classes['card-header'] ?>">
						<h6 class="card-title">Амбулаторные пациенты</h6>
						<div class="header-elements">
							<form action="" class="mr-2">
								<div class="form-group-feedback form-group-feedback-right">
									<input type="text" class="<?= $classes['input-search'] ?>" value="<?= $search ?>" id="search_input" placeholder="Введите ID или имя">
									<div class="form-control-feedback">
										<i class="icon-search4 font-size-base text-muted"></i>
									</div>
								</div>
							</form>
						</div>
					</div>

					<div class="card-body" id="search_display">

						<div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr class="<?= $classes['table-thead'] ?>">
                                        <th>ID</th>
                                        <th>ФИО</th>
										<th>Дата рождения</th>
										<th>Дата снятия</th>
                                        <th>Мед услуга</th>
                                        <th>Направитель</th>
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php foreach($tb->get_table() as $row): ?>
										<?php
											if (division_assist() == 2 and !is_null($row->parent_id)) {
												if ($row->parent_id == $session->session_id) {
													$tr = "table-success";
												}elseif ($row->parent_id != $session->session_id) {
													$tr = "table-danger";
												}
											}else {
												$tr = "";
											}
										?>
										<tr class="<?= $tr ?>">
                                            <td><?= addZero($row->user_id) ?></td>
                                            <td><div class="font-weight-semibold"><?= get_full_name($row->user_id) ?></div></td>
											<td><?= date_f($row->birth_date) ?></td>
											<td><?= date_f($row->accept_date, 1) ?></td>
                                            <td>
												<span class="<?= ($row->service_title) ? 'text-primary' : 'text-danger' ?>"><?= $row->service_name ?></span>
											</td>
											<td>
												<?= level_name($row->route_id) ." ". division_name($row->route_id) ?>
												<div class="text-muted"><?= get_full_name($row->route_id) ?></div>
											</td>
                                            <td class="text-center">
												<?php if ($row->complaint): ?>
													<button onclick="swal('<?= $row->complaint ?>')" type="button" class="btn btn-outline-warning btn-sm legitRipple">Жалоба</button>
												<?php endif; ?>
												<?php if ($tr != "table-danger"): ?>
													<button onclick="ResultShow('<?= up_url($row->id, 'VisitReport') ?>')" class="<?= $classes['btn-diagnostic_finally'] ?>"><i class="icon-clipboard3 mr-2"></i>Заключение</button>
												<?php endif; ?>
                                            </td>
                                        </tr>
									<?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

						<?php $tb->get_panel(); ?>

					</div>

				</div>


			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

		<div id="modal_result_show" class="modal fade" tabindex="-1">
			<div class="modal-dialog modal-lg" style="max-width: 1200px !important;">
				<div class="<?= $classes['modal-global_content'] ?>" id="modal_result_show_content">

				</div>
			</div>
		</div>

	</div>
	<!-- /page content -->

	<script type="text/javascript">

		$("#search_input").keyup(function() {
			$.ajax({
				type: "GET",
				url: "<?= ajax('search/diagnostic-list_outpatient') ?>",
				data: {
					table_search: $("#search_input").val(),
				},
				success: function (result) {
					$('#search_display').html(result);
				},
			});
		});

		function ResultShow(events) {

			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#modal_result_show').modal('show');
					$('#modal_result_show_content').html(result);
				},
			});

		};

	</script>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
