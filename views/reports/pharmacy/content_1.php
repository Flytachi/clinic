<?php
require_once '../../../tools/warframe.php';
$session->is_auth();
is_module('module_pharmacy');
$header = "Отчёт аптеки внешним расходам";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>
<script src="<?= stack('global_assets/js/plugins/pickers/daterangepicker.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/anytime.min.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/picker.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/picker.date.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/picker.time.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/legacy.js') ?>"></script>

<script src="<?= stack('global_assets/js/demo_pages/picker_date.js') ?>"></script>

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

                <div class="<?= $classes['card-filter'] ?>">

                    <div class="<?= $classes['card-filter_header'] ?>">
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

								<div class="col-md-6">
									<label>Склад:</label>
									<select class="<?= $classes['form-select'] ?>" name="warehouse_id" required data-placeholder="Выберите склад">
				                        <option></option>
										<?php foreach ($db->query("SELECT * FROM warehouses") as $ware): ?>
											<option value="<?= $ware['id'] ?>" <?= (isset($_POST['warehouse_id']) and $_POST['warehouse_id'] == $ware['id']) ? 'selected' : '' ?>><?= $ware['name'] ?></option>
										<?php endforeach; ?>
				                    </select>
								</div>

								<div class="col-md-6">
									<label>Дата:</label>
									<div class="input-group">
										<input type="text" class="<?= $classes['form-daterange'] ?>" name="date" value="<?= ( isset($_POST['date']) ) ? $_POST['date'] : '' ?>">
										<span class="input-group-append">
											<span class="input-group-text"><i class="icon-calendar22"></i></span>
										</span>
									</div>
								</div>

							</div>

							<div class="text-right">
								<button type="submit" class="<?= $classes['card-filter_btn'] ?>"><i class="icon-search4 mr-2"></i>Поиск</button>
							</div>

						</form>

                    </div>

                </div>

				<?php if ($_POST): ?>
					<?php
					$_POST['date_start'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[0]));
					$_POST['date_end'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[1]));
					$sql = "SELECT * FROM warehouse_storage_transactions WHERE warehouse_id_from = {$_POST['warehouse_id']}";
					// Обработка
					if ($_POST['date_start'] and $_POST['date_end']) {
						$sql .= " AND (DATE_FORMAT(add_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."')";
					}
					$total_cash = $total_card = $total_transfer = $total_cost = 0;
					?>

					<div class="<?= $classes['card'] ?>">

						<div class="<?= $classes['card-header'] ?>">
							<h6 class="card-title">Расходы</h6>
							<div class="header-elements">
								<div class="list-icons">
									<button onclick="ExportExcel('table', 'Document','document.xls')" type="button" class="btn btn-outline-info btn-sm legitRipple">Excel</button>
								</div>
							</div>
						</div>

						<div class="card-body">

							<div class="table-responsive card">
								<table class="table table-hover table-sm" id="table">
									<thead>
										<tr class="<?= $classes['table-thead'] ?>">
											<th>Препарат</th>
											<th>Поставщик</th>
											<th>Дата</th>
											<th>Ответственный</th>
											<th class="text-center">Тип расхода</th>
											<th class="text-right">Кол-во</th>
											<th class="text-right">Стоимость ед.</th>
											<th class="text-right">Наличные</th>
											<th class="text-right">Терминал</th>
											<th class="text-right">Перечисление</th>
											<th class="text-right">Сумма</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($db->query($sql) as $row): ?>
											<tr>
												<td><?= $row['item_name'] ?></td>
												<td><?= $row['item_manufacturer'] ?></td>
												<td><?= date("d.m.Y H:i", strtotime($row['add_date'])) ?></td>
												<td><?= get_full_name($row['responsible_id']) ?></td>
												<td class="text-center">
													<?php if ($row['is_moving']): ?>
														<span class="badge badge-primary">Перевод</span>
													<?php endif; ?>
													<?php if ($row['is_written_off']): ?>
														<span class="badge badge-danger">Списание</span>
													<?php endif; ?>
													<?php if ($row['is_sold']): ?>
														<span class="badge badge-success">Продажа</span>
													<?php endif; ?>
												</td>
												<td class="text-right"><?= number_format($row['item_qty']) ?></td>
												<td class="text-right"><?= number_format($row['item_price']) ?></td>
												<td class="text-right">
													<?php $total_cash += -$row['price_cash']; if (-$row['price_cash'] > 0): ?>
														<span class="text-success"><?= number_format(-$row['price_cash'], 1) ?></span>
													<?php else: ?>
														<span class="text-danger"><?= number_format(-$row['price_cash'], 1) ?></span>
													<?php endif; ?>
												</td>
												<td class="text-right">
													<?php $total_card += -$row['price_card']; if (-$row['price_card'] > 0): ?>
														<span class="text-success"><?= number_format(-$row['price_card'], 1) ?></span>
													<?php else: ?>
														<span class="text-danger"><?= number_format(-$row['price_card'], 1) ?></span>
													<?php endif; ?>
												</td>
												<td class="text-right">
													<?php $total_transfer += -$row['price_transfer']; if (-$row['price_transfer'] > 0): ?>
														<span class="text-success"><?= number_format(-$row['price_transfer'], 1) ?></span>
													<?php else: ?>
														<span class="text-danger"><?= number_format(-$row['price_transfer'], 1) ?></span>
													<?php endif; ?>
												</td>
												<td class="text-right">
													<?php $total_cost += -$row['cost']; if (-$row['cost'] > 0): ?>
														<span class="text-success"><?= number_format(-$row['cost'], 1) ?></span>
													<?php else: ?>
														<span class="text-danger"><?= number_format(-$row['cost'], 1) ?></span>
													<?php endif; ?>
												</td>
											</tr>
										<?php endforeach; ?>
										<tr class="table-secondary text-right">
											<th colspan="7">Итого:</th>
											<th><?= number_format($total_cash, 1) ?></th>
											<th><?= number_format($total_card, 1) ?></th>
											<th><?= number_format($total_transfer, 1) ?></th>
											<th><?= number_format($total_cost, 1) ?></th>
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

	<script type="text/javascript">
		$(function(){
			$("#service").chained("#division");
			$("#parent_id").chained("#division");
		});
	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
