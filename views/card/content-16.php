<?php
require_once 'callback.php';
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

				<?php include "profile.php"; ?>

                <div class="<?= $classes['card'] ?>">
				    <div class="<?= $classes['card-header'] ?>">
				        <h6 class="card-title">Просмотр визита</h6>
				    </div>

					<div class="card-body">

					   	<?php include "content_tabs.php"; ?>

						<legend class="font-weight-semibold text-uppercase font-size-sm">
							<i class="icon-calculator3 mr-2"></i>Расходы
                            <a onclick="Print('<?= prints('document-4') ?>?pk=<?= $patient->visit_id ?>')" type="button" class="float-right mr-1"><i class="icon-printer2"></i></a>
						</legend>

						<!-- Investments -->
						<legend class="font-weight-semibold text-uppercase font-size-sm text-center">Инвестиции</legend>

					   	<div class="card">

						   	<div class="table-responsive">
							   	<table class="table table-hover table-sm table-bordered">
									<thead class="<?= $classes['table-thead'] ?>">
 									  	<tr>
 										  	<th style="width: 40px !important;">№</th>
                                            <th>Кассир</th>
											<th class="text-right">Наличные</th>
											<th class="text-right">Пластик</th>
											<th class="text-right">Перечисление</th>
                                          	<th class="text-right" style="width: 200px;">Сумма</th>
 									  	</tr>
 								  	</thead>
 								  	<tbody>
									   	<?php  $total_inv=[]; $invest = (new Table($db, "visit_investments"))->where("visit_id = $patient->visit_id")->order_by('add_date ASC'); ?>
										<?php foreach ($invest->get_table(1) as $row): ?>
											<tr>
												<td><?= $row->count ?></td>
												<td><?= get_full_name($row->pricer_id) ?></td>
												<td class="text-right text-<?= number_color($row->balance_cash) ?>">
													<?php
													(isset($total_inv['balance_cash'])) ? $total_inv['balance_cash'] += $row->balance_cash : $total_inv['balance_cash'] = $row->balance_cash;
													echo number_format($row->balance_cash);
													?>
												</td>
												<td class="text-right text-<?= number_color($row->balance_card) ?>">
													<?php
													(isset($total_inv['balance_card'])) ? $total_inv['balance_card'] += $row->balance_card : $total_inv['balance_card'] = $row->balance_card;
													echo number_format($row->balance_card);
													?>
												</td>
												<td class="text-right text-<?= number_color($row->balance_transfer) ?>">
													<?php
													(isset($total_inv['balance_transfer'])) ? $total_inv['balance_transfer'] += $row->balance_transfer : $total_inv['balance_transfer'] = $row->balance_transfer;
													echo number_format($row->balance_transfer);
													?>
												</td>
												<td class="text-right text-<?= number_color($row->balance_cash + $row->balance_card + $row->balance_transfer) ?>">
													<?= number_format($row->balance_cash + $row->balance_card + $row->balance_transfer); ?>
												</td>
											</tr>
										<?php endforeach; ?>
 								  	</tbody>
									<tfooter>
										<?php if(isset($row->count)): ?>
											<tr class="table-secondary text-right">
												<th colspan="2">Итог:</th>
												<th><?= number_format($total_inv['balance_cash']) ?></th>
												<th><?= number_format($total_inv['balance_card']) ?></th>
												<th><?= number_format($total_inv['balance_transfer']) ?></th>
												<th class="<?php if($vps['balance'] == $total_inv['balance_cash'] + $total_inv['balance_card'] + $total_inv['balance_transfer']) echo 'text-primary'; ?>"><?= number_format($total_inv['balance_cash'] + $total_inv['balance_card'] + $total_inv['balance_transfer']) ?></th>
											</tr>
										<?php else: ?>
											<tr class="table-secondary text-center">
												<th colspan="6">Нет данных</th>
											</tr>
										<?php endif; ?>
									</tfooter>
 							  	</table>
					  		</div>

					   	</div>
						<!-- /Investments -->

						<!-- Price -->
						<legend class="font-weight-semibold text-uppercase font-size-sm text-center">Услуги/Препараты</legend>

					   	<div class="card">

						   	<div class="table-responsive">
							   	<table class="table table-hover table-sm table-bordered">
									<thead class="<?= $classes['table-thead'] ?>">
 									  	<tr>
 										  	<th style="width: 40px !important;">№</th>
                                            <th>Наименование</th>
 										  	<th class="text-center" style="width: 100px;">Кол-во</th>
											<th class="text-right" style="width: 200px;">Цена</th>
                                          	<th class="text-right" style="width: 200px;">Сумма</th>
 									  	</tr>
 								  	</thead>
									   
 								  	<tbody>
									   	<?php  
										$price = new Table($db, "visit_prices");
										$price->set_data("DISTINCT item_id, item_name, item_cost")->where("visit_id = $patient->visit_id AND item_type IN (1,3)")->order_by("item_name ASC");
										$total_ser = 0; 
										?>
										<?php foreach ($price->get_table(1) as $row): ?>
											<tr>
												<td><?= $row->count ?></td>
												<td><?= $row->item_name ?></td>
												<td class="text-center"><?php $row->qty = $db->query("SELECT * FROM visit_prices WHERE visit_id = $patient->visit_id AND item_id = $row->item_id AND item_cost = $row->item_cost")->rowCount(); echo $row->qty; ?></td>
                            					<td class="text-right text-<?= number_color($row->item_cost) ?>">
													<?= number_format($row->item_cost); ?>
												</td>
												<td class="text-right text-<?= number_color($row->qty * $row->item_cost, true) ?>">
													<?php $total_ser += $row->qty * $row->item_cost; echo number_format($row->qty * $row->item_cost); ?>
												</td>
											</tr>
										<?php endforeach; ?>
 								  	</tbody>
									<tfooter>
										<?php if(isset($row->count)): ?>
											<tr class="table-secondary">
												<th colspan="4" class="text-right">Итог:</th>
												<th class="text-right <?php if($vps['cost-services'] == -$total_ser) echo 'text-primary'; ?>"><?= number_format($total_ser) ?></th>
											</tr>
										<?php else: ?>
											<tr class="table-secondary text-center">
												<th colspan="6">Нет данных</th>
											</tr>
										<?php endif; ?>
									</tfooter>
 							  	</table>
					  		</div>

					   	</div>
						<!-- /Price -->

						<!-- Total -->
						<legend class="font-weight-semibold text-uppercase font-size-sm text-center">Итог</legend>

					   	<div class="card">

						   	<div class="table-responsive">
							   	<table class="table table-hover table-sm table-bordered">
									<thead class="<?= $classes['table-thead'] ?>">
 									  	<tr>
											<th class="text-left">Информация</th>
                        					<th class="text-right">Сумма</th>
 									  	</tr>
 								  	</thead>
									   
 								  	<tbody>
									   	<?php  
										$bed = new Table($db, "visit_beds");
										$bed->set_data("location, type, cost, ROUND(DATE_FORMAT(TIMEDIFF(IFNULL(end_date, CURRENT_TIMESTAMP()), start_date), '%H')) 'time'")->where("visit_id = $patient->visit_id")->order_by("start_date ASC");
										$sale_info = (new Table($db, "visit_sales"))->where("visit_id = $patient->visit_id")->get_row();
										$total_bed = 0;
										?>
										<tr>
											<td>
												<strong style="font-size: 15px;">Прибывание:</strong><br>
												<ul class="list-unstyled">
													<?php foreach($bed->get_table() as $row): ?>
														<li>
															<span class="text-success"><?php $total_bed += $row->time * ($row->cost / 24); echo number_format( $row->time * ($row->cost / 24) ) ?> -</span>
															<?= $row->location ?> 
															<span class="text-primary">(<?= $row->type ?>)</span> 
															------> <?= number_format($row->cost) ?>/День 
															<span class="text-primary">(<?= minToStr($row->time) ?>)</span>
														</li>
													<?php endforeach; ?>
												</ul>
											</td>
											<td class="text-right text-<?= number_color($total_bed, true) ?>"><?= number_format($total_bed) ?></td>
										</tr>
										<tr>
											<td><strong style="font-size: 15px;">Услуги/Препараты</strong></td>
											<td class="text-right text-<?= number_color($total_ser, true) ?>"><?= number_format($total_ser) ?></td>
										</tr>
										<?php if($sale_info): ?>
											<tr>
												<td>
													<strong style="font-size: 15px;">Скидки:</strong><br>
													<ul class="list-unstyled">
														<li>
															Койка - <?= number_format($sale_info->sale_bed_unit) ?> <span class="text-muted">(<?= $sale_info->sale_bed ?>%)</span><br>
															Услуги - <?= number_format($sale_info->sale_service_unit) ?> <span class="text-muted">(<?= $sale_info->sale_service ?>%)</span>
														</li>
													</ul>
												</td>
												<td class="text-right"><?= number_format($sale_info->sale_bed_unit + $sale_info->sale_service_unit) ?></td>
											</tr>
										<?php endif; ?>
										<tr>
											<td><strong style="font-size: 15px;">Инвестиции</strong></td>
											<td class="text-right text-success"><?= number_format($vps['balance']) ?></td>
										</tr>

										<?php if($patient->completed): ?>
											<?php
											if ($vps['sale-total'] > 0) {
												$formul = "<strong>Формула</strong><br> ".number_format($vps['balance'])." + ".number_format($vps['sale-total'])." = ".number_format(-$vps['cost-beds'])." + ".number_format(-$vps['cost-services']);
											}else {
												$formul = "<strong>Формула</strong><br> ".number_format($vps['balance'])." = ".number_format(-$vps['cost-beds'])." + ".number_format(-$vps['cost-services']);
											}
											?>
											<tr class="table-secondary text-center text-<?= ($vps['result'] == 0) ? 'success' : 'danger'; ?>" data-popup="tooltip" title="" data-html="true" data-original-title="<?= $formul ?>">
												<td colspan="2"><strong style="font-size: 15px;">Расчитанно</strong></td>
											</tr>
										<?php endif; ?>
										
 								  	</tbody>
 							  	</table>
					  		</div>

					   	</div>
						<!-- /Total -->


				   	</div>

				    <!-- /content wrapper -->
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
