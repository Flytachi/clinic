<?php
require_once 'callback.php';
is_module('module_bypass');
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<script src="<?= stack("global_assets/js/plugins/extensions/jquery_ui/interactions.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/ui/fullcalendar/fullcalendar.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/ui/fullcalendar/lang/ru.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/fullcalendar_advanced.js") ?>"></script>
<script src="<?= stack("assets/js/custom.js") ?>"></script>


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
							
							<div class="card-body">

								<div class="row">
									<div class="col-md-4">
										<div class="mb-3" id="external-events">
											<h6>Пакеты назначений</h6>

											<?php (new BypassPanel)->TabPanel($patient->visit_id) ?>


											<div class="form-check form-check-right form-check-switchery">
												<label class="form-check-label">
													<input type="checkbox" class="swit" id="item-information">
													Показать данные
												</label>
											</div>
											<!-- <div class="form-check form-check-right form-check-switchery">
												<label class="form-check-label">
													<input type="checkbox" class="form-check-input-switchery" id="drop-remove">
													Удалить после использования
												</label>
											</div> -->
										</div>
									</div>

									<div class="col-md-8">
										<div class="fullcalendar-external" style="height: 670px;"></div>
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

	<div id="modal_default" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-full">
			<div class="<?= $classes['modal-global_content'] ?>" id="form_card"></div>
		</div>
	</div>

	<div id="modal_event_card" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content border-3 border-info" id="event_card_body">

			</div>
		</div>
	</div>

	<script type="text/javascript">

 		var bypassEventUrl = "<?= ajax('visit_events').'?pk='.$patient->visit_id ?>";

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

		function toTimestamp(strDate) {
            var datum = Date.parse(strDate);
            return datum / 1000;
        }

		function toDataformat(strDate) {
			return new (Function.prototype.bind.apply(
				Date,
				[null].concat(strDate)
			))();
        }


		function CalendarDrop(info, element) {
			if ($("#drop-remove").is(":checked")) {
				// is the "remove after drop" checkbox checked?
				$(element).remove(); // if so, remove the element from the "Draggable Events" list
			}
			if (Array.isArray(info._i)) {
				var d_date = toDataformat(info._i)
				var is_time = true;
			} else {
				var d_date = info._d;
				var is_time = null;
			}

			$.ajax({
				type: "POST",
				url: "<?= add_url() ?>",
				data: {
					model: "VisitBypassEventsModel",
					visit_id: "<?= $patient->visit_id ?>",
					visit_bypass_id: element.dataset.id,
					parent_id: "<?= $session->session_id ?>",
					user_id: "<?= $patient->id ?>",
					event_title: element.innerHTML,
					event_start: toTimestamp(d_date),
					is_time: is_time,
					event_color: element.dataset.color,
				},
				success: function (result) {
					console.log("create event => "+result);
					FullCalendarAdvanced.init(bypassEventUrl);
				},
			});
		};

		function CalendarEventDropAndResize(info, element) {
			var start_time = toTimestamp(toDataformat(info.start._i));
			var end_time = null;
			if (info.end) {
				end_time = toTimestamp(toDataformat(info.end._i));
			}

			console.log(info.start._i);
			console.log(toDataformat(info.start._i));
			console.log(toTimestamp(toDataformat(info.start._i)));

			$.ajax({
				type: "POST",
				url: "<?= add_url() ?>",
				data: {
					model: "VisitBypassEventsModel",
					id: info.id,
					event_start: start_time,
					event_end: end_time,
				},
				success: function (result) {
					console.log("update event => "+result);
				},
			});
		};

		function CalendarEventClick(info, element) {
			$("#modal_event_card").modal("show");
			// $('#modal_event_card').html(data);
			// delete
			// $(".fullcalendar-external").fullCalendar(
			//     "removeEvents",
			//     function (ev) {
			//         return ev._id == info._id;
			//     }
			// );
		};

		
		function CheckPack(params) {
			$('.fullcalendar-external').fullCalendar('destroy');
			$('.fullcalendar-external').html('<img src="<?= stack('assets/images/load.gif') ?>" alt="Загрузка..."/>');
			
			$.ajax({
				type: "GET",
				url: "<?= ajax('visit_event_bypass_change') ?>",
				data: {pk:params.dataset.id},
				success: function (bypassEventStatus) {
					$('.fullcalendar-external').html('');
					params.dataset.check = true;
					if(bypassEventStatus == "success"){

						FullCalendarAdvanced.init(bypassEventUrl);
						params.style.backgroundColor='';
						params.style.borderColor='';

					}else{

						FullCalendarAdvanced.block(bypassEventUrl);
						params.style.backgroundColor='#546E7A';
						params.style.borderColor='#546E7A';
						// params.style.pointerEvents='none';
						new Noty({
							text: '<strong>Внимание!</strong><br>'+bypassEventStatus,
							type: 'error'
						}).show();

					}
				},
			});

		};

		function PackDefault(params) {
			if(!params.dataset.check){
				FullCalendarAdvanced.init(bypassEventUrl);
			}
			params.dataset.check = false;
		}

		document.addEventListener("DOMContentLoaded", function () {
			FullCalendarAdvanced.init(bypassEventUrl);
		});

	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
