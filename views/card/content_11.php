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
							<i class="icon-puzzle3 mr-2"></i>Расходные материалы
							<?php if ($activity and permission(7)): ?>
								<a class="float-right <?= $class_color_add ?>" data-toggle="modal" data-target="#modal_add">
									<i class="icon-plus22 mr-1"></i>Добавить
								</a>
							<?php endif; ?>
						</legend>

					   	<div class="card">

						   	<div class="table-responsive">
							   	<table class="table table-hover table-sm table-bordered">
 								  	<thead>
 									  	<tr class="bg-info">
 										  	<th style="width: 40px !important;">№</th>
 										  	<th>Препарат</th>
                                          	<th style="width: 200px;">Цена ед.</th>
                                          	<th style="width: 200px;">Сумма</th>
                                          	<th style="width: 100px;">Сегоня</th>
 										  	<th style="width: 100px;">Всего</th>
 									  	</tr>
 								  	</thead>
 								  	<tbody>
										<?php
										$sql = "SELECT DISTINCT vp.item_id,
												vp.item_name,
												vp.item_cost,
												vp.item_cost * (SELECT COUNT(*) FROM visit_price WHERE visit_id = $patient->visit_id AND item_type = 3 AND item_id = vp.item_id) 'price',
												(SELECT COUNT(*) FROM visit_price WHERE visit_id = $patient->visit_id AND item_type = 3 AND item_id = vp.item_id AND DATE_FORMAT(add_date, '%Y-%m-%d') = CURRENT_DATE()) 'count_every',
												(SELECT COUNT(*) FROM visit_price WHERE visit_id = $patient->visit_id AND item_type = 3 AND item_id = vp.item_id) 'total_count_all'
											FROM visit_price vp
											WHERE vp.visit_id = $patient->visit_id AND vp.item_type = 3";
  									  	$total_total_price = $total_count_every = $total_count_all = 0;
  									  	?>
									  	<?php $i=1; foreach ($db->query($sql) as $row): ?>
									  		<tr>
                                        		<td><?= $i++ ?></td>
  											  	<td><?= $row['item_name'] ?></td>
                                        		<td><?= $row['item_cost'] ?></td>
  											  	<td>
  											  		<?php
	  													$total_total_price += $row['price'];
	  													echo number_format($row['price']);
	  												?>
  											  	</td>
  											  	<td>
	  												<?php
	  	  												$total_count_every += $row['count_every'];
	  	  												echo number_format($row['count_every']);
													?>
  											  	</td>
  											  	<td>
												  	<?php
	  													$total_count_all += $row['total_count_all'];
    	  												echo number_format($row['total_count_all']);
      												?>
  											  	</td>
   										  	</tr>
  									  	<?php endforeach; ?>

                                        <tr class="table-primary">
                                        	<td colspan="3">Итог:</td>
                                            <td><?= number_format($total_total_price) ?></td>
                                            <td><?= $total_count_every ?></td>
                                            <td><?= $total_count_all ?></td>
                                        </tr>
 								  	</tbody>
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

    <?php if ($activity): ?>
		<?php if (permission([7])): ?>
			<div id="modal_add" class="modal fade" tabindex="-1">
		        <div class="modal-dialog modal-lg">
		            <div class="modal-content border-3 border-info">
		                <div class="modal-header bg-info">
		                    <h5 class="modal-title">Добавить расходный материал</h5>
		                    <button type="button" class="close" data-dismiss="modal">×</button>
		                </div>

	                	<?= StorageHomeForm::form() ?>

		            </div>
		        </div>
		    </div>
	    <?php endif; ?>
    <?php endif; ?>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
