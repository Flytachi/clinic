<?php

use Mixin\Hell;

require_once '../../tools/warframe.php';
$session->is_auth([2, 32]);
$header = "Список пациентов";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
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

				<div class="<?= $classes['card'] ?>">

					<div class="<?= $classes['card-header'] ?>">
						<h6 class="card-title">Список пациентов</h6>
						<div class="header-elements">
							<div class="form-group-feedback form-group-feedback-right mr-2">
							
								<input type="text" class="<?= $classes['input-search'] ?>" value="" id="search_input" placeholder="Поиск..." title="Введите ID или имя">
								<div class="form-control-feedback">
									<i class="icon-search4 font-size-base text-muted"></i>
								</div>
							</div>
							<a onclick="Update('<?= Hell::apiGet('Patient', null, 'form') ?>')" class="btn bg-success btn-icon ml-2 legitRipple"><i class="icon-plus22"></i></a>
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

	<div id="modal_default" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-full">
			<div class="<?= $classes['modal-global_content'] ?>" id="form_card"></div>
		</div>
	</div>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->

	<script type="text/javascript">
		function submitForm() {
			event.preventDefault();
			$.ajax({
				type: $(event.target).attr("method"),
				url: $(event.target).attr("action"),
				data: $(event.target).serializeArray(),
				success: function (res) {
					$('#modal_default').modal('hide');
					if (res.status == "success") {
						new Noty({
							text: "Успешно!",
							type: "success",
						}).show();
						credoSearch();
					} else {
						new Noty({
							text: res.message,
							type: "error",
						}).show();
					}
				},
			});
		}

		function Update(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (res) {
					$('#modal_default').modal('show');
					$('#form_card').html(res);
				},
			});
		};

		var cXhr = null;
		function credoSearch(params = '') {
			if (document.querySelector('#search_display')) {
				if(cXhr && cXhr.readyState != 4) cXhr.abort();
				var display = document.querySelector('#search_display');
				isLoading(display);

				cXhr = $.ajax({
					type: "GET",
					url: "<?= api('table/registry/Patient') ?>"+params,
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
		$("#serch_check").on('change', () => credoSearch());

	</script>

</body>
</html>
