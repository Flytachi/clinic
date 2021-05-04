<?php
require_once '../../tools/warframe.php';
$session->is_auth();
$header = "Пациент";
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

                <div class="card border-1 border-info">
				    <div class="card-header text-dark header-elements-inline alpha-info">
				        <h6 class="card-title">Просмотр визита</h6>
				    </div>

					<div class="card-body">

					   	<?php include "content_tabs.php"; ?>

						<legend class="font-weight-semibold text-uppercase font-size-sm">
							<i class="icon-calculator3 mr-2"></i>Расходы
                            <a onclick="Print('<?= viv('prints/document_4') ?>?id=<?= $patient->visit_id ?>')" type="button" class="float-right mr-1"><i class="icon-printer2"></i></a>
						</legend>

					   	<div class="card">

						   	<div class="table-responsive">
							   	<table class="table table-hover table-sm table-bordered">
 								  	<thead>
 									  	<tr class="bg-info">
 										  	<th style="width: 40px !important;">№</th>
                                            <th>Наименование</th>
 										  	<th class="text-center">Кол-во</th>
											<th class="text-right" style="width: 200px;">Цена</th>
                                          	<th class="text-right" style="width: 200px;">Сумма</th>
 									  	</tr>
 								  	</thead>
 								  	<tbody>
										<?php $total_cost=$total=0; $i=1; foreach ($db->query("SELECT id FROM visit WHERE physio IS NULL AND manipulation IS NULL AND laboratory IS NULL AND user_id = $patient->id AND priced_date IS NOT NULL AND accept_date BETWEEN \"$patient->add_date\" AND \"$patient->completed\"") as $value): ?>
                                            <?php foreach ($db->query("SELECT item_name, item_cost, (price_cash + price_card + price_transfer) 'price' FROM visit_price WHERE visit_id = {$value['id']} AND item_type IN (1,5,101)") as $row): ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td><?= $row['item_name'] ?></td>
                                                    <td class="text-center">1</td>
													<td class="text-right">
                                                        <?php
                                                        echo number_format($row['item_cost'], 1);
                                                        $total_cost += $row['item_cost'];
                                                        ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <?php
                                                        echo number_format($row['price'], 1);
                                                        $total += $row['price'];
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>

										<?php if(module('module_laboratory')): ?>
											<tr class="table-warning">
												<th colspan="5" class="text-center">Иследование лаборатории</th>
											</tr>
											<?php $i=1; foreach ($db->query("SELECT DISTINCT vp.item_id, vp.item_cost, vp.item_name, (vp.price_cash + vp.price_card + vp.price_transfer) 'price' FROM visit vs LEFT JOIN visit_price vp ON(vs.id=vp.visit_id) WHERE vs.laboratory IS NOT NULL AND vs.user_id = $patient->id AND vs.priced_date IS NOT NULL AND vs.accept_date BETWEEN \"$patient->add_date\" AND \"$patient->completed\"") as $row): ?>
												<tr>
													<td><?= $i++ ?></td>
													<td><?= $row['item_name'] ?></td>
													<td class="text-center">
														<?= $count = $db->query("SELECT vp.item_id FROM visit vs LEFT JOIN visit_price vp ON(vs.id=vp.visit_id) WHERE vs.laboratory IS NOT NULL AND vs.user_id = $patient->id AND vs.accept_date BETWEEN \"$patient->add_date\" AND \"$patient->completed\" AND vp.item_id = {$row['item_id']}")->rowCount() ?>
													</td>
													<td class="text-right">
														<?php
														echo number_format($row['item_cost'], 1);
														$total_cost += $count * $row['item_cost'];
														?>
													</td>
													<td class="text-right">
														<?php
														echo number_format($count * $row['price'], 1);
														$total += $count * $row['price'];
														?>
													</td>
												</tr>
											<?php endforeach; ?>
										<?php endif; ?>

										<tr class="table-warning">
											<th colspan="5" class="text-center">Физиотерапия/Процедуры</th>
										</tr>
                                        <?php $i=1; foreach ($db->query("SELECT DISTINCT vp.item_id, vp.item_cost, vp.item_name, (vp.price_cash + vp.price_card + vp.price_transfer) 'price' FROM visit vs LEFT JOIN visit_price vp ON(vs.id=vp.visit_id) WHERE (vs.physio IS NOT NULL OR vs.manipulation IS NOT NULL) AND vs.user_id = $patient->id AND vs.priced_date IS NOT NULL AND vs.accept_date BETWEEN \"$patient->add_date\" AND \"$patient->completed\"") as $row): ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= $row['item_name'] ?></td>
                                                <td class="text-center">
                                                	<?= $count = $db->query("SELECT vp.item_id FROM visit vs LEFT JOIN visit_price vp ON(vs.id=vp.visit_id) WHERE (vs.physio IS NOT NULL OR vs.manipulation IS NOT NULL) AND vs.user_id = $patient->id AND vs.accept_date BETWEEN \"$patient->add_date\" AND \"$patient->completed\" AND vp.item_id = {$row['item_id']}")->rowCount() ?>
                                                </td>
												<td class="text-right">
													<?php
													echo number_format($row['item_cost'], 1);
													$total_cost += $count * $row['item_cost'];
													?>
												</td>
                                                <td class="text-right">
                                                    <?php
                                                    echo number_format($count * $row['price'], 1);
                                                    $total += $count * $row['price'];
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>

										<?php if(module('module_pharmacy')): ?>
											<tr class="table-warning">
												<th colspan="5" class="text-center">Препараты</th>
											</tr>
											<?php $i=1; foreach ($db->query("SELECT id FROM visit WHERE physio IS NULL AND manipulation IS NULL AND laboratory IS NULL AND user_id = $patient->id AND priced_date IS NOT NULL AND accept_date BETWEEN \"$patient->add_date\" AND \"$patient->completed\"") as $value): ?>
												
												<?php foreach ($db->query("SELECT DISTINCT item_id FROM visit_price WHERE visit_id = {$value['id']} AND item_type IN (2,3,4)") as $rot): ?>
													<?php $row = $db->query("SELECT item_cost, item_name, COUNT(item_id) 'qty', (price_cash + price_card + price_transfer) 'price' FROM visit_price WHERE visit_id = {$value['id']} AND item_type IN (2,3,4) AND item_id = {$rot['item_id']}")->fetch(); ?>
													<tr>
														<td><?= $i++ ?></td>
														<td><?= $row['item_name'] ?></td>
														<td class="text-center"><?= $row['qty'] ?></td>
														<td class="text-right">
															<?php
															echo number_format($row['item_cost'], 1);
															$total_cost += $row['item_cost'] * $row['qty'];
															?>
														</td>
														<td class="text-right">
															<?php
															echo number_format($row['price'] * $row['qty'], 1);
															$total += $row['price'] * $row['qty'];
															?>
														</td>
													</tr>
												<?php endforeach; ?>
												
											<?php endforeach; ?>
										<?php endif; ?>

 								  	</tbody>
									<tfooter>
										<tr class="table-secondary">
											<th colspan="3" class="text-right">Итог:</th>
											<th class="text-right"><?= number_format($total_cost, 1) ?></th>
											<th class="text-right"><?= number_format($total, 1) ?></th>
										</tr>
									</tfooter>
 							  	</table>
					  		</div>

					   	</div>

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
