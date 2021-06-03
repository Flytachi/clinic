<?php
require_once '../../tools/warframe.php';
$session->is_auth([3, 32]);
$header = "Не принятые услуги";

$tb = new Table($db, "visit_services vs");
$tb->set_data("vs.id, vs.user_id, vs.service_name, vs.add_date, vs.route_id, vs.division_id, vs.parent_id")->additions("LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id)");
$search = $tb->get_serch();
$search_array = array(
	"vs.status = 2", 
	"vs.status = 2 AND (us.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$search%') OR LOWER(vs.service_name) LIKE LOWER('%$search%') )"
);
$tb->where_or_serch($search_array)->order_by('vs.id ASC')->set_limit(20);
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<script src="<?= stack("vendors/js/custom.js") ?>"></script>

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

                    <div class="card-header bg-white header-elements-sm-inline">
                        <h5 class="card-title">Не принятые услуги</h5>
                        <div class="header-elements">
                            <div class="form-group-feedback form-group-feedback-right">
                                <input type="search" class="form-control wmin-200 border-success" id="search_input" placeholder="Введите ID или имя">
                                <div class="form-control-feedback text-success">
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
                                            <td><?= addZero($row->user_id) ?></td>
                                            <td>
												<div class="font-weight-semibold"><?= get_full_name($row->user_id) ?></div>
											</td>
                                            <td><?= $row->service_name ?></td>
											<td><?= ($row->add_date) ? date_f($row->add_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
											<td>
												<?= level_name($row->route_id) ." ". division_name($row->route_id) ?>
												<div class="text-muted"><?= get_full_name($row->route_id) ?></div>
											</td>
                                            <td>
                                                <?php if($row->parent_id): ?>
                                                    <?= division_title($row->parent_id) ?>
                                                    <div class="text-muted"><?= get_full_name($row->parent_id) ?></div>
                                                <?php else: ?>
                                                    <?= $db->query("SELECT title FROM divisions WHERE id = $row->division_id")->fetchColumn() ?>
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
