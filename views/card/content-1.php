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

						<?php
						include "content_tabs.php";
						if ($patient->direction) {
							$title = "Обход";
							$table_tr = "table-info";
						} else {
							$title = "Осмотр";
							$table_tr = "";
						}
						?>

						<legend class="font-weight-semibold text-uppercase font-size-sm">
							<i class="icon-repo-forked mr-2"></i><?= $title ?>
							<a onclick='Update(`<?= up_url($patient->visit_id, "VisitJournalsModel") ?>&patient=<?= json_encode($patient) ?>&activity=<?= $activity ?>`)' class="float-right text-info ml-2">
								<i class="icon-book mr-1"></i>Дневник
							</a>
							<?php if ($activity and $patient->direction and is_grant()): ?>
								<a onclick='Check(`<?= up_url(null, "VisitRoute", "form_second") ?>&patient=<?= json_encode($patient) ?>`)' class="float-right <?= $class_color_add ?> mr-2">
									<i class="icon-plus22 mr-1"></i>Услуга
								</a>
							<?php endif; ?>
							<?php if (config("package") and $activity and permission(5) and !$patient->direction): ?>
								<a onclick='Check(`<?= up_url(null, "VisitRoute", "form_package") ?>&patient=<?= json_encode($patient) ?>`)' href="" class="float-right text-teal">
									<i class="icon-bag mr-1"></i>Пакеты
								</a>
							<?php endif; ?>
						</legend>

						<div class="card">

							<div class="table-responsive">
								<table class="table table-hover table-sm">
									<thead class="<?= $classes['table-thead'] ?>">
										<tr>
											<th>Услуга</th>
											<th class="text-right" style="width: 50%">Действия</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$tb = (new VisitServiceModel)->tb();
										$tb->set_data("id, service_id, service_name, service_title, status")->where("visit_id = $patient->visit_id AND responsible_id = $session->session_id AND status IN (3,7)")->order_by('id ASC');
										?>
										<?php foreach ($tb->get_table() as $row): ?>
											<tr id="TR_<?= $row->id ?>" class="list_services <?= ( isset($row->service_id) and $row->service_id == 1) ? "table-warning" :$table_tr ?>">
												<td><?= $row->service_name ?></td>
												<td class="text-right" id="VisitService_tr_<?= $row->id ?>" data-is_new="<?= ($row->service_title) ? '' : 1 ?>">
													<?php if ( isset($row->service_id) and $row->service_id == 1): ?>
														<button onclick="Update('<?= up_url($row->id, 'VisitReport', 'form_finish') ?>')" type="button" class="btn btn-outline-danger btn-sm legitRipple">Выписка</button>
													<?php else: ?>
														<?php if ( $row->service_title ): ?>
															<?php if ( $activity and is_grant() and $row->status == 3 ): ?>
																<a href="<?= up_url($row->id, 'VisitFinish', "service") ?>" type="button" class="<?= $classes['btn-completed'] ?>">Завершить</a>
															<?php endif; ?>
															<button onclick="Check('<?= viv('doctor/report') ?>?pk=<?= $row->id ?>')" type="button" class="<?= $classes['btn-viewing'] ?>"><i class="icon-eye mr-2"></i> Просмотр</button>
															<?php if ( $activity and $row->status == 3 ): ?>
																<button onclick="Update('<?= up_url($row->id, 'VisitReport') ?>')" type="button" class="btn btn-outline-success btn-sm legitRipple">Редактировать</button>
															<?php endif; ?>
														<?php else: ?>
															<?php if ( $activity and $row->status == 3 ): ?>
																<button onclick="Update('<?= up_url($row->id, 'VisitReport') ?>')" type="button" class="btn btn-outline-success btn-sm legitRipple">Провести</button>
															<?php endif; ?>
														<?php endif; ?>
													<?php endif; ?>
													
													<?php if ( $activity and $row->status == 3 ): ?>
														<button onclick="FailureVisitService('<?= del_url($row->id, 'VisitFailure') ?>')" type="button" class="btn btn-outline-danger btn-sm legitRipple">Отмена</button>
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

	<div id="modal_report" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg" style="max-width: 1200px !important;">
			<div class="<?= $classes['modal-global_content'] ?>" id="form_card_report"></div>
		</div>
	</div>

	<div id="modal_default" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="<?= $classes['modal-global_content'] ?>" id="form_card"></div>
		</div>
	</div>

	<?php if ($activity): ?>
		<script type="text/javascript">

			function FailureVisitService(url) {
			
				$.ajax({
					type: "GET",
					url: url,
					success: function (result) {
						var data = JSON.parse(result);

						if (data.status == "success") {
							var list = document.querySelectorAll(".list_services");
				
							if (list.length == 1) {
								location = "<?= viv('doctor/index') ?>";
							}else{
								new Noty({
									text: 'Процедура отказа прошла успешно!',
									type: 'success'
								}).show();
								
								$(`#TR_${data.pk}`).css("background-color", "rgb(244, 67, 54)");
								$(`#TR_${data.pk}`).css("color", "white");
								$(`#TR_${data.pk}`).fadeOut(900, function() {
									$(this).remove();
								});
							}
							
						}else{

							new Noty({
								text: data.message,
								type: 'error'
							}).show();

						}
					},
				});
			}

		</script>
	<?php endif; ?>

	<script type="text/javascript">

		function Update(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#modal_report').modal('show');
					$('#form_card_report').html(result);
				},
			});
		};

		function Check(events) {
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
