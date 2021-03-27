<?php
require_once '../../tools/warframe.php';
is_auth(1);
$header = "Визиты";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>

<script src="<?= stack('global_assets/js/plugins/pickers/daterangepicker.js') ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/selects/bootstrap_multiselect.js") ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/anytime.min.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/picker.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/picker.date.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/picker.time.js') ?>"></script>
<script src="<?= stack('global_assets/js/plugins/pickers/pickadate/legacy.js') ?>"></script>

<script src="<?= stack("global_assets/js/plugins/tables/datatables/datatables.min.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/datatables_basic.js") ?>"></script>
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
									<label>Дата создания:</label>
									<div class="input-group">
										<input type="text" class="form-control daterange-locale" name="add_date" value="<?= $_POST['add_date'] ?>">
										<span class="input-group-append">
											<span class="input-group-text"><i class="icon-calendar22"></i></span>
										</span>
									</div>
								</div>

								<div class="col-md-3">
									<label>Пациент:</label>
									<select name="user_id" class="form-control form-control-select2" data-fouc>
										<option value="">Выберите пациента</option>
										<?php foreach ($db->query("SELECT * from users WHERE user_level = 15") as $row): ?>
											<option value="<?= $row['id'] ?>" <?= ($_POST['user_id']==$row['id']) ? "selected" : "" ?>><?= addZero($row['id'])." - ".get_full_name($row['id']) ?></option>
										<?php endforeach; ?>
									</select>
								</div>

								<div class="col-md-3">
									<label>Отдел:</label>
									<select id="division" name="division_id" class="form-control form-control-select2" data-fouc>
									   <option value="">Выберите отдел</option>
									   <optgroup label="Врачи">
				                           <?php foreach ($db->query("SELECT * from division WHERE level = 5") as $row): ?>
				                               <option value="<?= $row['id'] ?>" <?= ($_POST['division_id']==$row['id']) ? "selected" : "" ?>><?= $row['title'] ?></option>
				                           <?php endforeach; ?>
				                       </optgroup>
				                       <optgroup label="Диогностика">
										   <?php foreach ($db->query("SELECT * from division WHERE level = 10 AND (assist IS NULL OR assist = 1)") as $row): ?>
											   <option value="<?= $row['id'] ?>" <?= ($_POST['division_id']==$row['id']) ? "selected" : "" ?>><?= $row['title'] ?></option>
										   <?php endforeach; ?>
				                       </optgroup>
				                       <optgroup label="Лаборатория">
				                           <?php foreach ($db->query("SELECT * from division WHERE level = 6") as $row): ?>
				                               <option value="<?= $row['id'] ?>" <?= ($_POST['division_id']==$row['id']) ? "selected" : "" ?>><?= $row['title'] ?></option>
				                           <?php endforeach; ?>
				                       </optgroup>
				                       <optgroup label="Остальные">
				                           <?php foreach ($db->query("SELECT * from division WHERE level IN (12, 13) AND (assist IS NULL OR assist = 1)") as $row): ?>
				                               <option value="<?= $row['id'] ?>" <?= ($_POST['division_id']==$row['id']) ? "selected" : "" ?>><?= $row['title'] ?></option>
				                           <?php endforeach; ?>
				                       </optgroup>
									</select>
								</div>

								<div class="col-md-3">
									<label>Услуга:</label>
									<select id="service" name="service_id" class="form-control form-control-select2" data-fouc>
										<option value="">Выберите услугу</option>
										<?php foreach ($db->query("SELECT * from service WHERE 1") as $row): ?>
											<option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>" <?= ($_POST['service_id']==$row['id']) ? "selected" : "" ?>><?= $row['name'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>

							</div>

							<div class="from-group row">

								<div class="col-md-3">
									<label>Тип визита:</label>
									<select class="form-control form-control-select2" name="direction" data-fouc>
				                        <option value="">Выберите тип визита</option>
										<option value="1" <?= ($_POST['direction']==1) ? "selected" : "" ?>>Амбулаторный</option>
										<option value="2" <?= ($_POST['direction']==2) ? "selected" : "" ?>>Стационарный</option>
				                    </select>
								</div>

							</div>

							<div class="text-right">
								<button type="submit" class="btn btn-outline-info"><i class="icon-search4 mr-2"></i>Поиск</button>
							</div>


						</form>

                    </div>

                </div>

				<div id="message"></div>

				<?php if ($_POST): ?>
					<?php
					$_POST['add_date_start'] = date('Y-m-d', strtotime(explode(' - ', $_POST['add_date'])[0]));
					$_POST['add_date_end'] = date('Y-m-d', strtotime(explode(' - ', $_POST['add_date'])[1]));
					$sql = "SELECT vs.*, sc.name, vp.id 'vp_id', vs.status, vp.item_cost, (vp.price_cash + vp.price_card + vp.price_transfer) 'price' FROM visit vs LEFT JOIN service sc ON(sc.id=vs.service_id) LEFT JOIN visit_price vp ON(vs.id=vp.visit_id) WHERE vs.id IS NOT NULL";
					// Обработка
					if ($_POST['add_date_start'] and $_POST['add_date_end']) {
						$sql .= " AND (DATE_FORMAT(vs.add_date, '%Y-%m-%d') BETWEEN '".$_POST['add_date_start']."' AND '".$_POST['add_date_end']."')";
					}
					if ($_POST['user_id']) {
						$sql .= " AND vs.user_id = {$_POST['user_id']}";
					}
					if ($_POST['division_id']) {
						$sql .= " AND vs.division_id = {$_POST['division_id']}";
					}
					if ($_POST['service_id']) {
						$sql .= " AND vs.service_id = {$_POST['service_id']}";
					}
					if ($_POST['direction']) {
						$sql .= ($_POST['direction']==1) ? " AND vs.direction IS NULL" : " AND vs.direction IS NOT NULL";
					}
					?>
					<div class="card border-1 border-info">

						<div class="card-header text-dark header-elements-inline alpha-info">
							<h6 class="card-title">Visits</h6>
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
											<th style="width: 7%">Visit_id</th>
											<th>User</th>
											<th>Route</th>
											<th>Service</th>
											<th class="text-right">Cost</th>
											<th class="text-center">Type</th>
											<th class="text-center">Status</th>
											<th class="text-right" style="width: 100px">Action</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($db->query($sql) as $row): ?>
											<tr id="TR_<?= $row['id'] ?>">
												<td><?= $row['id'] ?></td>
												<td><?= addZero($row['user_id']) ?> / <?= get_full_name($row['user_id']); ?></td>
												<td><?= addZero($row['route_id']) ?> / <?= get_full_name($row['route_id']); ?></td>
												<td><?= $row['name'] ?></td>
												<td class="text-right">
													<?= number_format($row['item_cost'], 1) ?><br>
													<?php if ($row['price'] > 0): ?>
														<span class="text-success"><?= number_format($row['price'], 1) ?></span>
													<?php else: ?>
														<span class="text-danger"><?= number_format($row['price'], 1) ?></span>
													<?php endif; ?>
												</td>
												<td class="text-center"><?= ($row['direction']) ? '<span class="badge badge-danger">STA</span>' : '<span class="badge badge-primary">AMB</span>' ?></td>
												<td class="text-center"><?= $row['status'] ?></td>
												<td class="text-right">
													<div class="list-icons">
														<a onclick="Delete('<?= del_url($row['id'], 'VisitModel') ?>', '#TR_<?= $row['id'] ?>')" href="" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
													</div>
												</td>
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
        function Delete(url, tr) {
            event.preventDefault();
            $.ajax({
				type: "GET",
				url: url,
				success: function (data) {
                    // $('#message').html(data);
                    $(tr).css("background-color", "rgb(244, 67, 54)");
                    $(tr).css("color", "white");
                    $(tr).fadeOut(900, function() {
                        $(tr).remove();
                    });
				},
			});
        }
		$(function(){
			$("#service").chained("#division");
		});
    </script>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
