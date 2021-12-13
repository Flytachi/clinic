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
							<?php if ($activity and (!$patient->direction or ($patient->direction and permission(5))) ): ?>
								<a onclick='Update(`<?= up_url(null, "VisitDocumentModel") ?>&patient=<?= json_encode($patient) ?>`)' class="float-right text-primary">
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
											<th>Формат</th>
											<th>Метка</th>
											<th>Автор</th>
											<th>Дата загрузки</th>
											<th class="text-right">Действия</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$tb = (new VisitDocumentModel)->Where("visit_id = $patient->visit_id")->Order("add_date ASC");
										?>
										<?php foreach ($tb->list(1) as $row): ?>
											<tr id="TR_<?= $row->id ?>">
												<td><?= $row->count ?></td>
												<td class="text-primary">
													<?php if( $row->location ): ?>
														<?php if($row->file_extension == "pdf"): ?>
															<i class="icon-2x icon-file-pdf"></i>
														<?php elseif( in_array($row->file_extension, [ "doc", "docx" ])): ?>
															<i class="icon-2x icon-file-word"></i>
														<?php elseif( in_array($row->file_extension, [ "csv", "xlsx" ]) ): ?>
															<i class="icon-2x icon-file-excel"></i>
														<?php elseif( in_array($row->file_extension, [ "mp4" ]) ): ?>
															<i class="icon-2x icon-file-video"></i>
														<?php elseif( in_array($row->file_extension, [ "jpg", "png" ]) ): ?>
															<i class="icon-2x icon-file-picture"></i>
														<?php elseif( in_array($row->file_extension, [ "txt" ]) ): ?>
															<i class="icon-2x icon-file-text2"></i>
														<?php else: ?>
															<i class="icon-2x icon-file-empty"></i>
														<?php endif; ?>
														<span class="ml-1"><?= bytes($row->file_size, 'MB') ?></span>
													<?php else: ?>
														<span class="text-muted">Нет данных</span>
													<?php endif; ?>
												</td>
												<td>
													<?php if( $row->file_extension ): ?>
														<?= $row->file_extension ?>
													<?php else: ?>
														<span class="text-muted">Нет данных</span>
													<?php endif; ?>
												</td>
												<td><?= $row->mark ?></td>
												<td><?= get_full_name($row->responsible_id) ?></td>
												<td><?= ($row->add_date) ? date_f($row->add_date, 1) : '<span class="text-muted">Нет данных</span>' ?></td>
												<td class="text-right">
													<button type="button" class="<?= $classes['btn-viewing'] ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Просмотр</button>
													<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(1153px, 186px, 0px);">
														<a onclick="Check('<?= ajax('document_view') ?>?pk=<?= $row->id ?>')" class="dropdown-item"><i class="icon-eye"></i>Просмотр</a>
														<?php if( $activity and $session->session_id == $row->responsible_id ): ?>
															<a onclick='Update(`<?= up_url($row->id, "VisitDocumentModel") ?>&patient=<?= json_encode($patient) ?>`)' class="dropdown-item"><i class="icon-pencil7"></i>Редактировать</a>
															<a href="<?= del_url($row->id, 'VisitDocumentModel') ?>" class="dropdown-item"><i class="icon-x"></i>Удалить</a>
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

		function Update(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#modal_default').modal('show');
					$('#form_card').html(result);
				},
			});
		};

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

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
