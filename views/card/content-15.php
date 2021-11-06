<?php
require_once 'callback.php';
is_module('module_pharmacy');
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
							<i class="icon-puzzle3 mr-2"></i>Расходные материалы
							<?php if ($activity and permission(25)): ?>
								<a onclick='Route(`<?= up_url(null, "WarehouseCustomPanel") ?>&patient=<?= json_encode($patient) ?>`)' class="float-right <?= $class_color_add ?>">
									<i class="icon-plus22 mr-1"></i>Добавить
								</a>
							<?php endif; ?>
						</legend>

					   	<div class="card">

						   	<div class="table-responsive">
							   	<table class="table table-hover table-sm table-bordered">
 								  	<thead class="<?= $classes['table-thead'] ?>">
 									  	<tr>
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
										$sql = "SELECT DISTINCT vb.item_name,
												vb.item_cost,
												vb.item_cost * (SELECT SUM(item_qty) FROM visit_bypass_transactions WHERE visit_id = vb.visit_id AND visit_bypass_event_id IS NULL AND item_name = vb.item_name AND item_cost = vb.item_cost) 'price',
												(SELECT SUM(item_qty) FROM visit_bypass_transactions WHERE visit_id = vb.visit_id AND visit_bypass_event_id IS NULL AND item_name = vb.item_name AND item_cost = vb.item_cost AND DATE_FORMAT(add_date, '%Y-%m-%d') = CURRENT_DATE()) 'count_every',
												(SELECT SUM(item_qty) FROM visit_bypass_transactions WHERE visit_id = vb.visit_id AND visit_bypass_event_id IS NULL AND item_name = vb.item_name AND item_cost = vb.item_cost) 'total_count_all'
											FROM visit_bypass_transactions vb
											WHERE vb.visit_id = $patient->visit_id AND vb.visit_bypass_event_id IS NULL";
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

    <?php if ($activity and permission([25])): ?>
		<div id="modal_default" class="modal fade" tabindex="-1">
			<div class="modal-dialog modal-full">
				<div class="<?= $classes['modal-global_content'] ?>" id="form_card"></div>
			</div>
		</div>
    <?php endif; ?>

	<script type="text/javascript">

		function Route(events) {
			$.ajax({
				type: "GET",
				url: events,
				success: function (result) {
					$('#modal_default').modal('show');
					$('#form_card').html(result);
				},
			});
		};

	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
