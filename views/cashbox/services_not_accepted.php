<?php
require_once '../../tools/warframe.php';
$session->is_auth([22,23]);
$header = "Не принятые услуги";

$tb = (new VisitServiceModel)->tb('vs');
$tb->set_data("vs.id, vs.client_id, vs.service_name, vs.add_date, vs.route_id, vs.division_id, vs.responsible_id, vs.level")->additions("LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN clients c ON(c.id=vs.client_id)");
$search = $tb->get_serch();
$search_array = array(
	"vs.branch_id = $session->branch AND vs.status = 2 AND v.direction IS NULL", 
	"vs.branch_id = $session->branch AND vs.status = 2 AND v.direction IS NULL AND (c.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', c.last_name, c.first_name, c.father_name)) LIKE LOWER('%$search%') OR LOWER(vs.service_name) LIKE LOWER('%$search%') )"
);
$tb->where_or_serch($search_array)->order_by('vs.id ASC')->set_limit(20);
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<body>
	<!-- Main navbar -->
	<?php include '../layout/navbar.php' ?>
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

				<?php include 'tabs_2.php' ?>
				<!-- Highlighted tabs -->
                <div class="<?= $classes['card'] ?>">

                    <div class="<?= $classes['card-header'] ?>">
                        <h5 class="card-title">Не принятые услуги</h5>
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
                                        <th>Мед услуга</th>
                                        <th>Дата назначения</th>
                                        <th>Направитель</th>
                                        <th>Отдел</th>
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php foreach($tb->get_table() as $row): ?>
										<tr id="PatientFailure_tr_<?= $row->id ?>">
                                            <td><?= addZero($row->client_id) ?></td>
                                            <td>
												<div class="font-weight-semibold"><?= client_name($row->client_id) ?></div>
											</td>
                                            <td><?= $row->service_name ?></td>
											<td><?= ($row->add_date) ? date_f($row->add_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
											<td>
												<?= level_name($row->route_id) ." ". division_name($row->route_id) ?>
												<div class="text-muted"><?= get_full_name($row->route_id) ?></div>
											</td>
                                            <td>
                                                <?php if($row->responsible_id): ?>
													<?php if(in_array($row->level, [14])): ?>
														<?= $PERSONAL[$row->level] ?>
														<div class="text-muted"><?= get_full_name($row->responsible_id) ?></div>
													<?php else: ?>
                                                    	<?= $db->query("SELECT title FROM divisions WHERE id = $row->division_id")->fetchColumn() ?>
                                                    	<div class="text-muted"><?= get_full_name($row->responsible_id) ?></div>
													<?php endif; ?>
                                                <?php else: ?>
													<?php if(in_array($row->level, [14])): ?>
														<?= $PERSONAL[$row->level] ?>
													<?php else: ?>
                                                    	<?= $db->query("SELECT title FROM divisions WHERE id = $row->division_id")->fetchColumn() ?>
													<?php endif; ?>
                                                <?php endif; ?>
											</td>
                                            <td class="text-center">
                                                <button onclick="FailureVisitService('<?= del_url($row->id, 'VisitFailure') ?>')" type="button" class="btn btn-outline-danger btn-sm legitRipple">Отмена</button>
                                            </td>
                                        </tr>
									<?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

						<?php $tb->get_panel(); ?>

                    </div>

                </div>
				<!-- /highlighted tabs -->

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->


	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->

	<script type="text/javascript">

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
						
						$(`#PatientFailure_tr_${data.pk}`).css("background-color", "rgb(244, 67, 54)");
                        $(`#PatientFailure_tr_${data.pk}`).css("color", "white");
                        $(`#PatientFailure_tr_${data.pk}`).fadeOut(900, function() {
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
			var input = document.querySelector('#search_input');
			var display = document.querySelector('#search_display');
			$.ajax({
				type: "GET",
				url: "<?= ajax('search/cashbox-services_not_accepted') ?>",
				data: {
					table_search: input.value,
				},
				success: function (result) {
					display.innerHTML = result;
				},
			});
		});

	</script>

</body>
</html>
