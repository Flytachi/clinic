<?php
require_once '../../tools/warframe.php';
is_auth(7);
$header = "Склад";
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
						<h5 class="card-title">Склад</h5>
						<div class="header-elements">
							<div class="list-icons">
								<a href="<?= viv('nurce/orders') ?>" class="list-icons-item text-success">
									<i class="icon-plus22 mr-1"></i>Заказы
								</a>
							</div>
						</div>
					</div>

					<div class="card-body">

						<?php
						if($_SESSION['message']){
				            echo $_SESSION['message'];
				            unset($_SESSION['message']);
				        }
						?>

						<div class="table-responsive">
                            <table class="table table-hover table-sm datatable-basic">
                                <thead>
                                    <tr class="bg-info">
										<th>№</th>
                                        <th>Препарат</th>
                                        <th>Ответственный</th>
                                        <th>Изначально</th>
                                        <th>Остаток</th>
                                        <th class="text-right">Цена</th>
                                        <th class="text-right">Сумма</th>
                                        <th class="text-right" style="width:70px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1; foreach ($db->query("SELECT * FROM storage_home WHERE status = 7") as $row): ?>
                                        <tr>
											<td><?= $i++ ?></td>
                                            <td><?= $row['name'] ?> | <?= $row['supplier'] ?> (годен до <?= date("d.m.Y", strtotime($row['die_date'])) ?>)</td>
                                            <td><?= get_full_name($row['parent_id']) ?></td>
                                            <td><?= $row['qty'] + $row['qty_sold'] ?></td>
                                            <td><?= $row['qty'] ?></td>
                                            <td class="text-right"><?= number_format($row['price'],1) ?></td>
                                            <td class="text-right"><?= number_format(($row['price'] * $row['qty']), 1) ?></td>
											<td class="text-right">
												<div class="list-icons">
													<a href="<?= del_url($row['id'], 'StorageHomeModel') ?>" onclick="return confirm(`Возврат препарата - '<?= $row['name'] ?> | <?= $row['supplier'] ?> (годен до <?= date("d.m.Y", strtotime($row['die_date'])) ?>)' ?`)" class="list-icons-item text-danger-600"><i class="icon-reply"></i></a>
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

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
