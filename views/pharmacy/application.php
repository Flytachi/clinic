<?php
require_once '../../tools/warframe.php';
$session->is_auth(4);
is_module('pharmacy');
$header = "Заявки";
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

                <div class="<?= $classes['card-filter'] ?>">

					<div class="<?= $classes['card-filter_header'] ?>">
						<h5 class="card-title">Фильтр</h5>
					</div>

					<div class="card-body">

						<?php
						if( isset($_SESSION['message']) ){
							echo $_SESSION['message'];
							unset($_SESSION['message']);
						}
						?>

						<div class="table-responsive card">
							<table class="table table-hover">
								<thead>
									<tr class="bg-dark">
										<th>Информация</th>
										<th class="text-right">Кол-во заявок</th>
									</tr>
								</thead>
								<tbody>
									<?php $tb_ware = (new Table($db, "warehouse_storage_applications"))->set_data("DISTINCT warehouse_id_from, warehouse_id_in")->where("status = 2"); ?>
									<?php foreach ($tb_ware->get_table() as $row): ?>
										<tr onclick="ChangeWare(<?= $row->warehouse_id_from ?>, <?= $row->warehouse_id_in ?>)">
											<td>
												<?= $db->query("SELECT name FROM warehouses WHERE id = $row->warehouse_id_from")->fetchColumn() ?>
												<span class="text-muted"> -- Перевод --></span>
												<?= $db->query("SELECT name FROM warehouses WHERE id = $row->warehouse_id_in")->fetchColumn() ?>
											</td>
											<td class="text-right">
												<?= $db->query("SELECT * FROM warehouse_storage_applications WHERE warehouse_id_from = $row->warehouse_id_from AND warehouse_id_in = $row->warehouse_id_in AND status = 2")->rowCount(); ?>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>

					</div>

				</div>

				<div id="display_items"></div>

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

		function ChangeWare(wFrom, wIn) {
			
			$.ajax({
				type: "POST",
				url: "<?= up_url(2, "WarehouseApplication") ?>",
				data: { warehouse_id_from: wFrom, warehouse_id_in: wIn},
				success: function (result) {
					document.querySelector('#display_items').innerHTML = result;
				},
			});
		}

		function ApplicationShow(wareFrom, wareIn, appId, appManufacturer, appPrice) {
			$.ajax({
				type: "POST",
				url: "<?= up_url(3, "WarehouseApplication") ?>",
				data: { 
					warehouse_id_from: wareFrom,
					warehouse_id_in: wareIn,
					item_name_id: appId,
					item_manufacturer_id: appManufacturer,
					item_price: appPrice,
				},
				success: function (result) {
					$('#modal_default').modal('show');
					$('#form_card').html(result);
				},
			});
		}

    </script>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
