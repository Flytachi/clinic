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

						<div class="row">

							<div class="col-md-6">
								<div class="card card-body border-top-1 border-top-success">
									<div class="list-feed list-feed-rhombus list-feed-solid">
										<div class="list-feed-item">
											<strong>Общая сумма (прихода): </strong>
											<span class="text-success"><?= number_format($all_sum_cost = $db->query("SELECT SUM((qty+qty_sold)*cost) FROM storage")->fetchColumn(), 1) ?></span> =>
											<span class="text-success"><?= number_format($all_sum_price = $db->query("SELECT SUM((qty+qty_sold)*price) FROM storage")->fetchColumn(), 1) ?></span>
										</div>

										<div class="list-feed-item">
											<strong>Общая сумма (расхода): </strong>
											<span class="text-danger"><?= number_format($all_sum_price = $db->query("SELECT SUM(qty_sold*price) FROM storage")->fetchColumn(), 1) ?></span>
										</div>

										<div class="list-feed-item">
											<strong>Общая сумма (текущая): </strong>
											<span class="text-success"><?= number_format($all_sum_price = $db->query("SELECT SUM(qty*price) FROM storage")->fetchColumn(), 1) ?></span>
										</div>
									</div>
								</div>
							</div>

							<div class="col-md-6">
								<div class="card card-body border-top-1 border-top-danger">
									<div class="list-feed list-feed-rhombus list-feed-solid">
										<div class="list-feed-item">
											<strong>Общее кол-во препаратов: </strong>
											<span class="text-primary"><?= number_format($count_preparat = $db->query("SELECT SUM(qty) FROM storage")->fetchColumn()) ?></span>
										</div>

										<div class="list-feed-item">
											<strong>Малое кол-во <span onclick="Check('<?= ajax('pharmacy_table_check') ?>?type=0')" class="text-orange">(предупреждение)</span>: </strong>
											<span><?= number_format($count_limit = $db->query("SELECT COUNT(*) FROM storage WHERE qty_limit IS NOT NULL AND qty_limit >= qty AND 10 < qty")->fetchColumn()) ?></span>
										</div>

										<div class="list-feed-item">
											<strong>Критическое кол-во <span onclick="Check('<?= ajax('pharmacy_table_check') ?>?type=1')" class="text-danger">(менее 10)</span>: </strong>
											<span><?= number_format($count_danger = $db->query("SELECT COUNT(*) FROM storage WHERE 10 >= qty")->fetchColumn()) ?></span>
										</div>
									</div>
								</div>
							</div>

						</div>

						<div id="check_div"></div>

						<div class="table-responsive">
							<table class="table table-hover table-sm datatable-basic">
                                <thead>
                                    <tr class="bg-info">
                                        <th style="width:45%">Препарат</th>
                                        <th>Поставщик</th>
                                        <th>Код</th>
										<th>Категория</th>
                                        <th>Срок годности</th>
                                        <th class="text-right">Кол-во</th>
                                        <th class="text-right">Цена ед.</th>
                                        <!-- <th class="text-right" style="width:50px">Действия</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($db->query("SELECT * FROM storage ORDER BY name ASC") as $row): ?>
										<?php
										$tr="";
										if ($row['qty'] <= 10) {
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
