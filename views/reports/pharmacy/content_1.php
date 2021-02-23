<?php
require_once '../../../tools/warframe.php';
is_auth();
$header = "Отчёт аптеки по расходам";
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

				<?php include "content_tabs.php"; ?>

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
									<label>Дата:</label>
									<div class="input-group">
										<input type="text" class="form-control daterange-locale" name="date" value="<?= $_POST['date'] ?>">
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
					<?php
					$_POST['date_start'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[0]));
					$_POST['date_end'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[1]));
					$sql = "SELECT * FROM storage_sales WHERE add_date IS NOT NULL";
					// Обработка
					if ($_POST['date_start'] and $_POST['date_end']) {
						$sql .= " AND (DATE_FORMAT(add_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."')";
					}
					// if ($_POST['division_id']) {
					// 	$sql .= " AND vs.division_id = {$_POST['division_id']}";
					// }
					// if ($_POST['service_id']) {
					// 	$sql .= " AND vs.service_id = {$_POST['service_id']}";
					// }
					// if ($_POST['parent_id']) {
					// 	$sql .= " AND vs.parent_id = {$_POST['parent_id']}";
					// }
					// if ($_POST['user_id']) {
					// 	$sql .= " AND vs.user_id = {$_POST['user_id']}";
					// }
					// if ($_POST['direction']) {
					// 	$sql .= ($_POST['direction']==1) ? " AND vs.direction IS NULL" : " AND vs.direction IS NOT NULL";
					// }
					// if (!$_POST['compl_true'] or !$_POST['compl_false']) {
					// 	if ($_POST['compl_true']) {
					// 		$sql .= " AND vs.completed IS NOT NULL";
					// 	}
					// 	if ($_POST['compl_false']) {
					// 		$sql .= " AND vs.completed IS NULL";
					// 	}
					// }
					$i=1;
					?>

					<div class="card border-1 border-info">

						<div class="card-header text-dark header-elements-inline alpha-info">
							<h6 class="card-title">Расходы</h6>
							<div class="header-elements">
								<div class="list-icons">
									<button onclick="ExportExcel('table', 'Document','document.xls')" type="button" class="btn btn-outline-info btn-sm legitRipple">Excel</button>
								</div>
							</div>
						</div>

						<div class="card-body">

							<div class="table-responsive card">
								<table class="table table-hover table-sm id="table"">
									<thead>
										<tr class="bg-info">
											<th>Ответственный</th>
											<th style="width:40%">Препарат</th>
											<th>Поставщик</th>
											<th>Код</th>
											<th>Дата</th>
											<th class="text-right">Кол-во</th>
											<th class="text-right">Сумма</th>
										</tr>
									</thead>
									<tbody>
										<?php $total_qty=0;$total_amount=0;foreach ($db->query($sql) as $row): ?>
											<tr>
												<td><?= get_full_name($row['parent_id']) ?></td>
												<td><?= $row['name'] ?></td>
												<td><?= $row['supplier'] ?></td>
												<td><?= $row['code'] ?></td>
												<td><?= date("d.m.Y H:i", strtotime($row['add_date'])) ?></td>
												<td class="text-right">
													<?php
													$total_qty += -$row['qty'];
													echo -$row['qty'];
													?>
												</td>
												<td class="text-right text-success">
													<?php $total_amount += -$row['amount']; if (-$row['amount'] > 0): ?>
														<span class="text-success"><?= number_format(-$row['amount'], 1) ?></span>
													<?php else: ?>
														<span class="text-danger"><?= number_format(-$row['amount'], 1) ?></span>
													<?php endif; ?>
												</td>
											</tr>
										<?php endforeach; ?>
										<tr class="table-secondary text-right ">
											<th colspan="5">Итого:</th>
											<th><?= $total_qty ?></th>
											<th><?= number_format($total_amount, 1) ?></th>
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
