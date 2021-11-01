<?php
require_once '../../tools/warframe.php';
$session->is_auth(12);
is_module('module_diagnostic');
if (division_assist() == 2) {
	Mixin\error('423');
}
$header = "Приём пациетов";

$tb = (new VisitServiceModel)->tb('vs');
$tb->set_data("vs.id, vs.client_id, c.birth_date, vs.add_date, vs.service_name, vs.route_id, v.direction, vs.responsible_id, vr.id 'order'")->additions("LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN clients c ON(c.id=vs.client_id) LEFT JOIN visit_orders vr ON (v.id = vr.visit_id)");
$search = $tb->get_serch();
$search_array = array(
	"vs.branch_id = $session->branch AND vs.status = 2 AND vs.level = 12 AND ( (vs.responsible_id IS NOT NULL AND vs.responsible_id = $session->session_id) OR (vs.responsible_id IS NULL AND vs.division_id = $session->session_division) )", 
	"vs.branch_id = $session->branch AND vs.status = 2 AND vs.level = 12 AND ( (vs.responsible_id IS NOT NULL AND vs.responsible_id = $session->session_id) OR (vs.responsible_id IS NULL AND vs.division_id = $session->session_division) ) AND (c.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', c.last_name, c.first_name, c.father_name)) LIKE LOWER('%$search%') OR LOWER(vs.service_name) LIKE LOWER('%$search%') )"
);
$tb->where_or_serch($search_array)->order_by('vs.id ASC')->set_limit(20);
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
						<h6 class="card-title">Пациенты на приём</h6>
						<div class="header-elements">
							<div class="form-group-feedback form-group-feedback-right mr-2">
								<input type="text" class="<?= $classes['input-search'] ?>" value="<?= $search ?>" id="search_input" placeholder="Поиск..." title="Введите ID, имя пациента или название услуги">
								<div class="form-control-feedback">
									<i class="icon-search4 font-size-base text-muted"></i>
								</div>
							</div>
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
                                        <th>Дата назначения</th>
                                        <th>Мед услуга</th>
                                        <th>Направитель</th>
                                        <th>Тип визита</th>
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php foreach($tb->get_table(1) as $row): ?>
										<tr id="VisitService_tr_<?= $row->count ?>">
                                            <td><?= addZero($row->client_id) ?></td>
                                            <td>
												<span class="font-weight-semibold"><?= client_name($row->client_id) ?></span>
												<?php if ( $row->order ): ?>
													<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Ордер</span>
												<?php endif; ?>
												<div class="text-muted">
													<?php if($stm = $db->query("SELECT building, floor, ward, bed FROM beds WHERE client_id = $row->client_id")->fetch()): ?>
														<?= $stm['building'] ?>  <?= $stm['floor'] ?> этаж <?= $stm['ward'] ?> палата <?= $stm['bed'] ?> койка;
													<?php endif; ?>
												</div>
											</td>
											<td><?= date_f($row->birth_date) ?></td>
											<td><?= ($row->add_date) ? date_f($row->add_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
                                            <td><?= $row->service_name ?></td>
											<td>
												<?= level_name($row->route_id) ." ". division_name($row->route_id) ?>
												<div class="text-muted"><?= get_full_name($row->route_id) ?></div>
											</td>
                                            <td class="text-center">
												<?php if($row->direction): ?>
                                                    <span style="font-size:15px;" class="badge badge-flat border-danger text-danger-600">Стационарный</span>
												<?php else: ?>
                                                    <span style="font-size:15px;" class="badge badge-flat border-primary text-primary">Амбулаторный</span>
												<?php endif; ?>
                                            </td>
                                            <td class="text-center">
												<?php if (!division_assist()): ?>
													<button onclick="VisitUpStatus(<?= $row->count ?>, <?= $row->id ?>)" href="<?php //up_url($row->id, 'VisitUpStatus') ?>" type="button" class="btn btn-outline-success btn-sm legitRipple">Принять</button>
                                            	<?php else: ?>
                                            		<button type="button" class="btn btn-outline-success btn-sm legitRipple" data-userid="<?= $row->user_id ?>" data-parentid="<?= $row->parent_id ?>"
														<?php if (!$row->direction): ?>
															onclick="sendPatient(this)"
														<?php endif; ?>
                                            			>Принять</button>
													<button onclick="VisitUpStatus(<?= $row->count ?>, <?= $row->id ?>)" type="button" class="btn btn-outline-info btn-sm legitRipple">Снять</button>
                                            	<?php endif; ?>
												<?php if($session->session_id == $row->responsible_id): ?>
													<button onclick="FailureVisitService(<?= $row->count ?>, '<?= del_url($row->id, 'VisitFailure') ?>')" data-toggle="modal" data-target="#modal_failure" type="button" class="btn btn-outline-danger btn-sm legitRipple">Отказ</button>
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

	</div>
	<!-- /page content -->

	<?php if(division_assist()): ?>
		<script type="text/javascript">
			const data_ajax = {
				model: "VisitServiceModel",
				status: 3,
				assist_id: "<?= $session->session_id ?>",
				responsible_id: null,
				accept_date: date_format(new Date()),
			};
		</script>
	<?php else: ?>
		<script type="text/javascript">
			const data_ajax = {
				model: "VisitServiceModel",
				status: 3,
				responsible_id: "<?= $session->session_id ?>",
				accept_date: date_format(new Date()),
			};
		</script>
	<?php endif; ?>

	<script type="text/javascript">

		function VisitUpStatus(tr, id) {
			data_ajax.id = id;
			$.ajax({
				type: "POST",
				url: "<?= add_url() ?>",
				data: data_ajax,
				success: function (result) {
					var data = JSON.parse(result);

					if (data.status == "success") {
						new Noty({
							text: 'Процедура приёма прошла успешно!',
							type: 'success'
						}).show();
						
						$(`#VisitService_tr_${tr}`).css("background-color", "rgb(0, 255, 0)");
                        $(`#VisitService_tr_${tr}`).css("color", "black");
                        $(`#VisitService_tr_${tr}`).fadeOut(900, function() {
							$(this).remove();
                        });
						
					}else{

						new Noty({
							text: data.message,
							type: 'error'
						}).show();

					}
 				},
			});
		}

		function FailureVisitService(tr, url) {
			
			$.ajax({
				type: "GET",
				url: url,
				success: function (result) {
					var data = JSON.parse(result);

					if (data.status == "success") {
						new Noty({
							text: 'Процедура отказа прошла успешно!',
							type: 'success'
						}).show();
						
						$(`#VisitService_tr_${tr}`).css("background-color", "rgb(244, 67, 54)");
                        $(`#VisitService_tr_${tr}`).css("color", "white");
                        $(`#VisitService_tr_${tr}`).fadeOut(900, function() {
							$(this).remove();
                        });
						
					}else{

						new Noty({
							text: data.message,
							type: 'error'
						}).show();

					}
 				},
			});
		}

		$("#search_input").keyup(function() {
			$.ajax({
				type: "GET",
				url: "<?= ajax('search/diagnostic-index') ?>",
				data: {
					table_search: $("#search_input").val(),
				},
				success: function (result) {
					$('#search_display').html(result);
				},
			});
		});

	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
