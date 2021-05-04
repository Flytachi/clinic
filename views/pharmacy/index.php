<?php
require_once '../../tools/warframe.php';
$session->is_auth(4);
is_module('module_pharmacy');
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
										<a href="<?= viv("pharmacy/storage") ?>" class="list-icons-item text-success">
											<i class="icon-plus22"></i>Склад
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card-body">

						<div class="row">
							<?php
							$all_sum_cost = $db->query("SELECT SUM((qty+qty_sold)*cost) FROM storage")->fetchColumn();
							$all_sum_price = $db->query("SELECT SUM((qty+qty_sold)*price) FROM storage")->fetchColumn();
							$all_sum_price_sold = $db->query("SELECT SUM(qty_sold*price) FROM storage")->fetchColumn();
							$all_sum_price_current = $db->query("SELECT SUM(qty*price) FROM storage")->fetchColumn();

							$count_preparat = $db->query("SELECT SUM(qty) FROM storage")->fetchColumn();
							$count_limit = $db->query("SELECT COUNT(*) FROM storage WHERE qty_limit IS NOT NULL AND qty_limit >= qty AND 10 < qty")->fetchColumn();
							$count_danger = $db->query("SELECT COUNT(*) FROM storage WHERE 10 >= qty")->fetchColumn();
							$count_date = $db->query("SELECT COUNT(*) FROM storage WHERE DATEDIFF(die_date, CURRENT_DATE()) <= 10")->fetchColumn();
							?>

							<?php if ($all_sum_cost != 0): ?>
								<div class="col-md-6">
									<div class="card card-body border-top-1 border-top-success">
										<div class="list-feed list-feed-rhombus list-feed-solid">
											<div class="list-feed-item">
												<strong>Общая сумма (прихода): </strong>
												<span class="text-success"><?= number_format($all_sum_cost, 1) ?></span> =>
												<span class="text-success"><?= number_format($all_sum_price, 1) ?></span>
											</div>

											<div class="list-feed-item">
												<strong>Общая сумма (расхода): </strong>
												<span class="text-danger"><?= number_format($all_sum_price_sold, 1) ?></span>
											</div>

											<div class="list-feed-item">
												<strong>Общая сумма (текущая): </strong>
												<span class="text-success"><?= number_format($all_sum_price_current, 1) ?></span>
											</div>
										</div>
									</div>
								</div>
							<?php endif; ?>

							<?php if ($count_preparat != 0): ?>
								<div class="col-md-6">
									<div class="card card-body border-top-1 border-top-danger">
										<div class="list-feed list-feed-rhombus list-feed-solid">
											<?php if ($count_preparat != 0): ?>
												<div class="list-feed-item">
													<strong>Общее кол-во препаратов: </strong>
													<span class="text-primary"><?= number_format($count_preparat) ?></span>
												</div>
											<?php endif; ?>

											<?php if ($count_limit != 0): ?>
												<div class="list-feed-item">
													<strong>Малое кол-во <span onclick="Check('<?= ajax('pharmacy_table_check') ?>?type=0')" class="text-orange">(предупреждение)</span>: </strong>
													<span><?= number_format($count_limit) ?></span>
												</div>
											<?php endif; ?>

											<?php if ($count_danger != 0): ?>
												<div class="list-feed-item">
													<strong>Критическое кол-во <span onclick="Check('<?= ajax('pharmacy_table_check') ?>?type=1')" class="text-danger">(менее 10)</span>: </strong>
													<span><?= number_format($count_danger) ?></span>
												</div>
											<?php endif; ?>

											<?php if ($count_date != 0): ?>
												<div class="list-feed-item">
													<strong>Истёк срок годности <span onclick="Check('<?= ajax('pharmacy_table_check') ?>?type=2')" class="text-teal">(менее 10 дней)</span>: </strong>
													<span><?= number_format($count_date) ?></span>
												</div>
											<?php endif; ?>
										</div>
									</div>
								</div>
							<?php endif; ?>

						</div>

						<div id="check_div"></div>

						<div class="table-responsive">
							<table class="table table-hover table-sm datatable-basic">
                                <thead>
                                    <tr class="bg-info">
                                        <th style="width:35%">Препарат</th>
                                        <th>Поставщик</th>
                                        <th>Код</th>
										<th>Категория</th>
                                        <th>Срок годности</th>
										<th class="text-right">Бронь</th>
                                        <th class="text-right">Кол-во</th>
                                        <th class="text-right">Цена ед.</th>
                                        <!-- <th class="text-right" style="width:50px">Действия</th> -->
                                    </tr>
                                </thead>
                                <tbody>
									<?php
									$sql = "SELECT st.*,
									 		(
												IFNULL((SELECT SUM(opp.item_qty) FROM operation op LEFT JOIN operation_preparat opp ON(opp.operation_id=op.id) WHERE op.completed IS NULL AND opp.item_id=st.id), 0) +
												IFNULL((SELECT SUM(sto.qty) FROM storage_orders sto WHERE sto.preparat_id=st.id), 0)

											) 'reservation'
											FROM storage st ORDER BY st.name ASC";
								 	?>
                                    <?php foreach ($db->query($sql) as $row): ?>
										<?php
										$tr="";
										if ($dr= date_diff(new \DateTime(), new \DateTime($row['die_date']))->days <= 10) {
											// Предупреждение срока годности
											$tr = "bg-teal text-dark";
										}elseif ($row['qty'] <= 10) {
											// Предупреждение критическое
											$tr = "bg-danger";
										}elseif ($row['qty_limit'] and $row['qty'] <= $row['qty_limit']){
											// Предупреждение
											$tr = "bg-orange text-dark";
										}
										?>
										<tr class="<?= $tr ?>">
                                            <td><?= $row['name'] ?></td>
                                            <td><?= $row['supplier'] ?></td>
                                            <td><?= $row['code'] ?></td>
                                            <td><?= $CATEGORY[$row['category']] ?></td>
                                            <td><?= date("d.m.Y", strtotime($row['die_date'])) ?></td>
                                            <td class="text-right"><?= $row['reservation'] ?></td>
											<td class="text-right"><?= $row['qty'] ?></td>
                                            <td class="text-right"><?= number_format($row['price'], 1) ?></td>
											<!--
											<td>
												<div class="list-icons">
													<a href="<?= up_url($row['id'], 'Storage') ?>" class="list-icons-item text-primary-600"><i class="icon-pencil7"></i></a>
													<a href="<?= del_url($row['id'], 'Storage') ?>" onclick="return confirm('Вы уверены что хотите удалить препарат?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
												</div>
											</td>
											-->
                                        </tr>
                                    <?php endforeach; ?>
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

	<script type="text/javascript">
        function Check(events) {
            $.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#check_div').html(result);
					setTimeout(function () {
						$('#check_card').fadeOut(900, function() {
                            $(this).remove();
                        });
		            }, 5000)
				},
			});
        }
    </script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
