<?php
require_once '../../tools/warframe.php';
is_auth(7);
$header = "Рабочий стол";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>

<body>
	<!-- Main navbar -->
	<?php include '../layout/navbar.php' ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">
		<!-- Main sidebar -->
		<?php include '../layout/sidebar.php' ?>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

                <div class="card border-1 border-info">

					<div class="card-header text-dark header-elements-inline alpha-info">
						<h6 class="card-title">Склад</h6>
						<div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
							</div>
						</div>
					</div>

					<div class="card-body">

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
                                    <?php foreach ($db->query("SELECT * FROM storage_preparat WHERE division_id IS NULL") as $row): ?>
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


	<!-- Footer -->
    <?php include '../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
