<?php
require_once '../../tools/warframe.php';
$session->is_auth(5);
$header = "Приём пациетов";
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
						<h6 class="card-title">Пациенты на приём</h6>
						<div class="header-elements">
							<div class="form-group-feedback form-group-feedback-right mr-2">
								<input type="text" class="<?= $classes['input-search'] ?>" id="search_input" placeholder="Поиск..." title="Введите ID, имя пациента или название услуги">
								<div class="form-control-feedback">
									<i class="icon-search4 font-size-base text-muted"></i>
								</div>
							</div>
						</div>
					</div>

					<div class="card-body" id="search_display"></div>

				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<script type="text/javascript">

		function VisitUpStatus(id) {
			$.ajax({
				type: "POST",
				url: "<?= add_url() ?>",
				data: {
					model: "VisitServiceUp",
					id: id,
					status: 3,
					parent_id: "<?= $session->session_id ?>",
					accept_date: date_format(new Date()),
				},
				success: function (result) {
					console.log(result);
					var data = JSON.parse(result);

					if (data.status == "success") {
						new Noty({
							text: 'Процедура приёма прошла успешно!',
							type: 'success'
						}).show();
						
						$(`#VisitService_tr_${data.pk}`).css("background-color", "rgb(0, 255, 0)");
                        $(`#VisitService_tr_${data.pk}`).css("color", "black");
                        $(`#VisitService_tr_${data.pk}`).fadeOut(900, function() {
							$(this).remove();
                        });
						
					}else{

						new Noty({
							text: data.message,
							type: 'error'
						}).show();

					}
 				},
			});
		}

		function FailureVisitService(url) {
			$.ajax({
				type: "GET",
				url: url,
				success: function (result) {
					var data = JSON.parse(result);

					if (data.status == "success") {
						new Noty({
							text: 'Процедура отказа прошла успешно!',
							type: 'success'
						}).show();
						
						$(`#VisitService_tr_${data.pk}`).css("background-color", "rgb(244, 67, 54)");
                        $(`#VisitService_tr_${data.pk}`).css("color", "white");
                        $(`#VisitService_tr_${data.pk}`).fadeOut(900, function() {
							$(this).remove();
                        });
						
					}else{

						new Noty({
							text: data.message,
							type: 'error'
						}).show();

					}
 				},
			});
		}

		var cXhr = null;
		function credoSearch(params = '') {
			if (document.querySelector('#search_display')) {
				if(cXhr && cXhr.readyState != 4) cXhr.abort();
				var display = document.querySelector('#search_display');
				isLoading(display);

				cXhr = $.ajax({
					type: "GET",
					url: "<?= api('table/doctor/ServiceIndex') ?>"+params,
					data: {
						CRD_search: document.querySelector('#search_input').value,
					},
					success: function (result) {
						isLoaded(display);
						display.innerHTML = result;
					},
				});

			}
		}

        $(document).ready(() => credoSearch());
		$("#search_input").keyup(() => credoSearch());

	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
