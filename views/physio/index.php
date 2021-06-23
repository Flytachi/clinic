<?php
require_once '../../tools/warframe.php';
$session->is_auth(12);
$header = "Амбулаторные пациенты";

$tb = new Table($db, "visit_services vs");
$tb->set_data("DISTINCT v.id, vs.user_id, us.birth_date, vs.route_id, v.direction, v.add_date")->additions("LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN users us ON(us.id=vs.user_id)");
$search = $tb->get_serch();
$search_array = array(
	"vs.status = 2 AND vs.level = 12",
	"vs.status = 2 AND vs.level = 12 AND (us.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$search%'))"
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
						<h6 class="card-title">Амбулаторные пациенты</h6>
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
										<th>Мед услуга</th>
                                        <th class="text-center" style="width:300px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
									<?php foreach($tb->get_table() as $row): ?>
										<tr id="VisitService_tr_<?= $row->id ?>">
                                            <td><?= addZero($row->user_id) ?></td>
                                            <td>
												<div class="font-weight-semibold"><?= get_full_name($row->user_id) ?></div>
											</td>
											<td><?= date_f($row->birth_date) ?></td>
											<td><?= ($row->add_date) ? date_f($row->add_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
                                            <td>
												<?php foreach($db->query("SELECT id, service_name FROM visit_services WHERE visit_id = $row->id AND status = 2 AND route_id = $row->route_id AND level = 12") as $serv): ?>
													<?php $services[] = $serv['id'] ?>
													<span><?= $serv['service_name'] ?></span><br>
												<?php endforeach; ?>
											</td>
                                            <td class="text-center">
												<button onclick="VisitUpStatus(<?= $row->id ?>, <?= json_encode($services) ?>)" type="button" class="btn btn-outline-success btn-sm legitRipple">Принять</button>
												<button onclick="MListVisit(<?= $row['id'] ?>, 1)" class="btn btn-outline-primary btn-sm">Детально</button>
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

		function ListVisit(events, type){
			$.ajax({
				type: "GET",
				url: "<?= ajax('physio_table_visit') ?>",
				data: {
					user_id: events,
					type: type,
				},
				success: function (result) {
					$('#modal_result_show_content').html(result);
				},
			});
		}

		function MListVisit(events, type) {
			$('#modal_result_show').modal('show');
			ListVisit(events, type);
		};

		function Complt(url, ev) {
            event.preventDefault();
            $.ajax({
				type: "GET",
				url: url,
				success: function (data) {
                    ListVisit(ev);
				},
			});
        };

		function Delete(url, ev) {
            event.preventDefault();
            $.ajax({
				type: "GET",
				url: url,
				success: function (data) {
                    ListVisit(ev, 1);
				},
			});
        };

	</script>
</body>
</html>
