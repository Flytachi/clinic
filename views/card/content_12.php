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
                                          	<th class="text-right" style="width: 200px;">Сумма</th>
 									  	</tr>
 								  	</thead>
 								  	<tbody>
										<?php $total=0; $i=1; foreach ($db->query("SELECT id FROM visit WHERE physio IS NULL AND manipulation IS NULL AND laboratory IS NULL AND user_id = $patient->id AND accept_date BETWEEN \"$patient->add_date\" AND \"$patient->completed\"") as $value): ?>
                                            <?php foreach ($db->query("SELECT * FROM visit_price WHERE visit_id = {$value['id']} AND item_type IN (1,2,3,4,5,101)") as $row): ?>
                                                <tr>
                                                    <td><?= $i++ ?></td>
                                                    <td><?= $row['item_name'] ?></td>
                                                    <td class="text-center">1</td>
                                                    <td class="text-right">
                                                        <?php
                                                        echo number_format($row['price_cash'] + $row['price_card'] + $row['price_transfer'], 1);
                                                        $total += $row['price_cash'] + $row['price_card'] + $row['price_transfer'];
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>

										<tr class="table-warning">
											<th colspan="4" class="text-center">Иследование лаборатории</th>
										</tr>
                                        <?php $i=1; foreach ($db->query("SELECT DISTINCT vp.item_id, vp.item_name, vp.price_cash, vp.price_card, vp.price_transfer FROM visit vs LEFT JOIN visit_price vp ON(vs.id=vp.visit_id) WHERE vs.laboratory IS NOT NULL AND vs.user_id = $patient->id AND vs.accept_date BETWEEN \"$patient->add_date\" AND \"$patient->completed\"") as $row): ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= $row['item_name'] ?></td>
                                                <td class="text-center">
                                                	<?= $count = $db->query("SELECT vp.item_id FROM visit vs LEFT JOIN visit_price vp ON(vs.id=vp.visit_id) WHERE vs.laboratory IS NOT NULL AND vs.user_id = $patient->id AND vs.accept_date BETWEEN \"$patient->add_date\" AND \"$patient->completed\" AND vp.item_id = {$row['item_id']}")->rowCount() ?>
                                                </td>
                                                <td class="text-right">
                                                    <?php
                                                    echo number_format($count * ($row['price_cash'] + $row['price_card'] + $row['price_transfer']), 1);
                                                    $total += $count * ($row['price_cash'] + $row['price_card'] + $row['price_transfer']);
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>

										<tr class="table-warning">
											<th colspan="4" class="text-center">Физиотерапия/Процедуры</th>
										</tr>
                                        <?php $i=1; foreach ($db->query("SELECT DISTINCT vp.item_id, vp.item_name, vp.price_cash, vp.price_card, vp.price_transfer FROM visit vs LEFT JOIN visit_price vp ON(vs.id=vp.visit_id) WHERE (vs.physio IS NOT NULL OR vs.manipulation IS NOT NULL) AND vs.user_id = $patient->id AND vs.accept_date BETWEEN \"$patient->add_date\" AND \"$patient->completed\"") as $row): ?>
                                            <tr>
                                                <td><?= $i++ ?></td>
                                                <td><?= $row['item_name'] ?></td>
                                                <td class="text-center">
                                                	<?= $count = $db->query("SELECT vp.item_id FROM visit vs LEFT JOIN visit_price vp ON(vs.id=vp.visit_id) WHERE (vs.physio IS NOT NULL OR vs.manipulation IS NOT NULL) AND vs.user_id = $patient->id AND vs.accept_date BETWEEN \"$patient->add_date\" AND \"$patient->completed\" AND vp.item_id = {$row['item_id']}")->rowCount() ?>
                                                </td>
                                                <td class="text-right">
                                                    <?php
                                                    echo number_format($count * ($row['price_cash'] + $row['price_card'] + $row['price_transfer']), 1);
                                                    $total += $count * ($row['price_cash'] + $row['price_card'] + $row['price_transfer']);
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
 								  	</tbody>
									<tfooter>
										<tr class="table-secondary">
											<th colspan="3" class="text-right">Итог:</th>
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
