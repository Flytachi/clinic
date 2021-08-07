<?php
require_once '../../tools/warframe.php';
$session->is_auth([2, 32]);
$header = "Список пациентов";

$tb = new Table($db, "users");
$search = $tb->get_serch();
$where_search = array("user_level = 15", "user_level = 15 AND (id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', last_name, first_name, father_name)) LIKE LOWER('%$search%'))");

$tb->where_or_serch($where_search)->order_by("add_date DESC")->set_limit(20);
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
						<h6 class="card-title">Список пациентов</h6>
						<div class="header-elements">
							<div class="form-group-feedback form-group-feedback-right mr-2">
								<input type="text" class="<?= $classes['input-search'] ?>" value="<?= $search ?>" id="search_input" placeholder="Поиск..." title="Введите ID или имя">
								<div class="form-control-feedback">
									<i class="icon-search4 font-size-base text-muted"></i>
								</div>
							</div>
							<a onclick="Update('<?= up_url(null, 'PatientForm') ?>')" class="btn bg-success btn-icon ml-2 legitRipple"><i class="icon-plus22"></i></a>
						</div>
					</div>

					<div class="card-body" id="search_display">

						<?php
						if( isset($_SESSION['message']) ){
							echo $_SESSION['message'];
							unset($_SESSION['message']);
						}
						?>
						
						<div class="table-responsive">
							<table class="table table-hover table-sm table-bordered">
								<thead class="<?= $classes['table-thead'] ?>">
									<tr>
										<th>ID</th>
										<th>ФИО</th>
										<th>Дата рождение</th>
										<th>Телефон</th>
										<th>Регион</th>
										<th>Дата регистрации</th>
										<th class="text-center">Статус</th>
										<th class="text-center">Тип визита</th>
										<th class="text-center">Действия</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($tb->get_table() as $row): ?>
										<tr>
											<td><?= addZero($row->id) ?></td>
											<td>
												<div class="font-weight-semibold"><?= get_full_name($row->id) ?></div>
												<div class="text-muted">
													<?php if($stm = $db->query("SELECT building, floor, ward, bed FROM beds WHERE user_id = $row->id")->fetch()): ?>
														<?= $stm['building'] ?>  <?= $stm['floor'] ?> этаж <?= $stm['ward'] ?> палата <?= $stm['bed'] ?> койка;
													<?php endif; ?>
												</div>
											</td>
											<td><?= date_f($row->birth_date) ?></td>
											<td><?= $row->phone_number ?></td>
											<td><?= $row->region ?></td>
											<td><?= date_f($row->add_date, 1) ?></td>
											<td class="text-center">
												<?php if ($row->status): ?>
													<span style="font-size:15px;" class="badge badge-flat border-success text-success">Активный</span>
												<?php else: ?>
													<span style="font-size:15px;" class="badge badge-flat border-grey text-grey-600">Закрытый</span>
												<?php endif; ?>
											</td>
											<td class="text-center">	
												<?php $stm_dr = $db->query("SELECT id, direction FROM visits WHERE user_id = $row->id AND completed IS NULL")->fetch() ?>
												<?php if ( isset($stm_dr['id']) ): ?>
													<?php if ($stm_dr['direction']): ?>
														<span style="font-size:15px;" class="badge badge-flat border-danger text-danger-600">Стационарный</span>
													<?php else: ?>
														<span style="font-size:15px;" class="badge badge-flat border-primary text-primary">Амбулаторный</span>
													<?php endif; ?>
												<?php else: ?>
													<span style="font-size:15px;" class="badge badge-flat border-grey text-grey-300">Нет данных</span>
												<?php endif; ?>
											</td>
											<td class="text-center">
												<button type="button" class="<?= $classes['btn-detail'] ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i> Просмотр</button>
                                                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
													<?php if ( !$row->status or ($row->status and !$stm_dr['direction']) ): ?>
														<a onclick="Update('<?= up_url($row->id, 'VisitPanel', 'ambulator') ?>')" class="dropdown-item"><i class="icon-file-plus"></i>Назначить визит (Aмбулаторный)</a>
													<?php endif; ?>
													<?php if ( !$row->status ): ?>
														<a onclick="Update('<?= up_url($row->id, 'VisitPanel', 'stationar') ?>')" class="dropdown-item"><i class="icon-file-plus"></i>Назначить визит (Стационарный)</a>
													<?php endif; ?>
													<a href="<?= viv('archive/all/list_visit') ?>?id=<?= $row->id ?>" class="dropdown-item"><i class="icon-users4"></i> Визиты</a>
													<a onclick="Update('<?= up_url($row->id, 'PatientForm') ?>')" class="dropdown-item"><i class="icon-quill2"></i>Редактировать</a>
                                                </div>
											</td>
										</tr>
									<?php endforeach;?>
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

	<div id="modal_default" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-full">
			<div class="<?= $classes['modal-global_content'] ?>" id="form_card"></div>
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
					$('#modal_default').modal('show');
					$('#form_card').html(result);
				},
			});
		};

		$("#search_input").keyup(function() {
			$.ajax({
				type: "GET",
				url: "<?= ajax('search/registry-index') ?>",
				data: {
					table_search: $("#search_input").val(),
				},
				success: function (result) {
					$('#search_display').html(result);
				},
			});
		});
	</script>

</body>
</html>
