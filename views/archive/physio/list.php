<?php
require_once '../../../tools/warframe.php';
$session->is_auth();
$header = "Мои пациенты";

$tb = new Table($db, "users us");
$search = $tb->get_serch();
$where_search = array(
	"us.user_level = 15 AND vs.parent_id = $session->session_id",
	"us.user_level = 15 AND vs.parent_id = $session->session_id AND (us.id LIKE '%$search%' OR LOWER(CONCAT_WS(' ', us.last_name, us.first_name, us.father_name)) LIKE LOWER('%$search%'))"
);

$tb->set_data("DISTINCT us.id, us.birth_date, us.phone_number, us.region, us.add_date")->additions("LEFT JOIN visit_services vs ON(vs.user_id=us.id)")->where_or_serch($where_search)->order_by("us.add_date DESC")->set_limit(20);
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
						<h6 class="card-title">Мои пациенты</h6>
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
										<th class="text-center">Действия</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($tb->get_table() as $row): ?>
										<tr>
											<td><?= addZero($row->id) ?></td>
											<td>
												<div class="font-weight-semibold"><?= get_full_name($row->id) ?></div>
											</td>
											<td><?= date_f($row->birth_date) ?></td>
											<td><?= $row->phone_number ?></td>
											<td><?= $row->region ?></td>
											<td><?= date_f($row->add_date, 1) ?></td>
											<td class="text-center">
												<a href="<?= viv('archive/physio/list_visit') ?>?id=<?= $row->id ?>" class="<?= $classes['btn-detail'] ?>"><i class="icon-eye mr-2"></i> Просмотр</a>
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
				url: "<?= ajax('search/archive-physio-list') ?>",
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
