<?php
require_once '../../../tools/warframe.php';
$session->is_auth([8, 10]);
$header = "Отчёт диагностики по визитам";
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
				                    <label>Пациент:</label>
									<select class="form-control form-control-select2" name="user_id" data-fouc>
				                        <option value="">Выберите пациента</option>
										<?php
										foreach($db->query('SELECT * from users WHERE user_level = 15') as $row) {
											?>
											<option value="<?= $row['id'] ?>" <?= ($_POST['user_id']==$row['id']) ? "selected" : "" ?>><?= addZero($row['id'])." - ".get_full_name($row['id']) ?></option>
											<?php
										}
										?>
				                    </select>
				                </div>

								<div class="col-md-3">
									<label>Дата приёма:</label>
									<div class="input-group">
										<input type="text" class="form-control daterange-locale" name="date" value="<?= $_POST['date'] ?>">
										<span class="input-group-append">
											<span class="input-group-text"><i class="icon-calendar22"></i></span>
										</span>
									</div>
								</div>

								<div class="col-md-3">
				                    <label>Тип визита:</label>
				                    <select class="form-control form-control-select2" name="direction" data-fouc>
				                        <option value="">Выберите тип визита</option>
										<option value="1" <?= ($_POST['direction']==1) ? "selected" : "" ?>>Амбулаторный</option>
										<option value="2" <?= ($_POST['direction']==2) ? "selected" : "" ?>>Стационарный</option>
				                    </select>
				                </div>

								<div class="col-md-3">
									<label class="d-block font-weight-semibold">Статус</label>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="custom_checkbox_stacked_unchecked" name="compl_true" <?= (!$_POST or $_POST['compl_true']) ? "checked" : "" ?>>
										<label class="custom-control-label" for="custom_checkbox_stacked_unchecked">Завершёные</label>
									</div>

									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="custom_checkbox_stacked_checked" name="compl_false" <?= (!$_POST or $_POST['compl_false']) ? "checked" : "" ?>>
										<label class="custom-control-label" for="custom_checkbox_stacked_checked">Не завершёные</label>
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
					$sql = "SELECT
								vs.user_id, vs.accept_date,
								vs.completed, vp.item_name,
								vp.item_cost, vs.priced_date,
								vp.sale, (vp.price_cash + vp.price_card + vp.price_transfer) 'price'
							FROM visit vs
								LEFT JOIN visit_price vp ON(vp.visit_id=vs.id)
								LEFT JOIN division ds ON(ds.id=vs.division_id)
							WHERE
								vp.item_type = 1 AND vs.accept_date IS NOT NULL AND ds.level = 10";

					// Обработка
					if ($_POST['user_id']) {
						$sql .= " AND vs.user_id = {$_POST['user_id']}";
					}
					if ($_POST['date_start'] and $_POST['date_end']) {
						$sql .= " AND (DATE_FORMAT(vs.accept_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."')";
					}
					if ($_POST['direction']) {
						$sql .= ($_POST['direction']==1) ? " AND vs.direction IS NULL" : " AND vs.direction IS NOT NULL";
					}
					if (!$_POST['compl_true'] or !$_POST['compl_false']) {
						if ($_POST['compl_true']) {
							$sql .= " AND vs.completed IS NOT NULL";
						}
						if ($_POST['compl_false']) {
							$sql .= " AND vs.completed IS NULL";
						}
					}
					$total_price=0;
					$i=1;
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
	                                        <th>Пациент</th>
				                            <th style="width: 11%">Дата приёма</th>
											<th style="width: 11%">Дата завершения</th>
				                            <th>Услуга</th>
											<th class="text-right">Цена</th>
											<th class="text-center">Доля</th>
											<th class="text-right">Сумма</th>
										</tr>
	                                </thead>
	                                <tbody>
										<?php foreach ($db->query($sql) as $row): ?>
											<tr>
												<td><?= $i++ ?></td>
												<td><?= get_full_name($row['user_id']) ?></td>
												<td><?= ($row['accept_date']) ? date('d.m.y H:i', strtotime($row['accept_date'])) : '<span class="text-muted">Нет данных</span>' ?></td>
												<td><?= ($row['completed']) ? date('d.m.y H:i', strtotime($row['completed'])) : '<span class="text-muted">Нет данных</span>' ?></td>
												<td><?= $row['item_name'] ?></td>
												<td class="text-right text-success"> <?= number_format($row['item_cost']); ?> </td>
												<td class="text-center"><?= ($row['sale']) ? $row['sale']."%" : '<span class="text-muted">Нет</span>'?></td>
												<td class="text-right text-<?= ($row['priced_date']) ? "success" : "danger" ?>">
													<?php
													if ($row['priced_date']) {
														$total_price += $row['price'];
													}
													echo number_format($row['price']);
													?>
												</td>
											</tr>
										<?php endforeach; ?>
										<tr class="table-secondary">
											<th colspan="2">Общее колличество: <?= $i-1 ?></th>
											<th colspan="5" class="text-right">Итого:</th>
											<td class="text-right text-success"><?= number_format($total_price) ?></td>
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

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
