<?php
require_once '../../tools/warframe.php';
$session->is_auth(4);
is_module('pharmacy');
$header = "Аптека / Поставки";
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
	                  	<h5 class="card-title">Поставки</h5>
						<div class="header-elements">
							<div class="list-icons">
								<div class="header-elements">
									<div class="list-icons">
										<a onclick="Update('<?= up_url(null, 'WarehouseSupplyModel') ?>')" class="list-icons-item text-success">
											<i class="icon-plus22"></i>Добавить
										</a>
									</div>
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
                    url: "<?= api('table/pharmacy/Supply') ?>"+params,
                    success: function (result) {
                        isLoaded(display);
                        display.innerHTML = result;
                    },
                });

            }
        }

		function Update(events) {
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

        $(document).ready(() => credoSearch());

    </script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->

</body>
</html>
