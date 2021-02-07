<?php
require_once '../../../tools/warframe.php';
is_auth();
$header = "Общий отчёт по врачам";
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
									<label>Дата завершения:</label>
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
										<?php
										foreach($db->query("SELECT * FROM division WHERE level IN(5, 6, 12) OR level = 10 AND (assist IS NULL OR assist = 1)") as $row) {
											?>
											<option value="<?= $row['id'] ?>" <?= ($_POST['division_id']==$row['id']) ? "selected" : "" ?>><?= $row['title'] ?></option>
											<?php
										}
										?>
									</select>
								</div>

								<div class="col-md-3">
									<label>Услуга:</label>
									<select id="service" name="service_id" class="form-control form-control-select2" data-fouc>
										<option value="">Выберите услугу</option>
										<?php
										foreach($db->query("SELECT * from service WHERE user_level IN(5, 6, 10, 12)") as $row) {
											?>
											<option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>" <?= ($_POST['service_id']==$row['id']) ? "selected" : "" ?>><?= $row['name'] ?></option>
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
										$parent_sql = "SELECT * from users WHERE user_level IN(5, 6, 10, 12)";
										foreach($db->query($parent_sql) as $row) {
											?>
											<option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>" <?= ($_POST['parent_id']==$row['id']) ? "selected" : "" ?>><?= get_full_name($row['id']) ?></option>
											<?php
										}
										?>
									</select>
								</div>

							</div>

							<div class="from-group row">

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
								vs.completed, vs.parent_id,
								vp.item_name, vs.user_id,
								vp.item_cost, vs.priced_date,
								(SELECT share FROM users WHERE id = vs.parent_id) 'share',
								vp.item_cost * ((SELECT share FROM users WHERE id = vs.parent_id)/ 100) 'share_price'
							FROM visit vs
								LEFT JOIN visit_price vp ON(vp.visit_id=vs.id)
							WHERE
								vp.item_type = 1 AND vs.accept_date IS NOT NULL";
					// Обработка
					if ($_POST['date_start'] and $_POST['date_end']) {
						$sql .= " AND (DATE_FORMAT(vs.completed, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."')";
					}
					if ($_POST['division_id']) {
						$sql .= " AND vs.division_id = {$_POST['division_id']}";
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
					$total_price=0;
					$i=1;
					?>
					<div class="card border-1 border-info">

						<div class="card-header text-dark header-elements-inline alpha-info">
							<h6 class="card-title">Врачи</h6>
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
											<th style="width: 11%">Дата завершения</th>
	                                        <th>Специалист</th>
				                            <th>Услуга</th>
				                            <th>Пациент</th>
											<th class="text-right">Цена</th>
											<th class="text-center">Доля</th>
											<th class="text-right">Сумма</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($db->query($sql) as $row): ?>
											<tr>
												<td><?= $i++ ?></td>
												<td><?= ($row['completed']) ? date('d.m.y H:i', strtotime($row['completed'])) : '<span class="text-muted">Нет данных</span>' ?></td>
												<td><?= get_full_name($row['parent_id']) ?></td>
												<td><?= $row['item_name'] ?></td>
												<td><?= get_full_name($row['user_id']) ?></td>
												<td class="text-right text-<?= ($row['priced_date']) ? "success" : "danger" ?>"><?= number_format($row['item_cost']) ?></td>
												<td class="text-center"><?= ($row['share']) ? $row['share']."%" : '<span class="text-muted">Нет</span>'?></td>
												<td class="text-right text-success">
													<?php
													$total_price += $row['share_price'];
													echo number_format($row['share_price']);
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

	<script type="text/javascript">
		$(function(){
			$("#parent_id").chained("#division");
			$("#service").chained("#division");
		});
	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
