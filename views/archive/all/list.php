<?php
require_once '../../../tools/warframe.php';
$session->is_auth();
$header = "Все пациенты";

$tb = (new ClientModel)->tb();
$search = $tb->get_serch();
$where_search = array(null, "id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', last_name, first_name, father_name)) LIKE LOWER('%$search%')");

$tb->where_or_serch($where_search)->order_by("add_date DESC")->set_limit(30);
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
						</div>
					</div>

					<div class="card-body" id="search_display">
						
						<div class="table-responsive">
							<table class="table table-hover table-sm">
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
												<div class="font-weight-semibold"><?= client_name($row->id) ?></div>
												<div class="text-muted">
													<?php if($stm = $db->query("SELECT building, floor, ward, bed FROM beds WHERE client_id = $row->id")->fetch()): ?>
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
												<?php $stm_dr = $db->query("SELECT id, direction FROM visits WHERE client_id = $row->id AND completed IS NULL")->fetch() ?>
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
												<a href="<?= viv('archive/all/list_visit') ?>?id=<?= $row->id ?>" class="<?= $classes['btn-detail'] ?>"><i class="icon-eye mr-2"></i> Просмотр</a>
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

	<script type="text/javascript">
		
		$("#search_input").keyup(function() {
			$.ajax({
				type: "GET",
				url: "<?= ajax('search/archive-all-list') ?>",
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
