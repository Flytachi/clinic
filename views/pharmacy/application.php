<?php
require_once '../../tools/warframe.php';
$session->is_auth(24);
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
										<th>Склад</th>
										<th>Ответственный</th>
										<th>Отдел</th>
										<th class="text-right">Кол-во заявок</th>
									</tr>
								</thead>
								<tbody>
									<?php $tb_ware = (new WarehouseApplicationModel)->tb('wa')->set_data("DISTINCT w.id, w.name, w.responsible_id, w.division")->additions("LEFT JOIN warehouses w ON (w.id=wa.warehouse_id)")->where("wa.branch_id = $session->branch AND wa.status = 2"); ?>
									<?php foreach ($tb_ware->get_table() as $row): ?>
										<tr onclick="ChangeWare(<?= $row->id ?>)">
											<td><?= $row->name ?></td>
											<td><?= get_full_name($row->responsible_id) ?></td>
											<td>
												<?php if ( isset($row->division) ): ?>
                                                    <?php foreach (json_decode($row->division) as $key): ?>
                                                        <li><?= $db->query("SELECT title FROM divisions WHERE id = $key")->fetchColumn() ?></li>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <span class="text-muted">Нет данных</span>
                                                <?php endif; ?>
											</td>
											<td class="text-right">
												<?= $db->query("SELECT * FROM warehouse_applications WHERE branch_id = $session->branch AND warehouse_id = $row->id AND status = 2")->rowCount(); ?>
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

		function ChangeWare(params) {
			$.ajax({
				type: "GET",
				url: "<?= up_url(null, "WarehouseApplicationPanel") ?>",
				data: { id: params },
				success: function (result) {
					document.querySelector('#display_items').innerHTML = result;
				},
			});
		}

		function ApplicationShow(Ware, appId, appManufacturerId = null) {
			$.ajax({
				type: "GET",
				url: "<?= up_url(null, "WarehouseApplicationPanel", "application") ?>",
				data: { 
					id: Ware,
					item_name_id: appId,
					item_manufacturer_id: appManufacturerId
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
