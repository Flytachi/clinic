<?php
require_once '../../../tools/warframe.php';
is_auth();
$header = "Отчёт кассы";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<script src="<?= stack('global_assets/js/plugins/pickers/daterangepicker.js') ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/selects/bootstrap_multiselect.js") ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/anytime.min.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/picker.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/picker.date.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/picker.time.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/legacy.js') ?>"></script>

<script src="<?= stack("global_assets/js/plugins/tables/datatables/datatables.min.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/datatables_basic.js") ?>"></script>
<script src="<?= stack('global_assets/js/demo_pages/picker_date.js') ?>"></script>

<script src="<?= stack("global_assets/js/plugins/forms/styling/switch.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/form_inputs.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_layouts.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_select2.js") ?>"></script>
<script src="<?= stack('global_assets/js/demo_pages/form_multiselect.js') ?>"></script>

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
										<input type="text" class="form-control daterange-locale" name="date" value="<?= ($_POST['date']) ? $_POST['date'] : "" ?>">
										<span class="input-group-append">
											<span class="input-group-text"><i class="icon-calendar22"></i></span>
										</span>
									</div>
								</div>

								<div class="col-md-3">
									<label>Кассир:</label>
									<select class="form-control multiselect-full-featured" data-placeholder="Выбрать кассира" name="priser_id[]" multiple="multiple" data-fouc>
										<?php foreach ($db->query("SELECT * from users WHERE user_level IN (3, 32)") as $row): ?>
											<option value="<?= $row['id'] ?>" <?= (in_array($row['id'], $_POST['priser_id'])) ? "selected" : "" ?>><?= get_full_name($row['id']) ?></option>
										<?php endforeach; ?>
									</select>
								</div>

							</div>

							<div class="text-right">
								<button type="submit" class="btn btn-outline-info"><i class="icon-search4 mr-2"></i>Поиск</button>
							</div>

						</form>

					</div>

				</div>

				<?php if ($_POST): ?>
					<div class="card border-1 border-info">

						<div class="card-header text-dark header-elements-inline alpha-info">
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
							$sql = "SELECT
										vs.pricer_id,
										vs.user_id,
										(vs.price_cash + vs.price_card + vs.price_transfer) 'price',
										vs.price_cash,
										vs.price_card,
										vs.price_transfer,
										vs.price_date
									FROM visit_price vs
									WHERE
										vs.status = 1 AND
										vs.item_type = 1 AND
										vs.price_date IS NOT NULL AND
										(DATE_FORMAT(vs.price_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."') AND
										vs.pricer_id IN (".implode(",", $_POST['priser_id']).")
									UNION ALL
									SELECT
										iv.pricer_id,
										iv.user_id,
										(iv.balance_cash + iv.balance_card + iv.balance_transfer) 'price',
										iv.balance_cash,
										iv.balance_card,
										iv.balance_transfer,
										iv.add_date
									FROM investment iv
									WHERE
										iv.add_date IS NOT NULL AND
										(DATE_FORMAT(iv.add_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."') AND
										iv.pricer_id IN (".implode(",", $_POST['priser_id']).")
									";
							$total_price=$total_price_cash=$total_price_card=$total_price_transfer=0;
							?>

							<table class="table table-hover datatable-basic table-sm" id="table">
								<thead>
									<tr class="bg-info">
										<th style="width: 100px">№</th>
										<th style="width: 11%">Дата</th>
										<th>Кассир</th>
										<th>Пациент</th>
										<th class="text-right">Сумма оплаты</th>
										<th class="text-right">Наличные</th>
										<th class="text-right">Терминал</th>
										<th class="text-right">Перечисление</th>
									</tr>
								</thead>
								<tbody>
									<?php $i=1; foreach ($db->query($sql) as $row): ?>
										<tr>
											<th><?= $i++ ?></th>
											<th><?= date("d.m.Y H:i", strtotime($row['price_date'])) ?></th>
											<th><?= get_full_name($row['pricer_id']) ?></th>
											<th><?= get_full_name($row['user_id'])  ?></th>
											<th class="text-right <?= ($row['price']!=0) ? ($row['price']>0) ? 'text-success' : 'text-danger' : '' ?>">
												<?php
												$total_price += $row['price'];
												echo number_format($row['price']);
												?>
											</th>
											<th class="text-right <?= ($row['price_cash']!=0) ? ($row['price_cash']>0) ? 'text-success' : 'text-danger' : '' ?>">
												<?php
												$total_price_cash += $row['price_cash'];
												echo number_format($row['price_cash']);
												?>
											</th>
											<th class="text-right <?= ($row['price_card']!=0) ? ($row['price_card']>0) ? 'text-success' : 'text-danger' : '' ?>">
												<?php
												$total_price_card += $row['price_card'];
												echo number_format($row['price_card']);
												?>
											</th>
											<th class="text-right <?= ($row['price_transfer']!=0) ? ($row['price_transfer']>0) ? 'text-success' : 'text-danger' : '' ?>">
												<?php
												$total_price_transfer += $row['price_transfer'];
												echo number_format($row['price_transfer']);
												?>
											</th>
										</tr>
									<?php endforeach; ?>
								</tbody>
								<tr class="table-secondary strong">
									<th colspan="2">Общее колличество: <?= $i-1 ?></th>
									<td colspan="2" class="text-right"><b>Итого :</b></td>
									<td class="text-right <?= ($total_price!=0) ? ($total_price>0) ? 'text-success' : 'text-danger' : '' ?>"><?= number_format($total_price) ?></td>
									<td class="text-right <?= ($total_price_cash!=0) ? ($total_price_cash>0) ? 'text-success' : 'text-danger' : '' ?>"><?= number_format($total_price_cash) ?></td>
									<td class="text-right <?= ($total_price_card!=0) ? ($total_price_card>0) ? 'text-success' : 'text-danger' : '' ?>"><?= number_format($total_price_card) ?></td>
									<td class="text-right <?= ($total_price_transfer!=0) ? ($total_price_transfer>0) ? 'text-success' : 'text-danger' : '' ?>"><?= number_format($total_price_transfer) ?></td>
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
