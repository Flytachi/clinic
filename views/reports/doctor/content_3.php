<?php
require_once '../../../tools/warframe.php';
$session->is_auth([5, 8]);
$header = "Отчёт врачей по визитам";
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
				                    <label>Специалиста:</label>
									<select id="route_id" name="route_id" class="<?= $classes['form-select'] ?>" required>
										<option value="">Выберите специалиста</option>
										<?php foreach($db->query('SELECT * from users WHERE user_level IN(5)') as $row): ?>
											<option value="<?= $row['id'] ?>" <?= ( isset($_POST['route_id']) and $_POST['route_id']==$row['id']) ? "selected" : "" ?>><?= get_full_name($row['id']) ?></option>
										<?php endforeach; ?>
									</select>
				                </div>

								<div class="col-md-3">
									<label>Дата:</label>
									<div class="input-group">
										<input type="text" class="<?= $classes['form-daterange'] ?>" name="date" value="<?= ( isset($_POST['date']) ) ? $_POST['date'] : '' ?>">
										<span class="input-group-append">
											<span class="input-group-text"><i class="icon-calendar22"></i></span>
										</span>
									</div>
								</div>

								<div class="col-md-3">
				                    <label>Тип визита:</label>
				                    <select class="<?= $classes['form-select'] ?>" name="direction">
				                        <option value="">Выберите тип визита</option>
										<option value="1" <?= ( isset($_POST['direction']) and $_POST['direction']==1) ? "selected" : "" ?>>Амбулаторный</option>
										<option value="2" <?= ( isset($_POST['direction']) and $_POST['direction']==2) ? "selected" : "" ?>>Стационарный</option>
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
					$sql = "SELECT DISTINCT vs.division_id,
								(SELECT title FROM division ds WHERE ds.id=vs.division_id) 'title',
								(SELECT COUNT(DISTINCT vsc.user_id) FROM visit vsc WHERE vsc.route_id = vs.route_id AND vsc.division_id = vs.division_id AND (DATE_FORMAT(vsc.accept_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")) 'qty'
							FROM visit vs
							WHERE
								vs.accept_date IS NOT NULL";
					// Обработка
					if ($_POST['date_start'] and $_POST['date_end']) {
						$sql .= " AND (DATE_FORMAT(vs.accept_date, '%Y-%m-%d') BETWEEN \"{$_POST['date_start']}\" AND \"{$_POST['date_end']}\")";
					}
					if ( isset($_POST['route_id']) and $_POST['route_id']) {
						$sql .= " AND vs.route_id = {$_POST['route_id']}";
					}
					if ( isset($_POST['direction']) and $_POST['direction']) {
						$sql .= ($_POST['direction']==1) ? " AND vs.direction IS NULL" : " AND vs.direction IS NOT NULL";
					}
					$i=1;
					$total_qty = 0;
					?>
					<div class="<?= $classes['card'] ?>">

						<div class="<?= $classes['card-header'] ?>">
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
	                                    <tr class="<?= $classes['table-thead'] ?>">
											<th style="width: 50px">№</th>
											<th>Отдел</th>
											<th style="width: 10%" class="text-right">Кол-во</th>
										</tr>
	                                </thead>
	                                <tbody>
										<?php foreach ($db->query($sql) as $row): ?>
											<tr>
												<td><?= $i++ ?></td>
												<td><?= $row['title'] ?></td>
												<td class="text-right">
													<?php
													$total_qty += $row['qty'];
													echo $row['qty'];
													?>
												</td>
											</tr>
										<?php endforeach; ?>
										<tr class="table-secondary">
											<th class="text-right" colspan="2">Общее кол-во:</th>
											<th class="text-right"><?= $total_qty ?></th>
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
