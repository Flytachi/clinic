<?php
require_once '../../../tools/warframe.php';
$session->is_auth();
$header = "Доход";
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

				<?php include "content_tabs.php"; ?>

                <div class="<?= $classes['card'] ?>">

                    <div class="<?= $classes['card-header'] ?>">
                        <h6 class="card-title" >Фильтр</h6>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

						<form action="" method="post">

							<div class="form-group row">

								<div class="col-md-3">
									<label>Промежуток времени:</label>
									<div class="input-group">
										<input type="text" class="<?= $classes['form-daterange'] ?>" name="date" value="<?= ( isset($_POST['date']) ) ? $_POST['date'] : '' ?>">
										<span class="input-group-append">
											<span class="input-group-text"><i class="icon-calendar22"></i></span>
										</span>
									</div>
								</div>

							</div>

							<div class="text-right">
								<button type="submit" class="btn btn-outline-info"><i class="icon-search4 mr-2"></i>Поиск</button>
							</div>


						</form>

                    </div>

                </div>

				<?php if ($_POST): ?>
					<?php
					$_POST['date_start'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[0]));
					$_POST['date_end'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[1]));
					?>
					<div class="<?= $classes['card'] ?>">

						<div class="<?= $classes['card-header'] ?>">
							<h6 class="card-title">Доход</h6>
							<div class="header-elements">
								<div class="list-icons">
									<button onclick="ExportExcel('table', 'Document','document.xls')" type="button" class="btn btn-outline-info btn-sm legitRipple">Excel</button>
								</div>
							</div>
						</div>

						<div class="card-body">

							<div class="table-responsive">
	                            <table class="table table-hover table-sm table-bordered" id="table">
	                                <thead>
	                                    <tr class="<?= $classes['table-thead'] ?>">
											<th class="text-center">Тип</th>
											<th class="text-right">Наличные</th>
											<th class="text-right">Пластик</th>
											<th class="text-right">Перечисление</th>
											<th class="text-right">Сумма</th>
	                                    </tr>
	                                </thead>
	                                <tbody class="text-right">

										<tr class="table-primary">
											<td class="text-center">Инвестиции (не израсходованы)</td>
											<?php
												$income_invest_up_sum = $db->query("SELECT SUM(balance_cash) 'price_cash', SUM(balance_card) 'price_card', SUM(balance_transfer) 'price_transfer' FROM investment WHERE status IS NOT NULL AND (DATE_FORMAT(add_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")")->fetch();
												$income_invest_up_sum_cash = $income_invest_up_sum['price_cash'];
												$income_invest_up_sum_card = $income_invest_up_sum['price_card'];
												$income_invest_up_sum_transfer = $income_invest_up_sum['price_transfer'];
												$income_invest_up_sum_all = $income_invest_up_sum_cash + $income_invest_up_sum_card + $income_invest_up_sum_transfer;
											?>
											<td class="text-<?= ($income_invest_up_sum_cash > 0) ? "success" : "danger" ?>"><?= number_format($income_invest_up_sum_cash, 1) ?></td>
											<td class="text-<?= ($income_invest_up_sum_card > 0) ? "success" : "danger" ?>"><?= number_format($income_invest_up_sum_card, 1) ?></td>
											<td class="text-<?= ($income_invest_up_sum_transfer > 0) ? "success" : "danger" ?>"><?= number_format($income_invest_up_sum_transfer, 1) ?></td>
											<td class="text-<?= ($income_invest_up_sum_all > 0) ? "success" : "danger" ?>"><?= number_format($income_invest_up_sum_all, 1) ?></td>
										</tr>
										<tr class="table-danger">
											<td class="text-center">Инвестиции (израсходованы)</td>
											<?php
												$income_invest_down_sum = $db->query("SELECT SUM(balance_cash) 'price_cash', SUM(balance_card) 'price_card', SUM(balance_transfer) 'price_transfer' FROM investment WHERE status IS NULL AND(DATE_FORMAT(add_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")")->fetch();
												$income_invest_down_sum_cash = $income_invest_down_sum['price_cash'];
												$income_invest_down_sum_card = $income_invest_down_sum['price_card'];
												$income_invest_down_sum_transfer = $income_invest_down_sum['price_transfer'];
												$income_invest_down_sum_all = $income_invest_down_sum_cash + $income_invest_down_sum_card + $income_invest_down_sum_transfer;
											?>
											<td><?= number_format($income_invest_down_sum_cash, 1) ?></td>
											<td><?= number_format($income_invest_down_sum_card, 1) ?></td>
											<td><?= number_format($income_invest_down_sum_transfer, 1) ?></td>
											<td><?= number_format($income_invest_down_sum_all, 1) ?></td>
										</tr>
										<tr>
											<td class="text-center">Доход с услуг</td>
											<?php
												$income_service_sum = $db->query("SELECT SUM(price_cash) 'price_cash', SUM(price_card) 'price_card', SUM(price_transfer) 'price_transfer' FROM visit_price WHERE item_type IN (1) AND price_date IS NOT NULL AND (DATE_FORMAT(price_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")")->fetch();
												$income_service_sum_cash = $income_service_sum['price_cash'];
												$income_service_sum_card = $income_service_sum['price_card'];
												$income_service_sum_transfer = $income_service_sum['price_transfer'];
												$income_service_sum_all = $income_service_sum_cash + $income_service_sum_card + $income_service_sum_transfer;
											?>
											<td class="text-<?= ($income_service_sum_cash > 0) ? "success" : "danger" ?>"><?= number_format($income_service_sum_cash, 1) ?></td>
											<td class="text-<?= ($income_service_sum_card > 0) ? "success" : "danger" ?>"><?= number_format($income_service_sum_card, 1) ?></td>
											<td class="text-<?= ($income_service_sum_transfer > 0) ? "success" : "danger" ?>"><?= number_format($income_service_sum_transfer, 1) ?></td>
											<td class="text-<?= ($income_service_sum_all > 0) ? "success" : "danger" ?>"><?= number_format($income_service_sum_all, 1) ?></td>
										</tr>
										<tr>
											<td class="text-center">Доход с коек</td>
											<?php
												$income_bed_sum = $db->query("SELECT SUM(price_cash) 'price_cash', SUM(price_card) 'price_card', SUM(price_transfer) 'price_transfer' FROM visit_price WHERE item_type IN (101) AND price_date IS NOT NULL AND (DATE_FORMAT(price_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")")->fetch();
												$income_bed_sum_cash = $income_bed_sum['price_cash'];
												$income_bed_sum_card = $income_bed_sum['price_card'];
												$income_bed_sum_transfer = $income_bed_sum['price_transfer'];
												$income_bed_sum_all = $income_bed_sum_cash + $income_bed_sum_card + $income_bed_sum_transfer;
											?>
											<td class="text-<?= ($income_bed_sum_cash > 0) ? "success" : "danger" ?>"><?= number_format($income_bed_sum_cash, 1) ?></td>
											<td class="text-<?= ($income_bed_sum_card > 0) ? "success" : "danger" ?>"><?= number_format($income_bed_sum_card, 1) ?></td>
											<td class="text-<?= ($income_bed_sum_transfer > 0) ? "success" : "danger" ?>"><?= number_format($income_bed_sum_transfer, 1) ?></td>
											<td class="text-<?= ($income_bed_sum_all > 0) ? "success" : "danger" ?>"><?= number_format($income_bed_sum_all, 1) ?></td>
										</tr>
										<tr>
											<td class="text-center">Доход с препаратов/рассходников</td>
											<?php
												$income_resource_sum = $db->query("SELECT SUM(price_cash) 'price_cash', SUM(price_card) 'price_card', SUM(price_transfer) 'price_transfer' FROM visit_price WHERE item_type IN (2,3,4) AND price_date IS NOT NULL AND (DATE_FORMAT(price_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")")->fetch();
												$income_resource_sum_cash = $income_resource_sum['price_cash'];
												$income_resource_sum_card = $income_resource_sum['price_card'];
												$income_resource_sum_transfer = $income_resource_sum['price_transfer'];
												$income_resource_sum_all = $income_resource_sum_cash + $income_resource_sum_card + $income_resource_sum_transfer;
											?>
											<td class="text-<?= ($income_resource_sum_cash > 0) ? "success" : "danger" ?>"><?= number_format($income_resource_sum_cash, 1) ?></td>
											<td class="text-<?= ($income_resource_sum_card > 0) ? "success" : "danger" ?>"><?= number_format($income_resource_sum_card, 1) ?></td>
											<td class="text-<?= ($income_resource_sum_transfer > 0) ? "success" : "danger" ?>"><?= number_format($income_resource_sum_transfer, 1) ?></td>
											<td class="text-<?= ($income_resource_sum_all > 0) ? "success" : "danger" ?>"><?= number_format($income_resource_sum_all, 1) ?></td>
										</tr>
										<tr>
											<td class="text-center">Доход с операций</td>
											<?php
												$income_operation_sum = $db->query("SELECT SUM(price_cash) 'price_cash', SUM(price_card) 'price_card', SUM(price_transfer) 'price_transfer' FROM visit_price WHERE item_type IN (5) AND price_date IS NOT NULL AND (DATE_FORMAT(price_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")")->fetch();
												$income_operation_sum_cash = $income_operation_sum['price_cash'];
												$income_operation_sum_card = $income_operation_sum['price_card'];
												$income_operation_sum_transfer = $income_operation_sum['price_transfer'];
												$income_operation_sum_all = $income_operation_sum_cash + $income_operation_sum_card + $income_operation_sum_transfer;
											?>
											<td class="text-<?= ($income_operation_sum_cash > 0) ? "success" : "danger" ?>"><?= number_format($income_operation_sum_cash, 1) ?></td>
											<td class="text-<?= ($income_operation_sum_card > 0) ? "success" : "danger" ?>"><?= number_format($income_operation_sum_card, 1) ?></td>
											<td class="text-<?= ($income_operation_sum_transfer > 0) ? "success" : "danger" ?>"><?= number_format($income_operation_sum_transfer, 1) ?></td>
											<td class="text-<?= ($income_operation_sum_all > 0) ? "success" : "danger" ?>"><?= number_format($income_operation_sum_all, 1) ?></td>
										</tr>
										<tr>
											<td class="text-center">Доход с аптеки (внешние)</td>
											<?php
												$income_pharm_sum = $db->query("SELECT SUM(amount_cash) 'price_cash', SUM(amount_card) 'price_card', SUM(amount_transfer) 'price_transfer' FROM storage_sales WHERE operation_id IS NULL AND parent_id IS NULL AND (DATE_FORMAT(add_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")")->fetch();
												$income_pharm_sum_cash = $income_pharm_sum['price_cash'];
												$income_pharm_sum_card = $income_pharm_sum['price_card'];
												$income_pharm_sum_transfer = $income_pharm_sum['price_transfer'];
												$income_pharm_sum_all = $income_pharm_sum_cash + $income_pharm_sum_card + $income_pharm_sum_transfer;
											?>
											<td class="text-<?= ($income_pharm_sum_cash > 0) ? "success" : "danger" ?>"><?= number_format($income_pharm_sum_cash, 1) ?></td>
											<td class="text-<?= ($income_pharm_sum_card > 0) ? "success" : "danger" ?>"><?= number_format($income_pharm_sum_card, 1) ?></td>
											<td class="text-<?= ($income_pharm_sum_transfer > 0) ? "success" : "danger" ?>"><?= number_format($income_pharm_sum_transfer, 1) ?></td>
											<td class="text-<?= ($income_pharm_sum_all > 0) ? "success" : "danger" ?>"><?= number_format($income_pharm_sum_all, 1) ?></td>
										</tr>
										<tr class="table-secondary">
											<th class="text-center">Общий доход</th>
											<?php
												$income_all_sum = $db->query("SELECT SUM(price_cash) 'price_cash', SUM(price_card) 'price_card', SUM(price_transfer) 'price_transfer' FROM visit_price WHERE price_date IS NOT NULL AND (DATE_FORMAT(price_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")")->fetch();
												$income_all_sum_cash = $income_all_sum['price_cash'] + $income_pharm_sum_cash + $income_invest_up_sum_cash;
												$income_all_sum_card = $income_all_sum['price_card'] + $income_pharm_sum_card + $income_invest_up_sum_card;
												$income_all_sum_transfer = $income_all_sum['price_transfer'] + $income_pharm_sum_transfer + $income_invest_up_sum_transfer;
												$income_all_sum_all = $income_all_sum_cash + $income_all_sum_card + $income_all_sum_transfer;
											?>
											<td class="text-<?= ($income_all_sum_cash > 0) ? "success" : "danger" ?>"><?= number_format($income_all_sum_cash, 1) ?></td>
											<td class="text-<?= ($income_all_sum_card > 0) ? "success" : "danger" ?>"><?= number_format($income_all_sum_card, 1) ?></td>
											<td class="text-<?= ($income_all_sum_transfer > 0) ? "success" : "danger" ?>"><?= number_format($income_all_sum_transfer, 1) ?></td>
											<td class="text-<?= ($income_all_sum_all > 0) ? "success" : "danger" ?>"><?= number_format($income_all_sum_all, 1) ?></td>
										</tr>

	                                </tbody>
	                            </table>
	                        </div>

						</div>

					</div>

				<?php endif; ?>

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
