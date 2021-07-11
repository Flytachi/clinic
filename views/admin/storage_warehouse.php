<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);
is_module('module_pharmacy');
$header = "Аптека";
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
						<h5 class="card-title">Добавить Склад</h5>
					</div>

					<div class="card-body" id="form_card">

						<?php (new StorageWarehousesModel)->form(); ?>

					</div>

				</div>

				<div class="<?= $classes['card'] ?>">

	          		<div class="<?= $classes['card-header'] ?>">
	                  	<h5 class="card-title">Склад</h5>
	              	</div>

              		<div class="card-body">
                  		<div class="table-responsive">
	                      	<table class="table table-hover">
	                          	<thead>
	                              	<tr class="<?= $classes['table-thead'] ?>">
									  	<th style="width:50px">№</th>
									  	<th>Склад</th>
                                        <th>Роль</th>
                                        <th>Отдел</th>
                                        <th>Ответственный</th>
										<th class="text-right" style="width: 100px">Действия</th>
	                              	</tr>
	                          	</thead>
	                          	<tbody>
									<?php
									$tb = new Table($db, "storage_warehouses");
									?>
                                    <?php foreach ($tb->get_table(1) as $row): ?>
										<tr>
											<td><?= $row->count ?></td>
											<td><?= $row->name ?></td>
											<td><?= $PERSONAL[$row->level] ?></td>
											<td><?= $row->division_id ?></td>
											<td><?= get_full_name($row->parent_id) ?></td>
											<td class="text-right">
												<div class="list-icons">
													<a onclick="Update('<?= up_url($row->id, 'StorageWarehousesModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="<?= del_url($row->id, 'StorageWarehousesModel') ?>" onclick="return confirm('Вы уверены что хотите удалить препарат?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
												</div>
											</td>
										</tr>
									<?php endforeach; ?>
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

		function Update(events) {
			events
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#form_card').html(result);
				},
			});
		};
	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->

</body>
</html>
