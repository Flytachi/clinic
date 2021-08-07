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
										<input type="text" class="<?= $classes['form-daterange'] ?>" name="date" value="<?= ( isset($_GET['date']) ) ? $_GET['date'] : "" ?>">
										<span class="input-group-append">
											<span class="input-group-text"><i class="icon-calendar22"></i></span>
										</span>
									</div>
								</div>

								<div class="col-md-3">
									<label>Кассир:</label>
									<select class="<?= $classes['form-multiselect'] ?>" data-placeholder="Выбрать кассира" name="pricer_id[]" multiple="multiple">
										<?php foreach ($db->query("SELECT DISTINCT pricer_id FROM visit_prices WHERE is_visibility IS NOT NULL AND is_price IS NOT NULL") as $row): ?>
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
									<button onclick="ExportExcel('table', 'Document','document.xls')" type="button" class="btn btn-outline-info btn-sm legitRipple">Excel</button>
								</div>
							</div>
						</div>

						<div class="card-body">

							<?php
							$_POST['date_start'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[0]));
							$_POST['date_end'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[1]));
							$where = " AND (DATE_FORMAT(price_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."')";
							if( isset($_GET['pricer_id']) ) $where .= " AND pricer_id IN(".implode(",", $_POST['pricer_id']) .")";

							$tb = new Table($db, "visit_prices");
							$tb->where("is_visibility IS NOT NULL AND is_price IS NOT NULL $where")->order_by('price_date ASC');
							$total_price=$total_price_cash=$total_price_card=$total_price_transfer=0;
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
									<?php foreach ($tb->get_table(1) as $row): ?>
										<tr>
											<th><?= $row->count ?></th>
											<th><?= date_f($row->price_date, 1) ?></th>
											<th><?= get_full_name($row->pricer_id) ?></th>
											<th><?= get_full_name($row->user_id)  ?></th>
											<th class="text-right text-<?= number_color($row->price_cash) ?>">
												<?php
												$total_price_cash += $row->price_cash;
												echo number_format($row->price_cash);
												?>
											</th>
											<th class="text-right text-<?= number_color($row->price_card) ?>">
												<?php
												$total_price_card += $row->price_card;
												echo number_format($row->price_card);
												?>
											</th>
											<th class="text-right text-<?= number_color($row->price_transfer) ?>">
												<?php
												$total_price_transfer += $row->price_transfer;
												echo number_format($row->price_transfer);
												?>
											</th>
											<th class="text-right text-<?= number_color($row->price_cash + $row->price_card + $row->price_transfer) ?>">
												<?php
												$total_price += $row->price_cash + $row->price_card + $row->price_transfer;
												echo number_format($row->price_cash + $row->price_card + $row->price_transfer);
												?>
											</th>
										</tr>
									<?php endforeach; ?>
								</tbody>
								<tr class="table-secondary strong">
									<th colspan="2">Общее колличество: <?= $row->count ?></th>
									<td colspan="2" class="text-right"><b>Итого :</b></td>
									<td class="text-right text-<?= number_color($total_price_cash) ?>"><?= number_format($total_price_cash) ?></td>
									<td class="text-right text-<?= number_color($total_price_card) ?>"><?= number_format($total_price_card) ?></td>
									<td class="text-right text-<?= number_color($total_price_transfer) ?>"><?= number_format($total_price_transfer) ?></td>
									<td class="text-right text-<?= number_color($total_price) ?>"><?= number_format($total_price) ?></td>
								</tr>
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
