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
									<label>Пациент:</label>
									<select name="user_id" class="<?= $classes['form-select'] ?>">
										<option value="">Выберите пациента</option>
										<?php foreach ($db->query("SELECT * from users WHERE user_level = 15 ORDER BY id DESC") as $row): ?>
											<option value="<?= $row['id'] ?>" <?= ($_POST['user_id']==$row['id']) ? "selected" : "" ?>><?= addZero($row['id'])." - ".get_full_name($row['id']) ?></option>
										<?php endforeach; ?>
									</select>
								</div>

								<div class="col-md-3">
									<label class="d-block font-weight-semibold">Статус</label>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="custom_checkbox_stacked_unchecked" name="status_true" <?= (!$_POST or $_POST['status_true']) ? "checked" : "" ?>>
										<label class="custom-control-label" for="custom_checkbox_stacked_unchecked">Активный</label>
									</div>

									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="custom_checkbox_stacked_checked" name="status_false" <?= (!$_POST or $_POST['status_false']) ? "checked" : "" ?>>
										<label class="custom-control-label" for="custom_checkbox_stacked_checked">Пассивный</label>
									</div>
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
					$sql = "SELECT * FROM users us WHERE us.user_level = 15";
					if ($_POST['user_id']) {
						$sql .= " AND us.id = {$_POST['user_id']}";
					}
					if (!$_POST['status_true'] or !$_POST['status_false']) {
						if ($_POST['status_true']) {
							$sql .= " AND us.status IS NOT NULL";
						}
						if ($_POST['status_false']) {
							$sql .= " AND us.status IS NULL";
						}
					}
					?>
					<div class="<?= $classes['card'] ?>">

						<div class="<?= $classes['card-header'] ?>">
							<h6 class="card-title">Users</h6>
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
											<th style="width: 7%">ID</th>
											<th>ФИО</th>
											<th>Регистратор</th>
											<th>Дата регистрации</th>
											<th class="text-center">Status 1</th>
											<th class="text-center">Status 2</th>
											<th class="text-center">Status</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($db->query($sql." ORDER BY id DESC") as $row): ?>
											<tr>
												<td><?= addZero($row['id']) ?></td>
												<td><?= get_full_name($row['id']); ?></td>
												<td><?= get_full_name($row['parent_id']) ?></td>
												<td><?= date('d.m.Y H:i', strtotime($row['add_date'])) ?></td>
												<?php if ($stm_dr = $db->query("SELECT direction, status FROM visit WHERE (completed IS NULL OR priced_date IS NULL) AND user_id={$row['id']} AND status NOT IN (5,6) ORDER BY add_date ASC")->fetch()): ?>
													<?php if ($stm_dr['direction']): ?>
														<td>
															<span style="font-size:15px;" class="badge badge-flat border-danger text-danger-600">Стационарный</span>
														</td>
														<td>
															<?php if ($stm_dr['status'] == 0): ?>
																<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Оплачивается</span>
															<?php elseif ($stm_dr['status'] == 1): ?>
																<span style="font-size:15px;" class="badge badge-flat border-success text-success">Размещён</span>
															<?php elseif ($stm_dr['status'] == 2): ?>
																<span style="font-size:15px;" class="badge badge-flat border-success text-success">Активный</span>
															<?php else: ?>
																<span style="font-size:15px;" class="badge badge-flat border-secondary text-secondary">Закрытый</span>
															<?php endif; ?>
														</td>
													<?php else: ?>
														<td>
															<span style="font-size:15px;" class="badge badge-flat border-primary text-primary">Амбулаторный</span>
														</td>
														<td>
															<?php if ($stm_dr['status'] == 0): ?>
																<span style="font-size:15px;" class="badge badge-flat border-danger text-danger">Оплачивается</span>
															<?php elseif ($stm_dr['status'] == 1): ?>
																<span style="font-size:15px;" class="badge badge-flat border-orange text-orange">Ожидание</span>
															<?php elseif ($stm_dr['status'] == 2): ?>
																<span style="font-size:15px;" class="badge badge-flat border-success text-success">У специалиста</span>
															<?php else: ?>
																<span style="font-size:15px;" class="badge badge-flat border-secondary text-secondary">Закрытый</span>
															<?php endif; ?>
														</td>
													<?php endif; ?>
												<?php else: ?>
													<td>
														<?php if ($row['status']): ?>
															<span style="font-size:15px;" class="badge badge-flat border-danger text-danger-600">Status error</span>
														<?php else: ?>
															<span style="font-size:15px;" class="badge badge-flat border-grey text-grey-600">Закрытый</span>
														<?php endif; ?>
													</td>
													<td>
														<span style="font-size:15px;" class="badge badge-flat border-grey text-grey-300">Не активный</span>
													</td>
												<?php endif; ?>
												<td class="text-center">
													<div class="list-icons">
														<div class="dropdown">
															<?php if ($row['status']): ?>
																<a href="#" id="status_change_<?= $row['id'] ?>" class="badge bg-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Active</a>
															<?php else: ?>
																<a href="#" id="status_change_<?= $row['id'] ?>" class="badge bg-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Pasive</a>
															<?php endif; ?>

															<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(74px, 21px, 0px);">
																<a onclick="Change(<?= $row['id'] ?>, 1)" class="dropdown-item">
																	<span class="badge badge-mark mr-2 border-success"></span>
																	Active
																</a>
																<a onclick="Change(<?= $row['id'] ?>, 0)" class="dropdown-item">
																	<span class="badge badge-mark mr-2 border-secondary"></span>
																	Pasive
																</a>
															</div>
														</div>
														<a href="<?= del_url($row['id'], 'PatientForm') ?>" onclick="return confirm('Вы уверены что хотите удалить пациета?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
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
        function Change(id, stat = null) {
            event.preventDefault();
            $.ajax({
				type: "GET",
				url: "<?= ajax('admin_control_user') ?>",
				data: { id:id, status: stat },
				success: function (data) {
                    if (data) {
						var badge = document.getElementById(`status_change_${id}`);
						if (data == 1) {
							badge.className = "badge bg-success dropdown-toggle";
							badge.innerHTML = "Active";
							badge.onclick = `Change(${id}, 1)`;
						}else if (data == 0) {
							badge.className = "badge bg-secondary dropdown-toggle";
							badge.innerHTML = "Pasive";
							badge.onclick = `Change(${id}, 0)`;
						}
                    }
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
