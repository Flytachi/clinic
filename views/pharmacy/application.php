<?php
require_once '../../tools/warframe.php';
$session->is_auth(4);
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

						<div class="row">

							<div class="col-5">
								<div class="table-responsive card">
									<table class="table table-hover">
										<thead>
											<tr class="bg-dark">
												<th>Склад</th>
												<th>Ответственный</th>
												<th class="text-right">Кол-во заявок</th>
											</tr>
										</thead>
										<tbody>
											<?php $tb_ware = (new Table($db, "warehouse_applications wa"))->set_data("DISTINCT w.id, w.name, w.parent_id")->additions("LEFT JOIN warehouses w ON (w.id=wa.warehouse_id)")->where("wa.status = 2"); ?>
											<?php foreach ($tb_ware->get_table() as $row): ?>
												<tr onclick="ChangeWare(<?= $row->id ?>)">
													<td><?= $row->name ?></td>
													<td><?= get_full_name($row->parent_id) ?></td>
													<td class="text-right">
														<?= $db->query("SELECT * FROM warehouse_applications WHERE warehouse_id = $row->id AND status = 2")->rowCount(); ?>
													</td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							</div>

							<div class="col-7" id="display_parents"></div>
							
						</div>

					</div>

				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

    <script type="text/javascript">

		function ChangeWare(params) {
			$.ajax({
				type: "GET",
				url: "<?= ajax('pharmacy/application-change_ware.php') ?>",
				data: { pk: params },
				success: function (result) {
					document.querySelector('#display_parents').innerHTML = result;
				},
			});
		}

		function ChangeWareType(params) {
			$.ajax({
				type: "GET",
				url: "<?= ajax('pharmacy/application-change_ware_type.php') ?>",
				data: { pk: params },
				success: function (result) {
					document.querySelector('#display_parents').innerHTML = result;
				},
			});
		}

    </script>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
