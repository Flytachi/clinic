<?php
require_once '../../../tools/warframe.php';
$session->is_auth([2, 32]);
$header = "Отчёт регистратуры по регистрации";
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
									<label>Регистратор:</label>
									<select class="<?= $classes['form-multiselect'] ?>" data-placeholder="Выбрать регистратора" name="route_id[]" multiple="multiple">
										<?php foreach ($db->query("SELECT * from users WHERE user_level IN (2,32)") as $row): ?>
											<option value="<?= $row['id'] ?>" <?= ( isset($_POST['route_id']) and in_array($row['id'], $_POST['route_id'])) ? "selected" : "" ?>><?= get_full_name($row['id']) ?></option>
										<?php endforeach; ?>
									</select>
								</div>

								<div class="col-md-3">
									<label>Дата регистрации:</label>
									<div class="input-group">
										<input type="text" class="<?= $classes['form-daterange'] ?>" name="date" value="<?= ( isset($_POST['date']) ) ? $_POST['date'] : '' ?>">
										<span class="input-group-append">
											<span class="input-group-text"><i class="icon-calendar22"></i></span>
										</span>
									</div>
								</div>

								<div class="col-md-3">
									<label>Отдел:</label>
									<select class="<?= $classes['form-multiselect'] ?>" data-placeholder="Выбрать услуги" name="division_id[]" multiple="multiple">
										<?php foreach ($db->query("SELECT * FROM division WHERE level IN(5, 6, 12) OR level = 10 AND (assist IS NULL OR assist = 1)") as $row): ?>
											<option value="<?= $row['id'] ?>" <?= ( isset($_POST['division_id']) and in_array($row['id'], $_POST['division_id'])) ? "selected" : "" ?>><?= $row['title'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>

								<div class="col-md-3">
									<label>Направитель:</label>
									<select name="guide_id" class="<?= $classes['form-select'] ?>">
										<option value="">Выберите направителя</option>
										<?php foreach($db->query('SELECT * from guides') as $row): ?>
											<option value="<?= $row['id'] ?>" <?= ( isset($_POST['guide_id']) and $_POST['guide_id']==$row['id']) ? "selected" : "" ?>><?= $row['name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>

							</div>

							<div class="from-group row">

								<div class="col-md-3">
									<label>Пациент:</label>
									<select name="user_id" class="<?= $classes['form-select'] ?>">
										<option value="">Выберите пациента</option>
										<?php foreach($db->query('SELECT * from users WHERE user_level = 15') as $row): ?>
											<option value="<?= $row['id'] ?>" <?= ( isset($_POST['user_id']) and $_POST['user_id']==$row['id']) ? "selected" : "" ?>><?= addZero($row['id'])." - ".get_full_name($row['id']) ?></option>
										<?php endforeach; ?>
									</select>
								</div>

								<div class="col-md-3">
									<label class="d-block font-weight-semibold">Статус</label>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="custom_checkbox_stacked_unchecked" name="compl_true" <?= (empty($_POST) or isset($_POST['compl_true'])) ? "checked" : "" ?>>
										<label class="custom-control-label" for="custom_checkbox_stacked_unchecked">Завершёные</label>
									</div>

									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="custom_checkbox_stacked_checked" name="compl_false" <?= (empty($_POST) or isset($_POST['compl_false'])) ? "checked" : "" ?>>
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
								vs.add_date,
								gd.name 'guide',
								vs.user_id,
								vp.item_name,
								vp.item_cost,
								vs.route_id,
								vs.direction,
								vs.laboratory,
								gd.price,
								gd.share
							FROM visit vs
								LEFT JOIN visit_price vp ON(vp.visit_id=vs.id)
								LEFT JOIN guides gd ON(gd.id=vs.guide_id)
							WHERE
								vp.item_type = 1 AND vs.add_date IS NOT NULL";
					// Обработка
					if ($_POST['route_id']) {
						$sql .= " AND vs.route_id IN (".implode(",", $_POST['route_id']).")";
					}
					if ($_POST['date_start'] and $_POST['date_end']) {
						$sql .= " AND (DATE_FORMAT(vs.add_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."')";
					}
					if ( isset($_POST['division_id']) and $_POST['division_id']) {
						$sql .= " AND vs.division_id IN (".implode(",", $_POST['division_id']).")";
					}
					if ( isset($_POST['guide_id']) and $_POST['guide_id']) {
						$sql .= " AND vs.guide_id = {$_POST['guide_id']}";
					}
					if ( isset($_POST['user_id']) and $_POST['user_id']) {
						$sql .= " AND vs.user_id = {$_POST['user_id']}";
					}
					if ( isset($_POST['direction']) and $_POST['direction']) {
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
					<div class="<?= $classes['card'] ?>">

						<div class="<?= $classes['card-header'] ?>">
							<h6 class="card-title">Направители</h6>
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
											<th style="width: 13%">Дата регистрации</th>
				                            <th>Напрвитель</th>
											<th>Id</th>
											<th>Пациент</th>
											<th>Мед услуга</th>
											<th>Регистратор</th>
											<th style="width: 10%">Тип визита</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
										<?php foreach ($db->query($sql) as $row): ?>
											<tr>
												<td><?= $i++ ?></td>
												<td><?= ($row['add_date']) ? date('d.m.y H:i', strtotime($row['add_date'])) : '<span class="text-muted">Нет данных</span>' ?></td>
												<td><?= $row['guide'] ?></td>
												<td><?= addZero($row['user_id']) ?></td>
												<td><?= get_full_name($row['user_id']) ?></td>
												<td><?= $row['item_name'] ?></td>
												<td><?= get_full_name($row['route_id']) ?></td>
												<td><?= ($row['direction']) ? "Стационарный" : "Амбулаторный" ?></td>
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

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
