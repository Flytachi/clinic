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
							<i class="icon-files-empty mr-2"></i>Документы
							<?php if ($activity and !$patient->direction or ($patient->direction and $patient->grant_id == $_SESSION['session_id'])): ?>
								<a class="float-right <?= $class_color_add ?>" data-toggle="modal" data-target="#modal_route">
									<i class="icon-plus22 mr-1"></i>Добавить
								</a>
							<?php endif; ?>
						</legend>

						<div class="card">

							<div class="table-responsive">
								<table class="table table-hover table-sm">
									<thead class="<?= $classes['table-thead'] ?>">
										<tr>
											<th>№</th>
											<th>Файл</th>
											<th>Метка</th>
											<th>Автор</th>
											<th>Дата загрузки</th>
											<th class="text-right">Действия</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$tb = new Table($db, "visit_documents");
										$tb->where("visit_id = $patient->visit_id")->order_by('add_date ASC');
										?>
										<?php foreach ($tb->get_table(1) as $row): ?>
											<tr id="TR_<?= $row->id ?>">
												<td><?= $row->count ?></td>
												<td></td>
												<td><?= $row->mark ?></td>
												<td><?= get_full_name($row->parent_id) ?></td>
												<td><?= ($row->add_date) ? date_f($row->add_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
												<td class="text-right">
													<button type="button" class="<?= $classes['btn-viewing'] ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Просмотр</button>
													<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
														<a onclick="Check('<?= ajax('document_view') ?>?pk=<?= $row->id ?>')" class="dropdown-item"><i class="icon-eye"></i>Просмотр</a>
														<!-- <?php if( $activity and $row->status == 1 ): ?>
															<a onclick="Delete('<?= del_url($row->id, 'VisitServicesModel') ?>', '#TR_<?= $row->id ?>')" class="dropdown-item"><i class="icon-x"></i>Отмена</a>
														<?php endif; ?>
														<?php if ( in_array($row->status, [3,5,7]) ): ?>
															<a <?= ($row->completed) ? 'onclick="Print(\''. prints('document-1').'?id='. $row->id. '\')"' : 'class="text-muted dropdown-item"' ?> class="dropdown-item"><i class="icon-printer2"></i> Печать</a>
														<?php endif; ?> -->
													</div>
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

	<?php if ($activity): ?>
		<div id="modal_route" class="modal fade" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="<?= $classes['modal-global_content'] ?>">
					<div class="<?= $classes['modal-global_header'] ?>">
						<h6 class="modal-title">Назначить визит</h6>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>

					<div class="modal-body">

						<?php (new VisitDocumentsModel)->form(); ?>

					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<div id="modal_report_show" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg" id="modal_class_show">
			<div class="<?= $classes['modal-global_content'] ?>" id="report_show">

			</div>
		</div>
	</div>

	<script type="text/javascript">
		function Check(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (data) {
					$('#modal_report_show').modal('show');
					$('#report_show').html(data);
				},
			});
		};

		function Delete(events, tr) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					var data = JSON.parse(result);

					if (data.status == "success") {

						$(tr).css("background-color", "red");
						$(tr).css("color", "white");
						$(tr).fadeOut('slow', function() {
							$(this).remove();
						});
						new Noty({
							text: data.message,
							type: 'success'
						}).show();
						
					}else {

						new Noty({
							text: data.message,
							type: 'error'
						}).show();
						
					}
				},
			});
		};
	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
