<?php
require_once '../../../tools/warframe.php';
$session->is_auth();
$header = "Отчёт кассы";
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

<script src="<?= stack("global_assets/js/plugins/tables/datatables/datatables.min.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/datatables_basic.js") ?>"></script>
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
									<label>Дата визита:</label>
									<div class="input-group">
										<input type="text" class="<?= $classes['form-daterange'] ?>" name="date" value="<?= ( isset($_POST['date']) ) ? $_POST['date'] : "" ?>">
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

							$sql = "SELECT 
										d.name,
										bpd.time,
										bp.user_id,
										bpd.completed
									FROM bypass bp
										LEFT JOIN bypass_date bpd ON(bpd.bypass_id = bp.id)
										LEFT JOIN diet d ON(d.id = bp.diet_id)
									WHERE 
										bp.diet_id IS NOT NULL AND bpd.status IS NOT NULL AND 
										(DATE_FORMAT(bpd.completed_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."')
										-- AND bpd.time = '{$_GET['time']}'
									ORDER BY bpd.time ASC";
								
								$total_price=$total_price_cash=$total_price_card=$total_price_transfer=0;
							?>

							<table class="table table-hover datatable-basic table-sm" id="table">
								<thead>
									<tr class="<?= $classes['table-thead'] ?>">
										<th style="width: 40px !important;">№</th>
										<th class="text-center">Время</th>
										<th class="text-center">Диета</th>
										<th class="text-center">ФИО</th>
										<th class="text-center">ID</th>
										<th class="text-center">Статус</th>
									</tr>
								</thead>
								<tbody>
								<?php $i=1;foreach ($db->query($sql) as $row): ?>
									<tr>
										<td><?= $i++ ?></td>
										<td class="text-center"><?= date("H:i", strtotime($row['time'])) ?></td>
										<td class="text-center"><?= $row['name'] ?></td>
										<td class="text-center"><?= get_full_name($row['user_id']) ?></td>
										<td class="text-center"><?= addZero($row['user_id']) ?></td>
										<td class="text-center"><?= ($row['completed']) ? '<span class="text-success">Confirmed</span>' : '<span class="text-danger">Not confirmed</span>' ?></td>
									</tr>
								<?php endforeach; ?>
								</tbody>
								<!-- <tr class="table-secondary strong">
									<th colspan="2">Общее колличество: <?= $i-1 ?></th>
									<td colspan="2" class="text-right"><b>Итого :</b></td>
									<td class="text-right <?= ($total_price!=0) ? ($total_price>0) ? 'text-success' : 'text-danger' : '' ?>"><?= number_format($total_price) ?></td>
									<td class="text-right <?= ($total_price_cash!=0) ? ($total_price_cash>0) ? 'text-success' : 'text-danger' : '' ?>"><?= number_format($total_price_cash) ?></td>
									<td class="text-right <?= ($total_price_card!=0) ? ($total_price_card>0) ? 'text-success' : 'text-danger' : '' ?>"><?= number_format($total_price_card) ?></td>
									<td class="text-right <?= ($total_price_transfer!=0) ? ($total_price_transfer>0) ? 'text-success' : 'text-danger' : '' ?>"><?= number_format($total_price_transfer) ?></td>
								</tr> -->
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
