<?php

use Mixin\Hell;

require_once '../../tools/warframe.php';
$session->is_auth(1);
$header = "Услуги";

importModel('ServiceTerm');
$tb = new Table($db, "services sc");
$tb->set_data("sc.*, ds.title")->additions("LEFT JOIN divisions ds ON(ds.id=sc.division_id)");
$search = $tb->get_serch();
$where_search = array("sc.type != 101", "sc.type != 101 AND ( sc.code LIKE '%$search%' OR LOWER(sc.name) LIKE LOWER('%$search%') OR LOWER(ds.title) LIKE LOWER('%$search%') )");

$tb->where_or_serch($where_search)->order_by("user_level, division_id, code, name ASC")->set_limit(15);
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
		              	<h5 class="card-title">Добавить Услугу</h5>
		          	</div>

		          	<div class="card-body">

						<div class="row">

							<div class="col-md-9" id="form_card"><?php (new ServiceModel)->form(); ?></div>

							<div class="col-md-3"><?php (new ServiceModel)->form_template(); ?></div>

						</div>

		          	</div>

	        	</div>

        		<div class="<?= $classes['card'] ?>">

	          		<div class="<?= $classes['card-header'] ?>">
	                  	<h5 class="card-title">Список Услуг</h5>
	                  	<div class="header-elements">
	                      	<div class="list-icons">
							  	<a href="<?= download_url('ServiceModel', 'Услуги') ?>" class="btn">Шаблон</a>
	                      	</div>
							<div class="form-group-feedback form-group-feedback-right mr-2 ml-2">
								<input type="text" class="<?= $classes['input-search'] ?>" value="<?= $search ?>" id="search_input" placeholder="Поиск..." title="Введите код, отдел или название услуги">
								<div class="form-control-feedback">
									<i class="icon-search4 font-size-base text-muted"></i>
								</div>
							</div>
	                  	</div>
	              	</div>

              		<div class="card-body" id="search_display">

                  		<div class="table-responsive">
	                      	<table class="table table-hover">
	                          	<thead>
	                              	<tr class="<?= $classes['table-thead'] ?>">
										<th style="width:7%">№</th>
										<th>Роль</th>
										<th>Отдел</th>
										<th style="width:10%">Код</th>
										<th style="width:40%">Название</th>
										<th>Тип</th>
										<th>Цена</th>
										<th style="width: 100px">Действия</th>
	                              	</tr>
	                          	</thead>
	                          	<tbody>
	                              	<?php foreach($tb->get_table(1) as $row): ?>
                                  		<tr>
											<td><?= $row->count ?></td>
	                                      	<td><?= $PERSONAL[$row->user_level] ?></td>
	                                      	<td><?= $row->title ?></td>
											<td><?= $row->code ?></td>
											<td>
												<?php
												if( $term = (new ServiceTerm)->by(array('service_id'=>$row->id), 'day') ) echo '<span class="badge badge-danger mr-1">' . $term->day . ' day</span>';
												?>
												<?= $row->name ?>
											</td>
											<td>
												<?php switch ($row->type) {
													case 1:
														echo "Обычная";
														break;
													case 2:
														echo "Консультация";
														break;
													case 3:
														echo "Операционная";
														break;
												} ?>
											</td>
											<td><?= number_format($row->price) ?>/<?= number_format($row->price_foreigner) ?></td>
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
													<?php if($row->type == 2): ?>
														<a onclick="ShowConf('<?= Hell::apiAxe('ServiceTerm', array('service_id'=>$row->id)) ?>')" class="list-icons-item text-primary"><i class="icon-cog4"></i></a>
													<?php endif; ?>
													<a onclick="Update('<?= up_url($row->id, 'ServiceModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<?php if (config("admin_delete_button_services")): ?>										
														<a href="<?= del_url($row->id, 'ServiceModel') ?>" onclick="return confirm('Вы уверены что хотите удалить услугу?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
													<?php endif; ?>
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

	<div id="modal_default" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="<?= $classes['modal-global_content'] ?>" id="modal_default_card"></div>
		</div>
	</div>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->

	<script type="text/javascript">

		function Change(id, stat = null) {
            event.preventDefault();
            $.ajax({
				type: "GET",
				url: "<?= ajax('admin_status') ?>",
				data: { table:"services", id:id, is_active: stat },
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

		$("#search_input").keyup(function() {
			var input = document.querySelector('#search_input');
			var display = document.querySelector('#search_display');
			$.ajax({
				type: "GET",
				url: "<?= ajax('admin/search_service') ?>",
				data: {
					table_search: input.value,
				},
				success: function (result) {
					display.innerHTML = result;
				},
			});
		});

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

</body>
</html>
