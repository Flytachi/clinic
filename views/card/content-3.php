<?php
require_once 'callback.php';
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

				<?php include "profile.php"; ?>

				<div class="<?= $classes['card'] ?>">
				    <div class="<?= $classes['card-header'] ?>">
				        <h6 class="card-title">Просмотр визита</h6>
				    </div>

				    <div class="card-body">

				        <?php include "content_tabs.php"; ?>

						<legend class="font-weight-semibold text-uppercase font-size-sm">
							<i class="icon-archive mr-2"></i>Другие визиты
						</legend>
						
						<div class="card">

							<div class="table-responsive">
								<table class="table table-hover table-sm">
									<thead>
										<tr class="<?= $classes['table-thead'] ?>">
											<th>№</th>
											<th style="width: 16%">№ Визита</th>
											<th>Дополнения</th>
											<th style="width: 11%">Дата визита</th>
											<th style="width: 11%">Дата завершения</th>
											<th>Тип визита</th>
											<th>Статус</th>
											<th class="text-right" style="width:210px">Действия</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$tb = new Table($db, "visits v");
										$tb->set_data("v.id, vr.id 'status_name', v.add_date, v.completed, v.direction")->additions("LEFT JOIN visit_status vr ON (v.id = vr.visit_id)");
										$tb->where("v.patient_id = $patient->id AND v.id != $patient->visit_id")->order_by('v.add_date DESC');
										?>
										<?php foreach($tb->get_table(1) as $row): ?>
											<tr>
												<td><?= $row->count ?></td>
												<td><?= $row->id ?></td>
												<td>
													<?php if ( $row->status_name ): ?>
														<span style="font-size:13px;" class="badge badge-flat border-danger text-danger"><?= $row->status_name ?></span>
													<?php endif; ?>
												</td>
												<td><?= ($row->add_date) ? date_f($row->add_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
												<td><?= ($row->completed) ? date_f($row->completed, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
												<td>
													<?php if ($row->direction): ?>
														<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Стационарный</span>
													<?php else: ?>
														<span style="font-size:15px;" class="badge badge-flat border-primary text-primary">Амбулаторный</span>
													<?php endif; ?>
												</td>
												<td>
													<?php if ($row->completed): ?>
														<span style="font-size:15px;" class="badge badge-flat border-success text-success">Завершён</span>
													<?php else: ?>
														<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Не завершён</span>
													<?php endif; ?>
												</td>
												<td class="text-right">
													<?php if(permission([5])): ?>
														<a href="<?= viv('card/content-6') ?>?pk=<?= $row->id ?>" type="button" class="<?= $classes['btn-viewing'] ?>">Просмотр</a>
													<?php elseif(permission([2,32])): ?>
														<a href="<?= viv('card/content-5') ?>?pk=<?= $row->id ?>" type="button" class="<?= $classes['btn-viewing'] ?>">Просмотр</a>
													<?php elseif(permission(6)): ?>
														<a href="<?= viv('card/content-7') ?>?pk=<?= $row->id ?>" type="button" class="<?= $classes['btn-viewing'] ?>">Просмотр</a>
													<?php elseif(permission(10)): ?>
														<a href="<?= viv('card/content-8') ?>?pk=<?= $row->id ?>" type="button" class="<?= $classes['btn-viewing'] ?>">Просмотр</a>
													<?php elseif(permission(12)): ?>
														<a href="<?= viv('card/content-10') ?>?pk=<?= $row->id ?>" type="button" class="<?= $classes['btn-viewing'] ?>">Просмотр</a>
													<?php else: ?>
														<a href="<?= viv('card/content-4') ?>?pk=<?= $row->id ?>" type="button" class="<?= $classes['btn-viewing'] ?>">Просмотр</a>
													<?php endif; ?>
												</td>
											</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>

						</div>

				    </div>

				    <!-- /content wrapper -->
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
		function Check(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (data) {
					$('#modal_default').modal('show');
					$('#form_card').html(data);
				},
			});
		};
	</script>

	<?php if(module('module_laboratory')): ?>
		<script type="text/javascript">

			items = [];

			function Change_lab(tbody, id) {
				if (tbody.dataset.stat == 1) {
					tbody.dataset.stat = "0";
					tbody.className = "";

					for(let a = 0; a < items.length; a++){
						if(items[a] == id ){
							items.splice(a, 1);
						}
					}

				}else {
					tbody.dataset.stat = "1";
					tbody.className = "table-warning";
					items.push(id);
				}
			}

			function PrePrint(url) {
				if (items.length != 0) {
					Print(url+`&items=[${items}]`);
				}
			}

		</script>
	<?php endif; ?>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
