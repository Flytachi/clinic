<?php
require_once '../../tools/warframe.php';
is_auth(3);
$header = "Инвестиции ". addZero($_GET['pk']);
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
						<h6 class="card-title"><?= get_full_name($_GET['pk']) ?></h6>
						<div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
							</div>
						</div>
					</div>

					<div class="card-body">

						<div class="table-responsive card">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <tr class="bg-info">
                                        <th>№</th>
                                        <th>Дата платежа</th>
                                        <th>Сумма</th>
										<th>Кассир</th>
                                        <th class="text-center" style="width:210px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
									foreach($db->query("SELECT * FROM investment WHERE user_id = {$_GET['pk']} ORDER BY add_date DESC") as $row) {
                                        ?>
                                        <tr>
                                            <td><?= $i++ ?></td>
                                            <td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
                                            <td><?= $row['price'] ?></td>
											<td><?= get_full_name($row['pricer_id']) ?></td>
                                            <td class="text-center">
												<a href="#" type="button" class="btn btn-outline-info btn-sm legitRipple">PDF</button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
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
