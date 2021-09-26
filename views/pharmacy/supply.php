<?php
require_once '../../tools/warframe.php';
$session->is_auth(4);
is_module('pharmacy');
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
						<div class="header-elements">
							<div class="list-icons">
								<div class="header-elements">
									<div class="list-icons">
										<a onclick="Update('<?= up_url(null, 'WarehouseSupplyModel') ?>')" class="list-icons-item text-success">
											<i class="icon-plus22"></i>Приход
										</a>
									</div>
								</div>
							</div>
						</div>
	              	</div>

              		<div class="card-body">

						<?php
						if( isset($_SESSION['message']) ){
							echo $_SESSION['message'];
							unset($_SESSION['message']);
						}
						?>

                  		<div class="table-responsive">
	                      	<table class="table table-hover">
	                          	<thead>
	                              	<tr class="<?= $classes['table-thead'] ?>">
									  	<th style="width:50px">№</th>
									  	<th style="width:200px">Ключ</th>
									  	<th style="width:35%">Ответственный</th>
                                        <th>Дата поставки</th>
                                        <th>Дата заноса</th>
										<th class="text-right" style="width: 100px">Действия</th>
	                              	</tr>
	                          	</thead>
	                          	<tbody>
									<?php $tb = new Table($db, "warehouse_supply"); ?>
                                    <?php foreach ($tb->get_table(1) as $row): ?>
										<tr>
											<td><?= $row->count ?></td>
											<td><?= $row->uniq_key ?></td>
											<td><?= get_full_name($row->parent_id) ?></td>
											<td><?= date_f($row->supply_date) ?></td>
											<td><?= ($row->completed) ? date_f($row->completed_date, 1) : '<span class="text-muted">Нет данных</span>'; ?></td>
											<td class="text-right">
												<div class="list-icons">
													<?php if(!$row->completed): ?>
														<?php if($session->session_id == $row->parent_id): ?>
															<a href="" onclick="Update('<?= up_url($row->id, 'WarehouseSupplyModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
														<?php endif; ?>
														<a href="<?= viv('pharmacy/supply_items') ?>?pk=<?= $row->id ?>" class="list-icons-item text-primary-600"><i class="icon-list"></i></a>
													<?php else: ?>
														<a href="<?= viv('pharmacy/supply_items') ?>?pk=<?= $row->id ?>" class="list-icons-item text-dark"><i class="icon-list"></i></a>
													<?php endif; ?>
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

	<div id="modal_default" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="<?= $classes['modal-global_content'] ?>" id="form_card"></div>
		</div>
	</div>

	<script type="text/javascript">

		function Update(events) {
			event.preventDefault();
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#modal_default').modal('show');
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
