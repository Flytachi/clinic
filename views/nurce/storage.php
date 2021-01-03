<?php
require_once '../../tools/warframe.php';
is_auth(7);
$header = "Рабочий стол";
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
								<a class="list-icons-item text-dark" data-toggle="modal" data-target="#modal_add">
									<i class="icon-plus22"></i>Добавить
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
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr class="bg-info">
                                        <th>Препарат</th>
                                        <th>Ответственный</th>
                                        <th>Изначально</th>
                                        <th>Остаток</th>
                                        <th>Цена</th>
                                        <th>Сумма</th>
                                        <!-- <th class="text-center" style="width:210px">Действия</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($db->query("SELECT st.* FROM storage_preparat st LEFT JOIN users us ON(us.id=st.parent_id) WHERE us.user_level = 7") as $row): ?>
                                        <tr>
                                            <td><?= $row['preparat_code'] ?></td>
                                            <td><?= get_full_name($row['parent_id']) ?></td>
                                            <td><?= $row['first_qty'] ?></td>
                                            <td><?= $row['qty'] ?></td>
                                            <td><?= $row['price'] ?></td>
                                            <td><?= $row['amount'] ?></td>
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

	<div id="modal_add" class="modal fade" tabindex="-1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header bg-info">
					<h6 class="modal-title">Заказ</h6>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<?php StorageOrdersModel::form() ?>

			</div>
		</div>
	</div>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
