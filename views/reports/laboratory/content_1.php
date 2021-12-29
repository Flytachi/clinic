<?php
require_once '../../../tools/warframe.php';
$session->is_auth();
$header = "Отчёт лаборатории по услугам";
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

                <div class="<?= $classes['card-filter'] ?>">

                    <div class="<?= $classes['card-filter_header'] ?>">
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
										<input type="text" class="<?= $classes['form-daterange'] ?>" name="date" value="<?= ( isset($_POST['date']) ) ? $_POST['date'] : '' ?>">
										<span class="input-group-append">
											<span class="input-group-text"><i class="icon-calendar22"></i></span>
										</span>
									</div>
								</div>

								<div class="col-md-3">
									<label>Отдел:</label>
									<select name="division_id" class="<?= $classes['form-select'] ?>">
										<option value="">Любой</option>
										<?php foreach($db->query("SELECT * from divisions WHERE level = 6") as $row): ?>
											<option value="<?= $row['id'] ?>" <?= ( isset($_POST['division_id']) and $_POST['division_id'] == $row['id']) ? "selected" : "" ?>><?= $row['title'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>

								<div class="col-md-2">
									<label>Тип услуги:</label>
									<select class="<?= $classes['form-select'] ?>" name="direction">
				                        <option value="">Любой</option>
										<option value="1" <?= ( isset($_POST['direction']) and $_POST['direction']==1) ? "selected" : "" ?>>Амбулаторный</option>
										<option value="2" <?= ( isset($_POST['direction']) and $_POST['direction']==2) ? "selected" : "" ?>>Стационарный</option>
				                    </select>
								</div>

								<div class="col-md-2">
									<label>Тип статуса:</label>
									<select class="<?= $classes['form-select'] ?>" name="status">
				                        <option value="">Любой</option>
										<option value="3" <?= ( isset($_POST['status']) and $_POST['status']==3) ? "selected" : "" ?>>Не завершёные</option>
										<option value="7" <?= ( isset($_POST['status']) and $_POST['status']==7) ? "selected" : "" ?>>Завершёные</option>
				                    </select>
								</div>

								<div class="col-md-2">
									<label>Статус ордера:</label>
									<select class="<?= $classes['form-select'] ?>" name="order">
				                        <option value="">Любой</option>
										<option value="1" <?= ( isset($_POST['order']) and $_POST['order']==1) ? "selected" : "" ?>>Есть ордер</option>
										<option value="2" <?= ( isset($_POST['order']) and $_POST['order']==2) ? "selected" : "" ?>>Нет ордера</option>
				                    </select>
								</div>

							</div>

							<div class="text-right">
								<button type="submit" class="<?= $classes['card-filter_btn'] ?>"><i class="icon-search4 mr-2"></i>Поиск</button>
							</div>

						</form>

                    </div>

                </div>

				<?php if ($_POST): ?>
					<?php
					$Iam = "vs.level = 6";
					$status = "AND vs.status IN(3,7)";
					$description = "";
					$set_data = "vs.service_id, vs.service_name, COUNT(vs.id) 'qty'";
					$_POST['date_start'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[0]));
					$_POST['date_end']   = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[1]));
					$where = " AND (DATE_FORMAT(vs.accept_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."')";

					if ( isset($_POST['division_id']) and $_POST['division_id'] ){
						$where .= " AND vs.division_id = {$_POST['division_id']}";
						$description .= ", отдел ".$db->query("SELECT title FROM divisions WHERE id = {$_POST['division_id']}")->fetchColumn();
					}
					if ( isset($_POST['direction']) and $_POST['direction'] ){
						if ($_POST['direction'] == 1){
							$where .= " AND v.direction IS NULL";
							$description .= ", амбулаторные";
						}else{
							$where .= " AND v.direction IS NOT NULL";
							$description .= ", стационарные";
						}
					}
					if ( isset($_POST['status']) and $_POST['status'] ){
						switch ($_POST['status']){
							case 3:
								$description .= ", завершёные"; break;
							case 3:
								$description .= ", завершёные"; break;
						}
						$status = "AND vs.status = {$_POST['status']}";
					}
					if ( isset($_POST['order']) and $_POST['order'] ){
						if ($_POST['order'] == 1){
							$where .= " AND vo.id IS NOT NULL";
							$description .= ", с ордером";
						}else{
							$where .= " AND vo.id IS NULL";
							$description .= ", без ордера";
						}
					}

					$sql = "SELECT $set_data FROM visit_services vs LEFT JOIN visits v ON(v.id=vs.visit_id) LEFT JOIN visit_orders vo ON(v.id=vo.visit_id) WHERE $Iam $where $status GROUP BY vs.service_id ORDER BY vs.service_name ASC";
					$i=1;
					?>
					<div class="<?= $classes['card'] ?>">

						<div class="<?= $classes['card-header'] ?>">
							<h6 class="card-title">Услуги</h6>
							<div class="header-elements">
								<div class="list-icons">
									<button onclick="ExportExcel('table', 'Document','document.xls')" type="button" class="<?= $classes['btn-table'] ?>">Excel</button>
								</div>
							</div>
						</div>

						<div class="card-body">

							<div class="text-center">
								<b>Дата: </b><?= $_POST['date'] ?>,
								<b>Примечания: </b><?= substr($description, 2) ?>
							</div>

							<div class="table-responsive">
	                            <table class="table table-hover table-sm table-bordered" id="table">
	                                <thead>
	                                    <tr class="<?= $classes['table-thead'] ?>">
											<th style="width: 50px">№</th>
				                            <th>Услуга</th>
											<th style="width: 100px" class="text-right">Кол-во</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
										<?php foreach ($db->query($sql) as $row): ?>
											<tr>
												<td><?= $i++ ?></td>
												<td><?= $row['service_name'] ?></td>
												<td class="text-right"><?= number_format($row['qty']) ?></td>
											</tr>
										<?php endforeach; ?>
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
			$("#parent_id").chained("#division_id");
		});
	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
