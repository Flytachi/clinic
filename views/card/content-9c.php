<?php
require_once 'callback.php';
is_module('module_bypass');
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>
<!-- <script src="<?= stack("global_assets/js/demo_pages/components_popups.js") ?>"></script> -->

<script src="<?= stack("global_assets/js/plugins/extensions/jquery_ui/interactions.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/ui/fullcalendar/fullcalendar.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/ui/fullcalendar/lang/ru.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/fullcalendar_advanced.js") ?>"></script>


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
							<i class="icon-magazine mr-2"></i>Лист назначений
							<?php if ($activity and $patient->direction and $patient->grant_id == $_SESSION['session_id']): ?>
								<a class="float-right <?= $class_color_add ?>" data-toggle="modal" data-target="#modal_add">
									<i class="icon-plus22 mr-1"></i>Добавить
								</a>
							<?php endif; ?>
							<a onclick="Print('<?= viv('prints/sheet') ?>?id=<?= $patient->visit_id ?>')" class="float-right text-info mr-2">
								<i class="icon-drawer3 mr-1"></i>Лист
							</a>
						</legend>

						<!-- External events -->
						<div class="card">
							<div class="card-header header-elements-inline">
								<h5 class="card-title">External events</h5>
								<div class="header-elements">
									<div class="list-icons">
										<a class="list-icons-item" data-action="collapse"></a>
										<a class="list-icons-item" data-action="reload"></a>
										<a class="list-icons-item" data-action="remove"></a>
									</div>
								</div>
							</div>
							
							<div class="card-body">
								<p class="mb-3">Add extended dragging functionality with <code>droppable</code> option. Data can be attached to the element in order to specify its duration when dropped. A Duration-ish value can be provided. This can either be done via jQuery or via an <code>data-duration</code> attribute. Please note: since droppable option operates with jQuery UI draggables, you must download the appropriate jQuery UI files and initialize a draggable element.</p>

								<div class="row">
									<div class="col-md-3">
										<div class="mb-3" id="external-events">
											<h6>Draggable Events</h6>
											<div class="fc-events-container mb-3">
												<div class="fc-event" data-color="#546E7A">Sauna and stuff</div>
												<div class="fc-event" data-color="#26A69A">Lunch time</div>
												<div class="fc-event" data-color="#546E7A">Meeting with Fred</div>
												<div class="fc-event" data-color="#FF7043">Shopping</div>
												<div class="fc-event" data-color="#5C6BC0">Restaurant</div>
												<div class="fc-event">Basketball</div>
												<div class="fc-event">Daily routine</div>
											</div>

											<div class="form-check form-check-right form-check-switchery">
												<label class="form-check-label">
													<input type="checkbox" class="form-check-input-switchery" checked id="drop-remove">
													Remove after drop
												</label>
											</div>
										</div>
									</div>

									<div class="col-md-9">
										<div class="fullcalendar-external"></div>
									</div>
								</div>
							</div>
						</div>
						<!-- /external events -->

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
		<div id="modal_add" class="modal fade" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content border-3 border-info">
					<div class="modal-header bg-info">
						<h5 class="modal-title">Назначить препарат</h5>
						<button type="button" class="close" data-dismiss="modal">×</button>
					
					</div>

					<?php (new BypassModel)->form() ?>

				</div>
			</div>
		</div>
	<?php endif; ?>

	<div id="modal_show" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-3 border-info" id="div_show">

			</div>
		</div>
	</div>

	<script type="text/javascript">
		function Check(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (data) {
					$('#modal_show').modal('show');
					$('#div_show').html(data);
				},
			});
		};
	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
