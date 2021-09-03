<?php
require_once '../../tools/warframe.php';
$session->is_auth(5);
is_config("package");
$header = "Мой пакеты назначений";

$tb = new Table($db, "package_bypass");
$search = $tb->get_serch();
$where_search = array("autor_id = $session->session_id", "autor_id = $session->session_id AND ( LOWER(name) LIKE LOWER('%$search%') )");

$tb->where_or_serch($where_search)->order_by("add_date ASC")->set_limit(20);
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
		              	<h5 class="card-title">Добавить пакет назначений</h5>
		          	</div>

                    <div class="card-body" id="form_card">
                      	<?php (new PackageBypassModel)->form(); ?>
                  	</div>

	        	</div>

                <div class="<?= $classes['card'] ?>">

					<div class="<?= $classes['card-header'] ?>">
	                  	<h5 class="card-title">Список пакетов назначений</h5>
	                  	<div class="header-elements">
	                      	<div class="list-icons">
	                          	<a class="list-icons-item" data-action="collapse"></a>
	                      	</div>
	                  	</div>
	              	</div>

              		<div class="card-body">

                  		<div class="table-responsive">
	                      	<table class="table table-hover">
	                          	<thead>
	                              	<tr class="<?= $classes['table-thead'] ?>">
                                        <th style="width:50px">№</th>
										<th style="width:60%">Название</th>
										<th style="width:20%">Дата создания</th>
										<th class="text-right" style="width: 100px">Действия</th>
	                              	</tr>
	                          	</thead>
	                          	<tbody>
									<?php foreach ($tb->get_table(1) as $row): ?>
										<tr>
											<td><?= $row->count ?></td>
											<td><?= $row->name ?></td>
											<td><?= date_f($row->add_date, 1) ?></td>
	                                      	<td class="text-right">
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
													<a onclick="Update('<?= up_url($row->id, 'PackageBypassModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="<?= del_url($row->id, 'PackageBypassModel') ?>" onclick="return confirm('Вы уверены что хотите удалить пакет?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
				                                </div>
	                                      	</td>
                              			</tr>
									<?php endforeach; ?>
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

		function Change(id, stat = null) {
            event.preventDefault();
            $.ajax({
				type: "GET",
				url: "<?= ajax('custom_status') ?>",
				data: { table:"package_bypass", id:id, is_active: stat },
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
				},
			});
		};

	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
