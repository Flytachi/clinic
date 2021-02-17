<?php
require_once '../../tools/warframe.php';
is_auth(4);
$header = "Препараты";
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
						<h6 class="card-title">Препараты</h6>
						<div class="header-elements">
							<div class="list-icons">
								<div class="header-elements">
									<div class="list-icons">
										<a href="<?= viv("pharmacy/add_product") ?>" class="list-icons-item text-success">
											<i class="icon-plus22"></i>Добавить
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card-body">

						<div class="table-responsive">
							<table class="table table-hover table-sm"> <!-- datatable-basic -->
                                <thead>
                                    <tr class="bg-info">
                                        <th style="width:45%">Препарат</th>
                                        <th>Поставщик</th>
                                        <th>Код</th>
										<th>Категория</th>
                                        <th>Срок годности</th>
                                        <th class="text-right">Кол-во</th>
                                        <th class="text-right">Цена ед.</th>
                                        <th class="text-right" style="width:50px">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $total_qty=0;$total_price=0;foreach ($db->query("SELECT * FROM storage ORDER BY name ASC") as $row): ?>
                                        <tr>
                                            <td><?= $row['name'] ?></td>
                                            <td><?= $row['supplier'] ?></td>
                                            <td><?= $row['code'] ?></td>
                                            <td><?= $CATEGORY[$row['category']] ?></td>
                                            <td><?= date("d.m.Y", strtotime($row['die_date'])) ?></td>
                                            <td class="text-right">
                                                <?php
                                                $total_qty += $row['qty'];
                                                echo $row['qty'];
                                                ?>
                                            </td>
                                            <td class="text-right">
                                                <?php
                                                $total_price += ($row['qty'] * $row['price']);
                                                echo number_format($row['price'], 1);
                                                ?>
                                            </td>
											<td>
												<div class="list-icons">
													<a href="<?= up_url($row['id'], 'Storage') ?>" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="<?= del_url($row['id'], 'Storage') ?>" onclick="return confirm('Вы уверены что хотите удалить препарат?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
												</div>
											</td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr class="table-secondary text-right">
                                        <td colspan="5">Итого:</td>
                                        <td><?= $total_qty ?></td>
                                        <td><?= number_format($total_price, 1) ?></td>
										<td></td>
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
