<?php
require_once '../../tools/warframe.php';
$session->is_auth(3);
$header = "Анализы";

$tb = (new ServiceAnalyzeModel)->as('sl');
$tb->Data("sl.*, sc.name 'service_name'")->Join("LEFT JOIN services sc ON(sc.id=sl.service_id)");
$search = $tb->getSearch();
$where_search = array("sl.branch_id = $session->branch", "sl.branch_id = $session->branch AND (LOWER(sc.name) LIKE LOWER('%$search%') OR LOWER(sl.code) LIKE LOWER('%$search%') OR LOWER(sl.name) LIKE LOWER('%$search%'))");
$tb->Where($where_search)->Order("sc.name, sl.code, sl.name ASC")->Limit(20);
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
                      	<h5 class="card-title">Добавить Анализ</h5>
                      	<div class="header-elements">
                          	<div class="list-icons">
                              	<a class="list-icons-item" data-action="collapse"></a>
                          	</div>
                      	</div>
                  	</div>
                  	<div class="card-body" id="form_card">
                      	<?php $tb->form(); ?>
                  	</div>

            	</div>

                <div class="<?= $classes['card'] ?>">

                    <div class="<?= $classes['card-header'] ?>">
                        <h5 class="card-title">Список Анализов</h5>
                        <div class="header-elements">
							<div class="form-group-feedback form-group-feedback-right mr-2">
								<input type="text" class="<?= $classes['input-search'] ?>" value="<?= $search ?>" id="search_input" placeholder="Поиск..." title="Введите код, название анализа или название услуги">
								<div class="form-control-feedback">
									<i class="icon-search4 font-size-base text-muted"></i>
								</div>
							</div>
                        </div>
                    </div>

					<div class="card-body" id="search_display">

                  		<div class="table-responsive">
	                      	<table class="table table-hover">
	                          	<thead class="<?= $classes['table-thead'] ?>">
									<tr>
                                        <th style="width:7%">№</th>
                                        <th>Услуга</th>
                                        <th>Код</th>
                                        <th>Название</th>
                                        <th>Норма</th>
										<th>Ед</th>
                                        <th style="width: 100px">Действия</th>
                                    </tr>
	                          	</thead>
	                          	<tbody>
								  	<?php foreach($tb->list(1) as $row): ?>
                                  		<tr>
											<td><?= $row->count ?></td>
											<td><?= $row->service_name ?></td>
											<td><?= $row->code ?></td>
											<td><?= $row->name ?></td>
											<td>
												<?= preg_replace("#\r?\n#", "<br />", $row->standart) ?>
											</td>
											<td>
												<?= preg_replace("#\r?\n#", "<br />", $row->unit) ?>
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
													<a onclick="Update('<?= up_url($row->id, 'ServiceAnalyzeModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<?php if (config("admin_delete_button_analyzes")): ?>										
														<a href="<?= del_url($row->id, 'ServiceAnalyzeModel') ?>" onclick="return confirm('Вы уверены что хотите удалить анализ?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
													<?php endif; ?>
				                                </div>
	                                      	</td>
                              			</tr>
									<?php endforeach; ?>
	                          	</tbody>
	                      	</table>
	                  	</div>

						<?php $tb->panel(); ?>

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

	<script type="text/javascript">

		$("#search_input").keyup(function() {
			var input = document.querySelector('#search_input');
			var display = document.querySelector('#search_display');
			$.ajax({
				type: "GET",
				url: "<?= ajax('admin/search_analyze') ?>",
				data: {
					table_search: input.value,
				},
				success: function (result) {
					display.innerHTML = result;
				},
			});
		});

		function Change(id, stat = null) {
            event.preventDefault();
            $.ajax({
				type: "GET",
				url: "<?= ajax('manager_status') ?>",
				data: { table:"service_analyzes", id:id, is_active: stat },
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

</body>
</html>
