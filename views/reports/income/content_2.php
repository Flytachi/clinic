<?php
require_once '../../../tools/warframe.php';
is_auth();
$header = "Доход";
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
									<label>Промежуток времени:</label>
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
										foreach($db->query('SELECT * from division WHERE level = 5') as $row) {
											?>
											<option value="<?= $row['id'] ?>" <?= ($_POST['division_id']==$row['id']) ? "selected" : "" ?>><?= $row['title'] ?></option>
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
										foreach($db->query('SELECT * from users WHERE user_level IN(5)') as $row) {
											?>
											<option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>" <?= ($_POST['parent_id']==$row['id']) ? "selected" : "" ?>><?= get_full_name($row['id']) ?></option>
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

					$sql = "SELECT us.id,
								IFNULL (us.share, 0) 'share',
								-- Амбулатор
								@amb_service_amount := IFNULL(
									(
										SELECT SUM(vp.price_cash + vp.price_card + vp.price_transfer) FROM visit vs LEFT JOIN visit_price vp ON(vp.visit_id=vs.id)
										WHERE vs.direction IS NULL AND vs.parent_id=us.id AND (DATE_FORMAT(vs.priced_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")
									)
									, 0) 'amb_service_amount',
								@amb_service_count := IFNULL(
									(
										SELECT COUNT(vp.id) FROM visit vs LEFT JOIN visit_price vp ON(vp.visit_id=vs.id)
										WHERE vs.direction IS NULL AND vs.parent_id=us.id AND (DATE_FORMAT(vs.priced_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")
									)
									, 0) 'amb_service_count',
								@amb_users_count := IFNULL(
									(
										SELECT COUNT(DISTINCT vs.user_id) FROM visit vs LEFT JOIN visit_price vp ON(vp.visit_id=vs.id)
										WHERE vs.direction IS NULL AND vs.parent_id=us.id AND (DATE_FORMAT(vs.priced_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")
									)
									, 0) 'amb_users_count',
								@amb_service_route_amount := IFNULL(
									(
										SELECT SUM(vp.price_cash + vp.price_card + vp.price_transfer) FROM visit vs LEFT JOIN visit_price vp ON(vp.visit_id=vs.id)
										WHERE vs.direction IS NULL AND vs.route_id=us.id AND (DATE_FORMAT(vs.priced_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")
									)
									, 0) 'amb_service_route_amount',
								@amb_service_route_count := IFNULL(
									(
										SELECT COUNT(vs.id) FROM visit vs LEFT JOIN visit_price vp ON(vp.visit_id=vs.id)
										WHERE vs.direction IS NULL AND vs.route_id=us.id AND (DATE_FORMAT(vs.priced_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")
									)
									, 0) 'amb_service_route_count',

								-- Стационар
								@sta_service_amount := IFNULL(
									(
										SELECT SUM(vp.price_cash + vp.price_card + vp.price_transfer) FROM visit vs LEFT JOIN visit_price vp ON(vp.visit_id=vs.id)
										WHERE vp.item_type IN (1) AND vs.direction IS NOT NULL AND vs.parent_id=us.id AND (DATE_FORMAT(vs.priced_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")
									)
									, 0) 'sta_service_amount',
								@sta_service_count := IFNULL(
									(
										SELECT COUNT(vp.id) FROM visit vs LEFT JOIN visit_price vp ON(vp.visit_id=vs.id)
										WHERE vp.item_type IN (1) AND vs.direction IS NOT NULL AND vs.parent_id=us.id AND (DATE_FORMAT(vs.priced_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")
									)
									, 0) 'sta_service_count',
								@sta_grant_visit_amount := IFNULL(
									(
										SELECT SUM(vp.price_cash + vp.price_card + vp.price_transfer) FROM visit vs LEFT JOIN visit_price vp ON(vp.visit_id=vs.id)
										WHERE vp.item_type IN (101) AND vs.direction IS NOT NULL AND vs.grant_id=us.id AND (DATE_FORMAT(vs.priced_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")
									)
									, 0) 'sta_grant_visit_amount',
								@sta_grant_visit_count := IFNULL(
									(
										SELECT COUNT(vs.id) FROM visit vs LEFT JOIN visit_price vp ON(vp.visit_id=vs.id)
										WHERE vp.item_type IN (101) AND vs.direction IS NOT NULL AND vs.grant_id=us.id AND (DATE_FORMAT(vs.priced_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")
									)
									, 0) 'sta_grant_visit_count',
								@sta_operation_amount := IFNULL(
									(
										SELECT SUM(vp.price_cash + vp.price_card + vp.price_transfer) FROM visit vs LEFT JOIN visit_price vp ON(vp.visit_id=vs.id)
										WHERE vp.item_type IN (5) AND vs.direction IS NOT NULL AND vs.parent_id=us.id AND (DATE_FORMAT(vs.priced_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")
									)
									, 0) 'sta_operation_amount',
								@sta_operation_count := IFNULL(
									(
										SELECT COUNT(vs.id) FROM visit vs LEFT JOIN visit_price vp ON(vp.visit_id=vs.id)
										WHERE vp.item_type IN (5) AND vs.direction IS NOT NULL AND vs.parent_id=us.id AND (DATE_FORMAT(vs.priced_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")
									)
									, 0) 'sta_operation_count',
								@sta_service_route_amount := IFNULL(
									(
										SELECT SUM(vp.price_cash + vp.price_card + vp.price_transfer) FROM visit vs LEFT JOIN visit_price vp ON(vp.visit_id=vs.id)
										WHERE vs.direction IS NOT NULL AND vs.route_id=us.id AND (DATE_FORMAT(vs.priced_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")
									)
									, 0) 'sta_service_route_amount',
								@sta_service_route_count := IFNULL(
									(
										SELECT COUNT(vs.id) FROM visit vs LEFT JOIN visit_price vp ON(vp.visit_id=vs.id)
										WHERE vs.direction IS NOT NULL AND vs.route_id=us.id AND (DATE_FORMAT(vs.priced_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")
									)
									, 0) 'sta_service_route_count'

							FROM users us
							WHERE us.id = {$_POST['parent_id']}";
					$information = $db->query($sql)->fetch(PDO::FETCH_OBJ);
					// prit($information);
					?>
					<div class="card card-body border-1 border-primary">
						<div class="text-center">
							<h4 class="mb-0 font-weight-semibold"><?= get_full_name($information->id) ?></h4>
							<p class="mb-3 text-muted">Врач <?= division_name($information->id) ?></p>
						</div>

						<div class="card card-body bg-light mb-0">
							<ul class="list mb-0">
								<li><b>Доля:</b> <?= $information->share ?>%</li>
								<li><b>Промежуток времени:</b> от <?= date('d.m.Y', strtotime($_POST['date_start'])) ?> до <?= date('d.m.Y', strtotime($_POST['date_end'])) ?></li>
								<li><h5>Амбулатор</h5>
									<ul class="list">
										<li><b>Колличество принятых пациентов:</b> <span class="text-primary"><?= $information->amb_users_count ?></span></li>
										<li><b>Колличество проведёных услуг:</b> <span class="text-primary"><?= $information->amb_service_count ?></span></li>
										<li><b>Колличество направленных услуг:</b> <span class="text-primary"><?= $information->amb_service_route_count ?></span></li>

										<li><b>Сумма проведёных услуг:</b> <span class="text-success"><?= number_format($information->amb_service_amount) ?></span></li>
										<li><b>Сумма направленных услуг:</b> <span class="text-success"><?= number_format($information->amb_service_route_amount) ?></span></li>
									</ul>
								</li>
								<li><h5>Стационар</h5>
									<ul class="list">
										<li><b>Колличество проведёных услуг:</b> <span class="text-primary"><?= $information->sta_service_count ?></span></li>
										<li><b>Колличество направленных услуг:</b> <span class="text-primary"><?= $information->sta_service_route_count ?></span></li>
										<li><b>Колличество проведёных операций:</b> <span class="text-primary"><?= $information->sta_operation_count ?></span></li>
										<li><b>Колличество проведёных стационарный осмотров (принятых пациентов):</b> <span class="text-primary"><?= $information->sta_grant_visit_count ?></span></li>

										<li><b>Сумма проведёных услуг:</b> <span class="text-success"><?= number_format($information->sta_service_amount) ?></span></li>
										<li><b>Сумма направленных услуг:</b> <span class="text-success"><?= number_format($information->sta_service_route_amount) ?></span></li>
										<li><b>Сумма проведёных операций:</b> <span class="text-success"><?= number_format($information->sta_operation_amount) ?></span></li>
										<li><b>Сумма проведёных стационарный осмотров (сумма коек):</b> <span class="text-success"><?= number_format($information->sta_grant_visit_amount) ?></span></li>

									</ul>
								</li>
								<li><b>Общее колличество направленных визитов:</b> <span class="text-primary"><?= $information->amb_service_route_count + $information->sta_service_route_count ?></span></li>
								<li><b>Общее колличество проведёных услуг:</b> <span class="text-primary"><?= $information->amb_service_count + $information->sta_service_count ?></span></li>
								<li><b>Общая сумма проведёных услуг:</b> <span class="text-success"><?= number_format($information->amb_service_amount + $information->sta_service_amount) ?></span></li>
								<li><b>Общая сумма направленных услуг:</b> <span class="text-success"><?= number_format($information->amb_service_route_amount + $information->sta_service_route_amount) ?></span></li>
								<!-- <li>Aenean sit amet erat nunc</li> -->
							</ul>
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
		});
	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
