<?php
require_once '../../tools/warframe.php';
is_auth([2, 32]);
$header = "Список пациентов";
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

				<div class="card border-1 border-info">

					<div class="card-header text-dark header-elements-inline alpha-info">
						<h6 class="card-title">Список пациентов</h6>
						<div class="header-elements">
							<form action="#">
								<div class="form-group-feedback form-group-feedback-right">
									<input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
									<div class="form-control-feedback">
										<i class="icon-search4 font-size-base text-muted"></i>
									</div>
								</div>
							</form>
						</div>
					</div>

					<div class="card-body" style="">

						<div class="table-responsive">
							<table class="table table-hover table-sm table-bordered">
								<thead>
									<tr class="bg-info">
										<th>ID</th>
										<th>ФИО</th>
										<th>Дата рождение</th>
										<th>Телефон</th>
										<th>Регион</th>
										<th>Дата регистрации</th>
										<th>Тип визита</th>
										<th>Статус</th>
										<th class="text-center">Действия</th>
									</tr>
								</thead>
								<tbody id="search_display">
									<?php
									$i = 1;
									$count_elem = 20;

				                	$count = ceil(intval($db->query("SELECT COUNT(*) FROM users WHERE user_level = 15 ")->fetch()['COUNT(*)']) / $count_elem);

				                	$_GET['of'] = isset($_GET['of']) ? $_GET['of'] : 0;

				                	$offset = intval($_GET['of']) * $count_elem ;

									foreach($db->query("SELECT * FROM users WHERE user_level = 15 ORDER BY add_date DESC LIMIT $count_elem OFFSET $offset ") as $row) {
										?>
										<tr>
											<td><?= addZero($row['id']) ?></td>
											<td>
												<div class="font-weight-semibold"><?= get_full_name($row['id']) ?></div>
												<div class="text-muted">
													<?php
													if($stm = $db->query('SELECT wd.floor, wd.ward, bd.bed FROM beds bd LEFT JOIN wards wd ON(wd.id=bd.ward_id) WHERE bd.user_id='.$row['id'])->fetch()){
														echo $stm['floor']." этаж ".$stm['ward']." палата ".$stm['bed']." койка";
													}
													?>
												</div>
											</td>
											<td><?= date('d.m.Y', strtotime($row['dateBith'])) ?></td>
											<td><?= $row['numberPhone'] ?></td>
											<td><?= $row['region'] ?></td>
											<td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
											<?php
											if($stm_dr = $db->query("SELECT direction, status FROM visit WHERE completed IS NULL AND user_id={$row['id']} AND status NOT IN (5,6) ORDER BY add_date ASC")->fetch()){
												if($stm_dr['direction']){
													?>
													<td>
														<span style="font-size:15px;" class="badge badge-flat border-danger text-danger-600">Стационарный</span>
													</td>
													<td>
														<?php
														switch ($stm_dr['status']):
															case 1:
																?>
																<span style="font-size:15px;" class="badge badge-flat border-success text-success">Размещён</span>
																<?php
																break;
															case 2:
																?>
																<span style="font-size:15px;" class="badge badge-flat border-success text-success">Активный</span>
																<?php
																break;
															default:
																?>
																<span style="font-size:15px;" class="badge badge-flat border-secondary text-secondary">Закрытый</span>
																<?php
																break;
														endswitch;
														?>
													</td>
													<?php
												}else{
													?>
													<td>
														<span style="font-size:15px;" class="badge badge-flat border-primary text-primary">Амбулаторный</span>
													</td>
													<td>
														<?php
														switch ($stm_dr['status']):
															case 1:
																?>
																<span style="font-size:15px;" class="badge badge-flat border-orange text-orange">Ожидание</span>
																<?php
																break;
															case 2:
																?>
																<span style="font-size:15px;" class="badge badge-flat border-success text-success">У специолиста</span>
																<?php
																break;
															default:
																?>
																<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Оплачивается</span>
																<?php
																break;
														endswitch;
														?>
													</td>
													<?php
												}
											}else {
												?>
													<td>
														<?= ($row['status']) ?
														'<span style="font-size:15px;" class="badge badge-flat border-danger text-danger-600">Status error</span>' :
														'<span style="font-size:15px;" class="badge badge-flat border-grey text-grey-600">Закрытый</span>'
														?>

													</td>
													<td>
														<span style="font-size:15px;" class="badge badge-flat border-grey text-grey-300">Не активный</span>
													</td>
												<?php
											}
											?>
											<td class="text-center">
												<button type="button" class="btn btn-outline-info btn-sm legitRipple dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i> Просмотр</button>
                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
													<a onclick="Update('<?= up_url($row['id'], 'PatientForm') ?>')" class="dropdown-item"><i class="icon-quill2"></i>Редактировать</a>
													<a href="<?= viv('archive/all/list_visit') ?>?id=<?= $row['id'] ?>" class="dropdown-item"><i class="icon-users4"></i> Визиты</a>
                                                </div>
											</td>
										</tr>
										<?php
									}
									?>
								</tbody>
							</table>

							<?php pagination_page($count, $count_elem, 2); ?>

						</div>

					</div>

				</div>


			</div>
            <!-- /content area -->
		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<div id="modal_updete" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-3 border-info">
				<div class="modal-header bg-info">
					<h5 class="modal-title">Обновить Даные<span id="vis_title"></h5>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body" id="update_card">

				</div>
			</div>
		</div>
	</div>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->

	<script type="text/javascript">
		function Update(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#modal_updete').modal('show');
					$('#update_card').html(result);
				},
			});
		};

		$("#search_input").keyup(function() {
			$.ajax({
				type: "GET",
				url: "search.php",
				data: {
					search: $("#search_input").val(),
				},
				success: function (result) {
					$('#search_display').html(result);
				},
			});
		});
	</script>

</body>
</html>
