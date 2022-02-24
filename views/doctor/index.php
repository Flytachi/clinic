<?php
require_once '../../tools/warframe.php';
$session->is_auth(5);
$header = "Приём пациетов";

$tb = new Table($db, "visit_services vs");
$tb->set_data("vs.id, vs.user_id, us.birth_date, vs.add_date, vs.service_name, vs.route_id, v.direction, vs.parent_id, vr.id 'order'")->additions("LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id) LEFT JOIN visit_orders vr ON (v.id = vr.visit_id)");
$search = $tb->get_serch();
$search_array = array(
	"vs.status = 2 AND vs.level = 5 AND ( (vs.parent_id IS NOT NULL AND vs.parent_id = $session->session_id) OR (vs.parent_id IS NULL AND vs.division_id = $session->session_division) )", 
	"vs.status = 2 AND vs.level = 5 AND ( (vs.parent_id IS NOT NULL AND vs.parent_id = $session->session_id) OR (vs.parent_id IS NULL AND vs.division_id = $session->session_division) ) AND (us.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$search%') OR LOWER(vs.service_name) LIKE LOWER('%$search%') )"
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
                                <thead class="<?= $classes['table-thead'] ?>">
                                    <tr>
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
									<?php foreach($tb->get_table() as $row): ?>
										<tr id="VisitService_tr_<?= $row->id ?>">
                                            <td><?= addZero($row->user_id) ?></td>
                                            <td>
												<span class="font-weight-semibold"><?= get_full_name($row->user_id) ?></span>
												<?php if ( $row->order ): ?>
													<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Ордер</span>
												<?php endif; ?>
												<div class="text-muted">
													<?php if($stm = $db->query("SELECT building, floor, ward, bed FROM beds WHERE user_id = $row->user_id")->fetch()): ?>
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
												<button onclick="VisitUpStatus(<?= $row->id ?>)" type="button" class="btn btn-outline-success btn-sm legitRipple">Принять</button>
												<?php if($session->session_id == $row->parent_id): ?>
                                                	<button onclick="FailureVisitService('<?= del_url($row->id, 'VisitFailure') ?>')" type="button" class="btn btn-outline-danger btn-sm legitRipple">Отказ</button>
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

	<script type="text/javascript">

		function VisitUpStatus(id) {
			$.ajax({
				type: "POST",
				url: "<?= add_url() ?>",
				data: {
					model: "VisitServiceUp",
					id: id,
					status: 3,
					parent_id: "<?= $session->session_id ?>",
					accept_date: date_format(new Date()),
				},
				success: function (result) {
					console.log(result);
					var data = JSON.parse(result);

					if (data.status == "success") {
						new Noty({
							text: 'Процедура приёма прошла успешно!',
							type: 'success'
						}).show();
						
						$(`#VisitService_tr_${data.pk}`).css("background-color", "rgb(0, 255, 0)");
                        $(`#VisitService_tr_${data.pk}`).css("color", "black");
                        $(`#VisitService_tr_${data.pk}`).fadeOut(900, function() {
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

		function FailureVisitService(url) {
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
						
						$(`#VisitService_tr_${data.pk}`).css("background-color", "rgb(244, 67, 54)");
                        $(`#VisitService_tr_${data.pk}`).css("color", "white");
                        $(`#VisitService_tr_${data.pk}`).fadeOut(900, function() {
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
				url: "<?= ajax('search/doctor-index') ?>",
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
