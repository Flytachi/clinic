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

								<div class="col-md-3">
									<label>Специалист:</label>
									<select id="parent_id" name="parent_id" class="form-control form-control-select2" data-fouc>
										<option value="">Выберите специалиста</option>
										<?php foreach($db->query("SELECT * from users WHERE user_level IN(7)") as $row):?>
											<option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>" <?= ($_POST['parent_id']==$row['id']) ? "selected" : "" ?>><?= get_full_name($row['id']) ?></option>
										<?php endforeach; ?>
									</select>
								</div>

								<div class="col-md-3">
									<label class="d-block font-weight-semibold">Тип расхода</label>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="custom_checkbox_stacked_unchecked" name="type_1" <?= (!$_POST or $_POST['type_1']) ? "checked" : "" ?>>
										<label class="custom-control-label" for="custom_checkbox_stacked_unchecked">Внешний</label>
									</div>

									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="custom_checkbox_stacked_checked" name="type_2" <?= (!$_POST or $_POST['type_2']) ? "checked" : "" ?>>
										<label class="custom-control-label" for="custom_checkbox_stacked_checked">Операционный</label>
									</div>

									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="custom_checkbox_stacked_checked2" name="type_3" <?= (!$_POST or $_POST['type_3']) ? "checked" : "" ?>>
										<label class="custom-control-label" for="custom_checkbox_stacked_checked2">Внутренний</label>
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
					$sql = "SELECT *, ( amount + amount_cash + amount_card + amount_transfer ) 'amount_total' FROM storage_sales WHERE add_date IS NOT NULL";
					// Обработка
					if ($_POST['date_start'] and $_POST['date_end']) {
						$sql .= " AND (DATE_FORMAT(add_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."')";
					}
					if ($_POST['parent_id']) {
						$sql .= " AND parent_id = {$_POST['parent_id']}";
					}
					if (!$_POST['type_1'] or !$_POST['type_2'] or !$_POST['type_3']) {
						if ($_POST['type_1']) {
							if (!$_POST['type_2'] and !$_POST['type_3']) {
								$sql .= " AND operation_id IS NULL AND parent_id IS NULL";
							}elseif ($_POST['type_2']) {
								$sql .= " AND parent_id IS NULL";
							}elseif ($_POST['type_3']) {
								$sql .= " AND operation_id IS NULL";
							}
						}
						elseif ($_POST['type_2']) {
							if ($_POST['type_3']) {
								$sql .= " AND (operation_id IS NOT NULL OR parent_id IS NOT NULL)";
							}else {
								$sql .= " AND operation_id IS NOT NULL";
							}
						}
						elseif ($_POST['type_3']) {
							$sql .= " AND parent_id IS NOT NULL";
						}
					}
					$i=1;
					$total_qty = $total_amount_cash = $total_amount_card = $total_amount_transfer = $total_amount = 0;
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
								<table class="table table-hover table-sm" id="table">
									<thead>
										<tr class="bg-info">
											<th>Тип расхода</th>
											<th>Получатель</th>
											<th>Препарат</th>
											<th>Поставщик</th>
											<th>Код</th>
											<th>Дата</th>
											<th class="text-center">Кол-во</th>
											<th class="text-center">Скидка</th>
											<th class="text-right">Наличные</th>
											<th class="text-right">Терминал</th>
											<th class="text-right">Перечисление</th>
											<th class="text-right">Сумма</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($db->query($sql) as $row): ?>
											<tr>
												<td>
													<?php if (!$row['operation_id'] AND !$row['parent_id']): ?>
														Внешний
													<?php elseif($row['operation_id']): ?>
														Операционный
													<?php else: ?>
														Внутренний
													<?php endif; ?>
												</td>
												<td><?= get_full_name($row['parent_id']) ?></td>
												<td><?= $row['name'] ?></td>
												<td><?= $row['supplier'] ?></td>
												<td><?= $row['code'] ?></td>
												<td><?= date("d.m.Y H:i", strtotime($row['add_date'])) ?></td>
												<td class="text-center">
													<?php
													$total_qty += -$row['qty'];
													echo -$row['qty'];
													?>
												</td>
												<td class="text-center"><?= $row['sale'] ?>%</td>
												<td class="text-right">
													<?php $total_amount_cash += -$row['amount_cash']; if (-$row['amount_cash'] > 0): ?>
														<span class="text-success"><?= number_format(-$row['amount_cash'], 1) ?></span>
													<?php else: ?>
														<span class="text-danger"><?= number_format(-$row['amount_cash'], 1) ?></span>
													<?php endif; ?>
												</td>
												<td class="text-right">
													<?php $total_amount_card += -$row['amount_card']; if (-$row['amount_card'] > 0): ?>
														<span class="text-success"><?= number_format(-$row['amount_card'], 1) ?></span>
													<?php else: ?>
														<span class="text-danger"><?= number_format(-$row['amount_card'], 1) ?></span>
													<?php endif; ?>
												</td>
												<td class="text-right">
													<?php $total_amount_transfer += -$row['amount_transfer']; if (-$row['amount_transfer'] > 0): ?>
														<span class="text-success"><?= number_format(-$row['amount_transfer'], 1) ?></span>
													<?php else: ?>
														<span class="text-danger"><?= number_format(-$row['amount_transfer'], 1) ?></span>
													<?php endif; ?>
												</td>
												<td class="text-right">
													<?php $total_amount += -$row['amount_total']; if (-$row['amount_total'] > 0): ?>
														<span class="text-success"><?= number_format(-$row['amount_total'], 1) ?></span>
													<?php else: ?>
														<span class="text-danger"><?= number_format(-$row['amount_total'], 1) ?></span>
													<?php endif; ?>
												</td>
											</tr>
										<?php endforeach; ?>
										<tr class="table-secondary text-right">
											<th colspan="6">Итого:</th>
											<th class="text-center"><?= $total_qty ?></th>
											<th></th>
											<th><?= number_format($total_amount_cash, 1) ?></th>
											<th><?= number_format($total_amount_card, 1) ?></th>
											<th><?= number_format($total_amount_transfer, 1) ?></th>
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
