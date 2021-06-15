<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);
$header = "Визиты";
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
											<option value="<?= $row['id'] ?>" <?= ( isset($_POST['user_id']) and $_POST['user_id']==$row['id']) ? "selected" : "" ?>><?= addZero($row['id'])." - ".get_full_name($row['id']) ?></option>
										<?php endforeach; ?>
									</select>
								</div>

								<div class="col-md-3">
									<label class="d-block font-weight-semibold">Статус</label>
									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="custom_checkbox_stacked_unchecked" name="status_true" <?= (!$_POST or (isset($_POST['status_true']) and $_POST['status_true']) ) ? "checked" : "" ?>>
										<label class="custom-control-label" for="custom_checkbox_stacked_unchecked">Активный</label>
									</div>

									<div class="custom-control custom-checkbox">
										<input type="checkbox" class="custom-control-input" id="custom_checkbox_stacked_checked" name="status_false" <?= (!$_POST or (isset($_POST['status_false']) and $_POST['status_false']) ) ? "checked" : "" ?>>
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
					$sql = "user_level = 15";
					if ( isset($_POST['user_id']) and $_POST['user_id']) {
						$sql .= " AND id = {$_POST['user_id']}";
					}
					if ( isset($_POST['status_true']) or isset($_POST['status_false']) ) {
						if ( isset($_POST['status_true']) and $_POST['status_true'] and !isset($_POST['status_false']) ) {
							$sql .= " AND status IS NOT NULL";
						}
						elseif ( (isset($_POST['status_false']) and $_POST['status_false']) and !isset($_POST['status_true']) ) {
							$sql .= " AND status IS NULL";
						}
					}
					$tb = new Table($db, "users");
					$search = $tb->get_serch();
					$where_search = array(
						$sql, 
						$sql." AND (username LIKE '%$search%' OR LOWER(CONCAT_WS(' ', last_name, first_name, father_name)) LIKE LOWER('%$search%'))"
					);
					$tb->where_or_serch($where_search)->set_limit(20);
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
										<tr class="<?= $classes['table-thead'] ?>">
											<th style="width: 7%">ID</th>
											<th>ФИО</th>
											<th>Регистратор</th>
											<th>Дата регистрации</th>
											<th class="text-center">Status</th>
											<th class="text-center">Visit status</th>
											<th class="text-center">Status</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($tb->get_table() as $row): ?>
											<tr>
												<td><?= addZero($row->id) ?></td>
												<td><?= get_full_name($row->id) ?></td>
												<td><?= get_full_name($row->parent_id) ?></td>
												<td><?= date_f($row->add_date, 1) ?></td>

												<td class="text-center">
												<?php if ($row->status): ?>
													<span style="font-size:15px;" class="badge badge-flat border-success text-success">Активный</span>
												<?php else: ?>
													<span style="font-size:15px;" class="badge badge-flat border-grey text-grey-600">Закрытый</span>
												<?php endif; ?>
												</td>
												<td class="text-center">	
													<?php $stm_dr = $db->query("SELECT id, direction FROM visits WHERE user_id = $row->id AND completed IS NULL")->fetch() ?>
													<?php if ( isset($stm_dr['id']) ): ?>
														<?php if ($stm_dr['direction']): ?>
															<span style="font-size:15px;" class="badge badge-flat border-danger text-danger-600">Стационарный</span>
														<?php else: ?>
															<span style="font-size:15px;" class="badge badge-flat border-primary text-primary">Амбулаторный</span>
														<?php endif; ?>
													<?php else: ?>
														<span style="font-size:15px;" class="badge badge-flat border-grey text-grey-300">Нет данных</span>
													<?php endif; ?>
												</td>
												
												<td class="text-center">
													<div class="list-icons">
														<div class="dropdown">
															<?php if ($row->status): ?>
																<a href="#" id="status_change_<?= $row->id ?>" class="badge bg-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Active</a>
															<?php else: ?>
																<a href="#" id="status_change_<?= $row->id ?>" class="badge bg-secondary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Pasive</a>
															<?php endif; ?>

															<div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(74px, 21px, 0px);">
																<a onclick="Change(<?= $row->id ?>, 1)" class="dropdown-item">
																	<span class="badge badge-mark mr-2 border-success"></span>
																	Active
																</a>
																<a onclick="Change(<?= $row->id ?>, 0)" class="dropdown-item">
																	<span class="badge badge-mark mr-2 border-secondary"></span>
																	Pasive
																</a>
															</div>
														</div>
														<a href="<?= del_url($row->id, 'PatientForm') ?>" onclick="return confirm('Вы уверены что хотите удалить пациета?')" class="list-icons-item text-danger-600"><i class="icon-trash"></i></a>
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
