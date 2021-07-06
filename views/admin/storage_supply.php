<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);
is_module('module_pharmacy');
$header = "Аптека / Поставки";
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
	                  	<h5 class="card-title">Поставки</h5>
	              	</div>

              		<div class="card-body">
                  		<div class="table-responsive">
	                      	<table class="table table-hover">
	                          	<thead>
	                              	<tr class="<?= $classes['table-thead'] ?>">
									  	<th style="width:50px">№</th>
									  	<th style="width:200px">Ключ</th>
									  	<th style="width:35%">Препарат</th>
                                        <th>Дата поставки</th>
										<th class="text-right" style="width: 100px">Действия</th>
	                              	</tr>
	                          	</thead>
	                          	<tbody>
									<?php
									$tb = new Table($db, "storage_supply");
									?>
                                    <?php foreach ($tb->get_table(1) as $row): ?>
										<tr>
											<td><?= $row->count ?></td>
											<td><?= $row->uniq_key ?></td>
											<td><?= get_full_name($row->parent_id) ?></td>
											<td><?= date_f($row->add_date, 1) ?></td>
											<td class="text-right">
												<div class="list-icons">
													<a href="<?= viv('admin/storage_supply_items') ?>?pk=<?= $row->id ?>" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
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

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->

</body>
</html>
