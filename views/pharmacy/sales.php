<?php
require_once '../../tools/warframe.php';
is_auth(4);
$header = "Расходы";
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

				<div class="card border-1 border-info">

					<div class="card-header text-dark header-elements-inline alpha-info">
						<h6 class="card-title">Расходы</h6>
					</div>

					<div class="card-body">

						<div class="table-responsive">
							<table class="table table-hover table-sm"> <!-- datatable-basic -->
                                <thead>
                                    <tr class="bg-info">
                                        <th>Ответственный</th>
                                        <th style="width:45%">Препарат</th>
                                        <th>Поставщик</th>
                                        <th>Код</th>
                                        <th>Дата</th>
                                        <th class="text-right">Кол-во</th>
                                        <th class="text-right">Сумма</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total_qty=0;$total_amount=0;foreach ($db->query("SELECT * FROM storage_sales ORDER BY id DESC") as $row): ?>
                                        <tr>
                                            <td><?= get_full_name($row['parent_id']) ?></td>
                                            <td><?= $row['name'] ?></td>
                                            <td><?= $row['supplier'] ?></td>
                                            <td><?= $row['code'] ?></td>
                                            <td><?= date("d.m.Y H:i", strtotime($row['add_date'])) ?></td>
                                            <td class="text-right">
                                                <?php
                                                $total_qty += -$row['qty'];
                                                echo -$row['qty'];
                                                ?>
                                            </td>
                                            <td class="text-right text-success">
												<?php $total_amount += -$row['amount']; if (-$row['amount'] > 0): ?>
													<span class="text-success"><?= number_format(-$row['amount'], 1) ?></span>
												<?php else: ?>
													<span class="text-danger"><?= number_format(-$row['amount'], 1) ?></span>
												<?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr class="table-secondary text-right ">
                                        <th colspan="5">Итого:</th>
                                        <th><?= $total_qty ?></th>
                                        <th><?= number_format($total_amount, 1) ?></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

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
