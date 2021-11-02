<?php
require_once '../../../tools/warframe.php';
$session->is_auth([6, 8]);
is_module('module_laboratory');
$header = "Отчёт лаборатории по визитам";
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

								<div class="col-md-3">
									<label>Отдел:</label>
									<select id="division" name="division_id" class="form-control form-control-select2" data-fouc>
									   <option value="">Выберите отдел</option>
										<?php foreach($db->query("SELECT * FROM division WHERE level IN(6)") as $row): ?>
											<option value="<?= $row['id'] ?>" <?= ($_POST['division_id']==$row['id']) ? "selected" : "" ?>><?= $row['title'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>

								<div class="col-md-3">
									<label>Услуга:</label>
									<select id="service" name="service_id" class="form-control form-control-select2" data-fouc>
										<option value="">Выберите услугу</option>
										<?php foreach($db->query("SELECT * FROM service WHERE user_level IN(6)") as $row):?>
											<option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>" <?= ($_POST['service_id']==$row['id']) ? "selected" : "" ?>><?= $row['name'] ?></option>
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
					<?php
					$_POST['date_start'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[0]));
					$_POST['date_end'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[1]));
					$sql = "SELECT DISTINCT vs.service_id,
								ds.title,
								sc.name ,
								sc.price,
								@qty := (SELECT COUNT(vsc.service_id) FROM visit vsc WHERE vsc.service_id = vs.service_id AND (DATE_FORMAT(vsc.accept_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")) 'qty',
								@qty * sc.price 'amount'
							
							FROM visit vs 
								LEFT JOIN service sc ON(sc.id=vs.service_id) 
								LEFT JOIN division ds ON(ds.id=vs.division_id)
							WHERE
								vs.laboratory IS NOT NULL AND vs.accept_date IS NOT NULL";
					// Обработка
					if ($_POST['date_start'] and $_POST['date_end']) {
						$sql .= " AND (DATE_FORMAT(vs.accept_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."')";
					}
					if ($_POST['division_id']) {
						$sql .= " AND vs.division_id = {$_POST['division_id']}";
					}
					if ($_POST['service_id']) {
						$sql .= " AND vs.service_id = {$_POST['service_id']}";
					}
					$i=1;
					$total_amount = 0;
					?>
					<div class="card border-1 border-info">

						<div class="card-header text-dark header-elements-inline alpha-info">
							<h6 class="card-title">Визиты</h6>
							<div class="header-elements">
								<div class="list-icons">
									<button onclick="ExportExcel('table', 'Document','document.xls')" type="button" class="btn btn-outline-info btn-sm legitRipple">Excel</button>
								</div>
							</div>
						</div>

						<div class="card-body">

							<div class="table-responsive">
	                            <table class="table table-hover table-sm table-bordered" id="table">
	                                <thead>
	                                    <tr class="bg-info">
											<th style="width: 50px">№</th>
											<th>Отдел</th>
											<th>Услуга</th>
											<th style="width: 10%" class="text-center">Кол-во</th>
											<th class="text-right">Цена</th>
											<th class="text-right">Сумма</th>
										</tr>
	                                </thead>
	                                <tbody>
										<?php foreach ($db->query($sql) as $row): ?>
											<tr>
												<td><?= $i++ ?></td>
												<td><?= $row['title'] ?></td>
												<td><?= $row['name'] ?></td>
												<td class="text-center"><?= $row['qty'] ?></td>
												<td class="text-right text-success"><?= number_format($row['price']) ?></td>
												<td class="text-right text-success"><?php $total_amount += $row['amount']; echo number_format($row['amount']); ?></td>
											</tr>
										<?php endforeach; ?>
										<tr class="table-secondary">
											<th colspan="5" class="text-right">Итого:</th>
											<th class="text-right"><?= number_format($total_amount) ?></th>
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
