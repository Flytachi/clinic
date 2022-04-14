<?php

use Mixin\Hell;

require_once '../../tools/warframe.php';
$session->is_auth();
is_module('pharmacy');
$header = "Рабочий стол";

if ( isset($_GET['pk']) and is_numeric($_GET['pk']) ) {

	importModel('Warehouse', 'WarehouseStorage', 'WarehouseStorageApplication');

	$warehouse = (new Warehouse)->byId($_GET['pk']);
	if ($warehouse) {
		$data = $db->query("SELECT id, is_grant FROM warehouse_setting_permissions WHERE warehouse_id = $warehouse->id AND user_id = $session->session_id AND is_transaction IS NOT NULL")->fetch();
		if(!$data) Hell::error('404');
	} else Hell::error('404');
    
} else Hell::error('404');
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
						<h5 class="card-title">Перемещение </h5>
					</div>

					<div class="card-body">

						<div class="row">
							<div class="col-md-4" id="search_display"></div>
							<div class="col-md-8" id="application_display"></div>
						</div>

					</div>

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

		var storageActive = null;
		var applicationActive = null;

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

						Delete(`#TR_application-${applicationActive}`);
					} else {
						new Noty({
							text: res.message,
							type: "error",
						}).show();
					}
				},
			});
		}

		function Delete(element) {
			$(element).css("background-color", "rgb(244, 67, 54)");
			$(element).css("color", "white");
			$(element).fadeOut(900, function() {
				$(this).remove();
				if (document.querySelectorAll(".application_item").length == 0) credoSearch();
			});
		}

		function selectStorage(pk) {
			if (document.querySelector('#application_display')) {
                var display = document.querySelector('#application_display');
                isLoading(display);

                $.ajax({
                    type: "GET",
                    url: "<?= Hell::apiGet('WarehouseStorageApplication', null, 'listApplications') ?>",
					data: { warehouse_id_from: <?= $warehouse->id ?>, warehouse_id_in: pk },
                    success: function (result) {
                        isLoaded(display);
						storageActive = pk;
                        display.innerHTML = result;
                    },
                });

            }
		}

		function applicationDetail(pk, wareFrom, wareIn, appId, appManufacturer, appPrice) {
			$.ajax({
				type: "GET",
				url: "<?= Hell::apiGet('WarehouseStorageApplication', null, 'detailApplication') ?>",
				data: { 
					warehouse_id_from: wareFrom,
					warehouse_id_in: wareIn,
					item_name_id: appId,
					item_manufacturer_id: appManufacturer,
					item_price: appPrice,
				},
				success: function (result) {
					applicationActive = pk;
					$('#modal_default').modal('show');
					$('#form_card').html(result);
				},
			});
		}

        function credoSearch(params = '') {
            if (document.querySelector('#search_display')) {
                var display = document.querySelector('#search_display');
                isLoading(display);

                $.ajax({
                    type: "GET",
                    url: "<?= api('table/warehouse/Transaction') ?>"+params,
					data: { warehouse_id: <?= $warehouse->id ?> },
                    success: function (result) {
                        isLoaded(display);
                        display.innerHTML = result;
                    },
                });

            }
        }

        $(document).ready(() => credoSearch());

    </script>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
