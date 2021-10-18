<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);
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
									<label>Дата создания:</label>
									<div class="input-group">
										<input type="text" class="<?= $classes['form-daterange'] ?>" name="add_date" value="<?= (isset($_POST['add_date'])) ? $_POST['add_date'] : '' ?>">
										<span class="input-group-append">
											<span class="input-group-text"><i class="icon-calendar22"></i></span>
										</span>
									</div>
								</div>

								<div class="col-md-3">
									<label>Пациент:</label>
									<input type="number" class="form-control" name="user_id" value="<?= (isset($_POST['user_id'])) ? $_POST['user_id'] : '' ?>">
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
					$sql = "SELECT vs.*, sc.name, vp.id 'vp_id', vs.status, vp.item_cost, (vp.price_cash + vp.price_card + vp.price_transfer) 'price' FROM visit vs LEFT JOIN service sc ON(sc.id=vs.service_id) LEFT JOIN visit_price vp ON(vs.id=vp.visit_id) WHERE vp.item_type = 1";
					// Обработка
					if ($_POST['add_date_start'] and $_POST['add_date_end']) {
						$sql .= " AND (DATE_FORMAT(vs.add_date, '%Y-%m-%d') BETWEEN '".$_POST['add_date_start']."' AND '".$_POST['add_date_end']."')";
					}
					if ( isset($_POST['user_id']) and $_POST['user_id']) {
						$sql .= " AND vs.user_id = {$_POST['user_id']}";
					}
					?>
					<div class="<?= $classes['card'] ?>">

						<div class="<?= $classes['card-header'] ?>">
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
										<tr class="<?= $classes['table-thead'] ?>">
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
												<td class="text-center">

													<?php if ($row['direction'] and $row['service_id'] != 1): ?>
														<?php if ($row['completed']): ?>
															<span style="font-size:15px;" class="badge badge-flat border-success text-success">Завершена</span>
														<?php else: ?>
															<span style="font-size:15px;" class="badge badge-flat border-secondary text-secondary">Не завершена</span>
														<?php endif; ?>
														<?php if ($row['status'] == 0): ?>
															<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Оплачивается</span>
														<?php elseif ($row['status'] == 1): ?>
															<span style="font-size:15px;" class="badge badge-flat border-orange text-orange">Ожидание</span>
														<?php elseif ($row['status'] == 2): ?>
															<span style="font-size:15px;" class="badge badge-flat border-success text-success">У специалиста</span>
														<?php else: ?>
															<span style="font-size:15px;" class="badge badge-flat border-secondary text-secondary">Закрытый</span>
														<?php endif; ?>
													<?php else: ?>	
														<?php if ($row['status'] == 0): ?>
															<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Оплачивается</span>
														<?php elseif ($row['status'] == 1): ?>
															<span style="font-size:15px;" class="badge badge-flat border-orange text-orange">Ожидание</span>
														<?php elseif ($row['status'] == 2): ?>
															<span style="font-size:15px;" class="badge badge-flat border-success text-success">У специалиста</span>
														<?php else: ?>
															<span style="font-size:15px;" class="badge badge-flat border-secondary text-secondary">Закрытый</span>
														<?php endif; ?>
													<?php endif; ?>
												</td>
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
                    $('#message').html(data);
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
