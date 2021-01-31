<?php
require_once '../../../tools/warframe.php';
is_auth();
$header = "Отчёт анестезии по услугам";
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
									<label>Дата принятия:</label>
									<div class="input-group">
										<input type="text" class="form-control daterange-locale" name="date" value="<?= $_POST['date'] ?>">
										<span class="input-group-append">
											<span class="input-group-text"><i class="icon-calendar22"></i></span>
										</span>
									</div>
								</div>


								<div class="col-md-3">
									<label>Услуга:</label>
									<select id="service" name="service_id" class="form-control form-control-select2" data-fouc>
										<option value="">Выберите услугу</option>
										<?php
										foreach($db->query('SELECT * from service WHERE user_level = 11') as $row) {
											?>
											<option value="<?= $row['id'] ?>" <?= ($_POST['service_id']==$row['id']) ? "selected" : "" ?>><?= $row['name'] ?></option>
											<?php
										}
										?>
									</select>
								</div>

								<div class="col-md-3">
									<label>Специалист:</label>
									<select id="parent_id" name="parent_id" class="form-control form-control-select2" data-fouc>
										<option value="">Выберите специалиста</option>
										<?php
										foreach($db->query('SELECT * from users WHERE user_level = 11') as $row) {
											?>
											<option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>" <?= ($_POST['parent_id']==$row['id']) ? "selected" : "" ?>><?= get_full_name($row['id']) ?></option>
											<?php
										}
										?>
									</select>
								</div>

								<div class="col-md-3">
									<label>Тип визита:</label>
									<select class="form-control form-control-select2" name="direction" data-fouc>
				                        <option value="">Выберите тип визита</option>
										<option value="1" <?= ($_POST['direction']==1) ? "selected" : "" ?>>Амбулаторный</option>
										<option value="2" <?= ($_POST['direction']==2) ? "selected" : "" ?>>Стационарный</option>
				                    </select>
								</div>

							</div>

							<div class="from-group row">

								<div class="col-md-3">
									<label>Пациент:</label>
									<select name="user_id" class="form-control form-control-select2" data-fouc>
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
								vs.accept_date,
								(SELECT title FROM division WHERE id=vs.division_id) 'division',
								vp.item_name,
								vs.parent_id,
								vs.direction,
								vs.user_id,
								vs.status,
								vs.completed
							FROM visit vs
								LEFT JOIN visit_price vp ON(vp.visit_id=vs.id)
								LEFT JOIN division ds ON(ds.id=vs.division_id)
							WHERE
								vp.item_type = 1 AND vs.accept_date IS NOT NULL AND ds.level = 11";
					// Обработка
					if ($_POST['date_start'] and $_POST['date_end']) {
						$sql .= " AND (DATE_FORMAT(vs.accept_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."')";
					}
					if ($_POST['service_id']) {
						$sql .= " AND vs.service_id = {$_POST['service_id']}";
					}
					if ($_POST['parent_id']) {
						$sql .= " AND vs.parent_id = {$_POST['parent_id']}";
					}
					if ($_POST['user_id']) {
						$sql .= " AND vs.user_id = {$_POST['user_id']}";
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
					$i=1;
					?>
					<div class="card border-1 border-info">

						<div class="card-header text-dark header-elements-inline alpha-info">
							<h6 class="card-title">Услуги</h6>
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
											<th style="width: 11%">Дата проведения</th>
				                            <th>Отдел</th>
				                            <th>Услуга</th>
											<th>Специалист</th>
				                            <th style="width: 10%">Тип визита</th>
											<th>Пациент</th>
											<th style="width: 10%">Статус</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
										<?php foreach ($db->query($sql) as $row): ?>
											<tr>
												<td><?= $i++ ?></td>
												<td><?= ($row['accept_date']) ? date('d.m.y H:i', strtotime($row['accept_date'])) : '<span class="text-muted">Нет данных</span>' ?></td>
												<td><?= $row['division'] ?></td>
												<td><?= $row['item_name'] ?></td>
												<td><?= get_full_name($row['parent_id']) ?></td>
												<td><?= ($row['direction']) ? "Стационарный" : "Амбулаторный" ?></td>
												<td><?= get_full_name($row['user_id']) ?></td>
												<td>
													<?php
													if ($row['completed']) {
														?>
														<span style="font-size:15px;" class="badge badge-flat border-success text-success">Завершена</span>
														<?php
													} else {
														switch ($row['status']):
															case 1:
																?>
																<span style="font-size:15px;" class="badge badge-flat border-orange text-orange">Ожидание</span>
																<?php
																break;
															case 2:
																?>
																<span style="font-size:15px;" class="badge badge-flat border-success text-success">У специолиста</span>
																<?php
																break;
															default:
																?>
																<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Оплачивается</span>
																<?php
																break;
														endswitch;
													}
													?>
												</td>
											</tr>
										<?php endforeach; ?>
										<tr class="table-secondary">
											<th colspan="2">Общее колличество: <?= $i-1 ?></th>
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
