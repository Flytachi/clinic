<?php
require_once '../../tools/warframe.php';
$session->is_auth(13);
is_module('module_laboratory');
$header = "Амбулаторные пациенты";

$tb = (new VisitServiceModel)->as('vs');
$tb->Data("DISTINCT v.id, vs.client_id, c.first_name, c.last_name, c.father_name, c.birth_date, vs.route_id, v.add_date, vr.id 'order'")->Join("LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN clients c ON(c.id=vs.client_id) LEFT JOIN visit_orders vr ON (v.id = vr.visit_id)");
$search = $tb->getSearch();
$is_division = (division()) ? "AND vs.division_id = ".division() : null;
$search_array = array(
	"vs.branch_id = $session->branch AND vs.status = 3 AND vs.level = 13 AND v.direction IS NULL $is_division",
	"vs.branch_id = $session->branch AND vs.status = 3 AND vs.level = 13 AND v.direction IS NULL $is_division AND (c.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', c.last_name, c.first_name, c.father_name)) LIKE LOWER('%$search%'))"
);
$tb->Where($search_array)->Limit(20);
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
<script src="<?= stack("assets/js/custom.js") ?>"></script>

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
							<div class="form-group-feedback form-group-feedback-right mr-2">
								<input type="text" class="<?= $classes['input-search'] ?>" value="<?= $search ?>" id="search_input" placeholder="Поиск..." title="Введите ID или имя">
								<div class="form-control-feedback">
									<i class="icon-search4 font-size-base text-muted"></i>
								</div>
							</div>
						</div>
					</div>

					<div class="card-body" id="search_display">

						<div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead class="<?= $classes['table-thead'] ?>">
                                    <tr>
                                        <th>ID</th>
                                        <th>ФИО</th>
										<th>Дата рождения</th>
										<th>Дата назначения</th>
                                        <th>Мед услуга</th>
                                        <th>Направитель</th>
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php foreach($tb->list(1) as $row): ?>
										<tr id="VisitService_tr_<?= $row->count ?>">
                                            <td><?= addZero($row->client_id) ?></td>
                                            <td>
												<span class="font-weight-semibold"><?= client_name($row->client_id) ?></span>
												<?php if ( $row->order ): ?>
													<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Ордер</span>
												<?php endif; ?>
											</td>
											<td><?= date_f($row->birth_date) ?></td>
											<td><?= ($row->add_date) ? date_f($row->add_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
                                            <td>
												<?php foreach($db->query("SELECT vs.id, vs.service_name FROM visit_services vs WHERE vs.visit_id = $row->id AND vs.status = 3 AND vs.level = 13 AND vs.route_id = $row->route_id $is_division") as $serv): ?>
													<?php $services[] = $serv['id'] ?>
													<span><?= $serv['service_name'] ?></span><br>
												<?php endforeach; ?>
											</td>
											<td>
												<?= level_name($row->route_id) ." ". division_name($row->route_id) ?>
												<div class="text-muted"><?= get_full_name($row->route_id) ?></div>
											</td>
                                            <td class="text-center">
                                                <button type="button" class="<?= $classes['btn-viewing'] ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i>Просмотр</button>
                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
                                                    <a onclick="ResultShow('<?= up_url($row->id, 'VisitAnalyzeModel') ?>&items=<?= json_encode($services) ?>')" class="dropdown-item"><i class="icon-pencil7"></i> Добавить результ</a>
													<a onclick="Print('<?= prints('test_tube') ?>?pk=<?= $row->client_id ?>')" class="dropdown-item"><i class="icon-unlink2"></i> Пробирка</a>
                                                </div>
                                            </td>
                                        </tr>
									<?php unset($services); endforeach; ?>
                                </tbody>
                            </table>
                        </div>

						<?php $tb->panel(); ?>

					</div>

				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<div id="modal_default" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-full">
			<div class="<?= $classes['modal-global_content'] ?>" id="form_card"></div>
		</div>
	</div>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->

	<script type="text/javascript">

		$("#search_input").keyup(function() {
			$.ajax({
				type: "GET",
				url: "<?= ajax('search/laboratory-list_outpatient') ?>",
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
					$('#modal_default').modal('show');
					$('#form_card').html(result);
				},
			});
		};

	</script>

</body>
</html>
