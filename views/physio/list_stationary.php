<?php
require_once '../../tools/warframe.php';
$session->is_auth(14);
is_module('stationar');
is_module('physio');
$header = "Стационарные пациенты";

$tb = (new VisitServiceModel)->as('vs');
$tb->Data("DISTINCT v.id, vs.client_id, c.first_name, c.last_name, c.father_name, c.birth_date, vs.route_id, v.direction, v.add_date, vr.id 'order'")->Join("LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN clients c ON(c.id=vs.client_id) LEFT JOIN visit_orders vr ON (v.id = vr.visit_id)");
$search = $tb->getSearch();
$is_division = (division()) ? "AND vs.division_id = ".division() : null;
$is_division2 = (division()) ? "AND division_id = ".division() : null;
$search_array = array(
	"vs.branch_id = $session->branch AND vs.status = 2 AND vs.level = 14 AND v.direction IS NOT NULL AND (vs.responsible_id IS NULL OR vs.responsible_id = $session->session_id) $is_division",
	"vs.branch_id = $session->branch AND vs.status = 2 AND vs.level = 14 AND v.direction IS NOT NULL AND (vs.responsible_id IS NULL OR vs.responsible_id = $session->session_id) $is_division AND (c.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', c.last_name, c.first_name, c.father_name)) LIKE LOWER('%$search%'))"
);
$tb->Where($search_array)->Limit(20);
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
						<h6 class="card-title">Стационарные пациенты</h6>
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
                                        <th class="text-center" style="width:300px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php foreach($tb->list() as $row): ?>
										<tr id="VisitService_tr_<?= $row->id ?>">
											<td><?= addZero($row->client_id) ?></td>
											<td>
												<span class="font-weight-semibold"><?= client_name($row) ?></span>
												<?php if ( $row->order ): ?>
													<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Ордер</span>
												<?php endif; ?>
											</td>
											<td><?= date_f($row->birth_date) ?></td>
											<td><?= ($row->add_date) ? date_f($row->add_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
											<td>
												<?php foreach($db->query("SELECT DISTINCT service_name FROM visit_services WHERE visit_id = $row->id AND status = 2 AND level = 14 AND (responsible_id IS NULL OR responsible_id = $session->session_id) $is_division2") as $serv): ?>
													<span><?= $serv['service_name'] ?></span><br>
												<?php endforeach; ?>
											</td>
											<td class="text-center">
												<button onclick="MListVisit('<?= up_url($row->id, 'VisitPhysioModel') ?>')" class="<?= $classes['btn-viewing'] ?>">Детально</button>
											</td>
										</tr>
									<?php endforeach; ?>
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

	<div id="modal_result_show" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="<?= $classes['modal-global_content'] ?>" id="modal_result_show_content">

			</div>
		</div>
	</div>

	<!-- Footer -->
	<?php include layout('footer') ?>
	<!-- /footer -->

	<script type="text/javascript">

		$("#search_input").keyup(function() {
			$.ajax({
				type: "GET",
				url: "<?= ajax('search/physio-list_stationary') ?>",
				data: {
					table_search: $("#search_input").val(),
				},
				success: function (result) {
					$('#search_display').html(result);
				},
			});
		});

		function ListVisit(url){
			$.ajax({
				type: "GET",
				url: url,
				success: function (result) {
					$('#modal_result_show_content').html(result);
				},
			});
		}

		function MListVisit(events) {
			$('#modal_result_show').modal('show');
			ListVisit(events);
		};

	</script>
</body>
</html>
