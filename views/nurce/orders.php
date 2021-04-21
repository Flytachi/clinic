<?php
require_once '../../tools/warframe.php';
$session->is_auth(7);
$header = "Заказы";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>
<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/form_inputs.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_layouts.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_select2.js") ?>"></script>

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

                <div class="card border-1 border-info">

					<div class="card-header text-dark header-elements-inline alpha-info">
						<h5 class="card-title">Заказы</h5>
					</div>

					<div class="card-body">

                        <div id="form_card">
                            <?php StorageOrdersModel::form() ?>
                        </div>

						<div class="table-responsive card">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr class="bg-info">
                                        <th>Препарат</th>
										<th>Дата заказа</th>
                                        <th>Кол-во</th>
                                        <th class="text-right" style="width:70px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($db->query("SELECT so.id, st.name, st.supplier, st.die_date, so.qty, so.date FROM storage_orders so LEFT JOIN storage st ON(st.id=so.preparat_id) WHERE so.parent_id = {$_SESSION['session_id']}") as $row): ?>
                                        <tr>
                                            <td><?= $row['name'] ?> | <?= $row['supplier'] ?> (годен до <?= date("d.m.Y", strtotime($row['die_date'])) ?>)</td>
											<td><?= date("d.m.Y", strtotime($row['date'])) ?></td>
                                            <td><?= $row['qty'] ?></td>
											<td class="text-right">
												<div class="list-icons">
                                                    <a onclick="Update('<?= up_url($row['id'], 'StorageOrdersModel') ?>')" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
                                                    <a href="<?= del_url($row['id'], 'StorageOrdersModel') ?>" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
												</div>
											</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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
		function Update(events) {
			events
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
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
