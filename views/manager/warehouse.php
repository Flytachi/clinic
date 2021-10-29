<?php
require_once '../../tools/warframe.php';
$session->is_auth(2);
is_module('pharmacy');
$header = "Склады";
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

                        <?php (new WarehouseModel)->form(); ?>

					</div>

				</div>

				<div class="<?= $classes['card'] ?>">

	          		<div class="<?= $classes['card-header'] ?>">
	                  	<h5 class="card-title">Склады</h5>
	              	</div>

              		<div class="card-body">
                  		<div class="table-responsive">
	                      	<table class="table table-hover">
	                          	<thead class="<?= $classes['table-thead'] ?>">
	                              	<tr>
									  	<th style="width:50px">№</th>
									  	<th>Наименование</th>
									  	<th style="width:35%">Ответственное лицо</th>
									  	<th>Роли</th>
                                        <th>Отделы</th>
                                        <th style="width: 100px">Действия</th>
	                              	</tr>
	                          	</thead>
	                          	<tbody>
									<?php
									$tb = new Table($db, "warehouses");
									?>
                                    <?php foreach ($tb->get_table(1) as $row): ?>
										<tr>
											<td><?= $row->count ?></td>
											<td><?= $row->name ?></td>
											<td><?= get_full_name($row->parent_id) ?></td>
											<td>
                                                <?php foreach (json_decode($row->level) as $key): ?>
                                                    <li><?= $PERSONAL[$key] ?></li>
                                                <?php endforeach; ?>
                                            </td>
                                            <td>
                                                <?php if ( isset($row->division) ): ?>
                                                    <?php foreach (json_decode($row->division) as $key): ?>
                                                        <li><?= $db->query("SELECT title FROM divisions WHERE id = $key")->fetchColumn() ?></li>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <span class="text-muted">Нет данных</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
												<div class="list-icons">
                                                    <div class="dropdown">                      
														<?php if ($row->is_active): ?>
															<a href="#" id="status_change_<?= $row->id ?>" class="badge bg-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Active</a>
														<?php else: ?>
															<a href="#" id="status_change_<?= $row->id ?>" class="badge bg-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Pasive</a>
														<?php endif; ?>

														<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(74px, 21px, 0px);">
															<a onclick="Change(<?= $row->id ?>, 1)" class="dropdown-item">
																<span class="badge badge-mark mr-2 border-success"></span>
																Active
															</a>
															<a onclick="Change(<?= $row->id ?>, 0)" class="dropdown-item">
																<span class="badge badge-mark mr-2 border-secondary"></span>
																Pasive
															</a>
														</div>
													</div>
													<a onclick="ShowConf('<?= up_url($row->id, 'WarehouseSettingModel') ?>')" class="list-icons-item text-primary"><i class="icon-cog4"></i></a>
													<a onclick="Update('<?= up_url($row->id, 'WarehouseModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<?php if (config("admin_delete_button_warehouses")): ?>										
                                                        <a href="<?= del_url($row->id, 'WarehouseModel') ?>" onclick="return confirm('Вы уверены что хотите удалить склад?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
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
			<div class="<?= $classes['modal-global_content'] ?>" id="modal_default_card"></div>
		</div>
	</div>

	<script type="text/javascript">

		function Change(id, stat = null) {
            event.preventDefault();
            $.ajax({
				type: "GET",
				url: "<?= ajax('manager_status') ?>",
				data: { table:"warehouses", id:id, is_active: stat },
				success: function (data) {
                    if (data) {
						var badge = document.getElementById(`status_change_${id}`);
						if (data == 1) {
							badge.className = "badge bg-success dropdown-toggle";
							badge.innerHTML = "Active";
							badge.onclick = `Change(${id}, 1)`;
						}else if (data == 0) {
							badge.className = "badge bg-secondary dropdown-toggle";
							badge.innerHTML = "Pasive";
							badge.onclick = `Change(${id}, 0)`;
						}
                    }
				},
			});
        }

		function Update(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#form_card').html(result);
                    BootstrapMultiselect.init();
				},
			});
		};

		function ShowConf(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#modal_default').modal('show');
					$('#modal_default_card').html(result);
				},
			});
		};

	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->

</body>
</html>
