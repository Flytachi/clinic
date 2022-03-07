<?php
require_once '../../../tools/warframe.php';
$session->is_auth();
$header = "Отчёт регистратуры по регистрации";

importModel('Patient', 'Province', 'Region');
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
									<div class="form-group">
										<label>Дата регистрации:</label>
										<div class="input-group">
											<input type="text" class="<?= $classes['form-daterange'] ?>" name="date" value="<?= ( isset($_POST['date']) ) ? $_POST['date'] : '' ?>">
											<span class="input-group-append">
												<span class="input-group-text"><i class="icon-calendar22"></i></span>
											</span>
										</div>
									</div>
									<div class="form-group">
										<label>Дата рождения (от):</label>
										<input type="number" class="form-control" name="birth_from" value="<?= ( isset($_POST['birth_from']) ) ? $_POST['birth_from'] : 1900 ?>" min="1900" max="<?= date('Y') ?>" step="1">
									</div>
								</div>
								
								<div class="col-md-3">
									<div class="form-group">
										<label>Регистратор:</label>
										<select class="<?= $classes['form-multiselect'] ?>" data-placeholder="Выбрать регистратора" name="parent_id[]" multiple="multiple">
											<?php foreach ($db->query("SELECT DISTINCT parent_id FROM patients") as $row): ?>
												<option value="<?= $row['parent_id'] ?>" <?= ( isset($_POST['parent_id']) and in_array($row['parent_id'], $_POST['parent_id'])) ? "selected" : "" ?>><?= get_full_name($row['parent_id']) ?></option>
											<?php endforeach; ?>
										</select>
									</div>
									<div class="form-group">
										<label>Дата рождения (до):</label>
										<input type="number" class="form-control" name="birth_before" value="<?= ( isset($_POST['birth_before']) ) ? $_POST['birth_before'] : date('Y') ?>" min="1900" max="<?= date('Y') ?>" step="1">
									</div>
								</div>

								<div class="col-md-3">
									<label>Область:</label>
									<select class="<?= $classes['form-multiselect'] ?>" data-placeholder="Выбрать область" name="province_id[]" multiple="multiple" onchange="CheckRegions(this)">
										<?php foreach ($db->query("SELECT DISTINCT province_id FROM patients") as $row): ?>
											<option value="<?= $row['province_id'] ?>" <?= ( isset($_POST['province_id']) and in_array($row['province_id'], $_POST['province_id'])) ? "selected" : "" ?>><?= (new Province)->byId($row['province_id'], 'name')->name ?></option>
										<?php endforeach; ?>
									</select>
								</div>

								<div class="col-md-3" id="region">
									<label>Регионы:</label>
									<select class="form-control" data-placeholder="Выбрать регион" name="region_id[]" multiple="multiple">
										<?php if( isset($_POST['province_id']) ): ?>
											<?php foreach ($db->query("SELECT DISTINCT region_id FROM patients WHERE province_id IN(".implode(",", $_POST['province_id']) .")") as $row): ?>
												<option value="<?= $row['region_id'] ?>" <?= ( isset($_POST['region_id']) and in_array($row['region_id'], $_POST['region_id'])) ? "selected" : "" ?>><?= (new Region)->byId($row['region_id'], 'name')->name ?></option>
											<?php endforeach; ?>
										<?php else: ?>
											<?php foreach ($db->query("SELECT DISTINCT region_id FROM patients") as $row): ?>
												<?php if( isset($_POST['region_id']) and in_array($row['region_id'], $_POST['region_id']) ): ?>
													<option value="<?= $row['region_id'] ?>" selected><?= $row['region'] ?></option>
												<?php endif; ?>
											<?php endforeach; ?>
										<?php endif; ?>
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
					$_POST['date_start'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[0]));
					$_POST['date_end'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[1]));
					$where = "(DATE_FORMAT(add_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."')";
					if( isset($_POST['parent_id']) ) $where .= " AND parent_id IN(".implode(",", $_POST['parent_id']) .")";
					if( isset($_POST['province_id']) ) $where .= " AND province_id IN(".implode(",", $_POST['province_id']) .")";
					if( isset($_POST['region_id']) ) $where .= " AND region_id IN(".implode(",", $_POST['region_id']) .")";
					if( isset($_POST['birth_from']) and isset($_POST['birth_before']) ) $where .= " AND (DATE_FORMAT(birth_date, '%Y') BETWEEN '".$_POST['birth_from']."' AND '".$_POST['birth_before']."')";

					$tb = new Patient();
					$tb->Where($where)->Order('add_date');
					?>
					<div class="<?= $classes['card'] ?>">

						<div class="<?= $classes['card-header'] ?>">
							<h6 class="card-title">Пациенты</h6>
							<div class="header-elements">
								<div class="list-icons">
									<button onclick="ExportExcel('table', 'Document','document.xls')" type="button" class="<?= $classes['btn-table'] ?>">Excel</button>
								</div>
							</div>
						</div>

						<div class="card-body">

							<div class="table-responsive">
	                            <table class="table table-hover table-sm table-bordered datatable-basic" id="table">
	                                <thead class="<?= $classes['table-thead'] ?>">
	                                    <tr>
											<th style="width: 50px">№</th>
											<th style="width: 13%">Дата регистрации</th>
											<th>Id</th>
				                            <th>FIO</th>
											<th>Область</th>
											<th>Регион</th>
											<th>Регистратор</th>
											<th style="width: 10%">Дата рождения</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
										<?php foreach ($tb->list(1) as $row): ?>
											<tr>
												<th><?= $row->count ?></th>
												<th><?= date_f($row->add_date, 1) ?></th>
												<th><?= addZero($row->id) ?></th>
												<th><?= patient_name($row)  ?></th>
												<th><?= (new Province)->byId($row->province_id, 'name')->name ?></th>
												<th><?= (new Region)->byId($row->region_id, 'name')->name ?></th>
												<th><?= get_full_name($row->parent_id) ?></th>
												<th><?= date_f($row->birth_date) ?></th>
											</tr>
										<?php endforeach; ?>
	                                </tbody>
									<?php if(isset($row->count)): ?>
										<tfooter>
											<tr class="table-secondary strong">
												<td colspan="2">Общее колличество: <?= $row->count ?></td>
											</tr>
										</tfooter>
									<?php endif; ?>
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

		function CheckRegions(params) {
			var selected = params.selectedOptions;
			var items = [];
			for (let i = 0; i < selected.length; i++) {
				items.push(selected[i].value);
			}

			$.ajax({
				type: "GET",
				url: "<?= ajax('options/regions') ?>",
				data: {
					province: items,
				},
				success: function (result) {
					if (result.trim() == "") {
						document.querySelector("#region").disabled = false;
					} else {
						document.querySelector("#region").disabled = true;
						document.querySelector("#region").innerHTML = result;
					}
				},
			});
		}

	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
