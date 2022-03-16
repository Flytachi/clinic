<?php
require_once '../../../tools/warframe.php';
$session->is_auth();
$header = "Отчёт кассы";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<script src="<?= stack('global_assets/js/plugins/pickers/daterangepicker.js') ?>"></script>
<script src="<?= stack('global_assets/js/demo_pages/picker_date.js') ?>"></script>

<script src="<?= stack("global_assets/js/plugins/tables/datatables/datatables.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/datatables_basic.js") ?>"></script>

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

								<div class="col-md-3">
									<label>Дата визита:</label>
									<div class="input-group">
										<input type="text" class="<?= $classes['form-daterange'] ?>" name="date" value="<?= ( isset($_POST['date']) ) ? $_POST['date'] : "" ?>">
										<span class="input-group-append">
											<span class="input-group-text"><i class="icon-calendar22"></i></span>
										</span>
									</div>
								</div>

								<div class="col-md-3">
									<label>Кассир:</label>
									<select class="<?= $classes['form-multiselect'] ?>" data-placeholder="Выбрать кассира" name="pricer_id[]" multiple="multiple">
										<?php foreach ($db->query("SELECT DISTINCT pricer_id FROM visit_service_transactions WHERE is_visibility IS NOT NULL AND is_price IS NOT NULL") as $row): ?>
											<option value="<?= $row['pricer_id'] ?>" <?= ( isset($_POST['pricer_id']) and in_array($row['pricer_id'], $_POST['pricer_id'])) ? "selected" : "" ?>><?= get_full_name($row['pricer_id']) ?></option>
										<?php endforeach; ?>
									</select>
								</div>

							</div>

							<div class="text-right">
								<button type="submit" class="<?= $classes['card-filter_btn'] ?>"><i class="icon-search4 mr-2"></i>Поиск</button>
							</div>

						</form>

					</div>

				</div>

				<?php if ($_POST): ?>
					<div class="<?= $classes['card'] ?>">

						<div class="<?= $classes['card-header'] ?>">
							<h6 class="card-title">Отчёт</h6>
							<div class="header-elements">
								<div class="list-icons">
									<button onclick="ExportExcel('table', 'Document','document.xls')" type="button" class="<?= $classes['btn-table'] ?>">Excel</button>
								</div>
							</div>
						</div>

						<div class="card-body">

							<?php
							$_POST['date_start'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[0]));
							$_POST['date_end'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[1]));
							$where1 = " AND (DATE_FORMAT(price_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."')";
							$where2 = "(DATE_FORMAT(add_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."')";
							if( isset($_POST['pricer_id']) ) $where1 .= " AND pricer_id IN(".implode(",", $_POST['pricer_id']) .")";
							if( isset($_POST['pricer_id']) ) $where2 .= " AND pricer_id IN(".implode(",", $_POST['pricer_id']) .")";

							$total=$total_cash=$total_card=$total_transfer=0;
							$tb1 = $db->query("SELECT price_date 'date', pricer_id, patient_id, price_cash 'cash', price_card 'card', price_transfer 'transfer' FROM visit_service_transactions WHERE is_visibility IS NOT NULL AND is_price IS NOT NULL $where1 ORDER BY price_date ASC")->fetchAll();
							$tb2 = $db->query("SELECT add_date 'date', pricer_id, patient_id, balance_cash 'cash', balance_card 'card', balance_transfer 'transfer' FROM visit_investments WHERE $where2 ORDER BY add_date ASC")->fetchAll();
							?>

							<table class="table table-hover datatable-basic table-sm" id="table">
								<thead class="<?= $classes['table-thead'] ?>">
									<tr>
										<th style="width: 100px">№</th>
										<th style="width: 11%">Дата</th>
										<th>Кассир</th>
										<th>Пациент</th>
										<th class="text-right">Наличные</th>
										<th class="text-right">Терминал</th>
										<th class="text-right">Перечисление</th>
										<th class="text-right">Сумма оплаты</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1;foreach (array_multisort_value(array_merge($tb1,$tb2), 'date', SORT_ASC) as $row): ?>
										<tr>
											<td><?= $i++ ?></td>
											<td><?= date_f($row['date'], 1) ?></td>
											<td><?= get_full_name($row['pricer_id']) ?></td>
											<td><?= patient_name($row['patient_id'])  ?></td>
											<td class="text-right text-<?= number_color($row['cash']) ?>">
												<?php
												$total_cash += $row['cash'];
												echo number_format($row['cash']);
												?>
											</td>
											<td class="text-right text-<?= number_color($row['card']) ?>">
												<?php
												$total_card += $row['card'];
												echo number_format($row['card']);
												?>
											</td>
											<td class="text-right text-<?= number_color($row['transfer']) ?>">
												<?php
												$total_transfer += $row['transfer'];
												echo number_format($row['transfer']);
												?>
											</td>
											<td class="text-right text-<?= number_color($row['cash'] + $row['card'] + $row['transfer']) ?>">
												<?php
												$total += $row['cash'] + $row['card'] + $row['transfer'];
												echo number_format($row['cash'] + $row['card'] + $row['transfer']);
												?>
											</td>
										</tr>
									<?php endforeach; ?>
								</tbody>
								<?php if($i > 1): ?>
									<tfooter>
										<tr class="table-secondary">
											<th colspan="2">Общее колличество: <?= $i-1 ?></th>
											<th colspan="2" class="text-right">Итого:</th>
											<th class="text-right text-<?= number_color($total_cash) ?>"><?= number_format($total_cash) ?></th>
											<th class="text-right text-<?= number_color($total_card) ?>"><?= number_format($total_card) ?></th>
											<th class="text-right text-<?= number_color($total_transfer) ?>"><?= number_format($total_transfer) ?></th>
											<th class="text-right text-<?= number_color($total) ?>"><?= number_format($total) ?></th>
										</tr>
									</tfooter>
								<?php endif; ?>
							</table>

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
