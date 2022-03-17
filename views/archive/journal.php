<?php
require_once '../../tools/warframe.php';
$session->is_auth();
$header = "Журнал";
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
						<h5 class="card-title">Журнал</h5>
						<div class="header-elements">
							<form action="" class="mr-2">
								<div class="form-group-feedback form-group-feedback-right">
									<input type="text" class="form-control border-info" value="" id="search_input" placeholder="Введите ID или имя">
									<div class="form-control-feedback">
										<i class="icon-search4 font-size-base text-muted"></i>
									</div>
								</div>
							</form>
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
		<div class="modal-dialog modal-lg">
			<div class="<?= $classes['modal-global_content'] ?>" id="form_card"></div>
		</div>
	</div>

	<script type="text/javascript">

		function credoSearch(params = '') {
			if (document.querySelector('#search_display')) {
				var display = document.querySelector('#search_display');
				isLoading(display);

				$.ajax({
					type: "GET",
					url: "<?= api('table/archive/Journal') ?>"+params,
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

		function Check(events) {
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
