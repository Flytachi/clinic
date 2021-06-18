<?php
require_once '../../tools/warframe.php';
$session->is_auth(6);
is_module('module_laboratory');
$header = "Приём пациетов";

$tb = new Table($db, "visit_services vs");
$tb->set_data("DISTINCT v.id, vs.user_id, us.birth_date, vs.route_id, v.direction, v.add_date")->additions("LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id)");
$search = $tb->get_serch();
$search_array = array(
	"vs.status = 2 AND vs.level = 6",
	"vs.status = 3 AND vs.level = 6 AND (us.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$search%'))"
);
$tb->where_or_serch($search_array)->set_limit(20);
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
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
							</div>
						</div>
					</div>

					<div class="card-body">

						<div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead class="<?= $classes['table-thead'] ?>">
                                    <tr>
                                        <th>ID</th>
                                        <th>ФИО</th>
										<th>Дата рождения</th>
                                        <th>Дата назначения</th>
                                        <th>Услуги</th>
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
												<div class="font-weight-semibold"><?= get_full_name($row->user_id) ?></div>
												<div class="text-muted">
													<?php
													// if($stm = $db->query('SELECT wd.floor, wd.ward, bd.bed FROM beds bd LEFT JOIN wards wd ON(wd.id=bd.ward_id) WHERE bd.user_id='.$row['id'])->fetch()){
													// 	echo $stm['floor']." этаж ".$stm['ward']." палата ".$stm['bed']." койка";
													// }
													?>
												</div>
											</td>
											<td><?= date_f($row->birth_date) ?></td>
											<td><?= ($row->add_date) ? date_f($row->add_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
                                            <td>
												<?php foreach($db->query("SELECT id, service_name FROM visit_services WHERE visit_id = $row->id AND status = 2 and route_id = $row->route_id") as $serv): ?>
													<?php $services[] = $serv['id'] ?>
													<span><?= $serv['service_name'] ?></span><br>
												<?php endforeach; ?>
											</td>
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
												<button onclick="VisitUpStatus(<?= $row->id ?>, <?= json_encode($services) ?>)" type="button" class="btn btn-outline-success btn-sm legitRipple">Принять</button>
                                            </td>
                                        </tr>
									<?php unset($services); endforeach; ?>
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

	<script type="text/javascript">

		function VisitUpStatus(tr, items) {
			$.ajax({
				type: "POST",
				url: "<?= add_url() ?>",
				data: {
					model: "VisitServicesModel",
					id: items,
					status: 3,
					accept_date: date_format(new Date()),
				},
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

	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->

</body>
</html>
