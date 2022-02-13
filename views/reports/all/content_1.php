<?php
require_once '../../../tools/warframe.php';
$session->is_auth();
$header = "Общий отчёт по проведённым услугам";
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
                        <h6 class="card-title">Фильтр</h6>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a class="list-icons-item" data-action="collapse"></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">

						<form action="" method="post">

							<div class="form-group row">

								<div class="col-md-6">
									<label>Отдел:</label>
									<select data-placeholder="Выберите отдел" name="division_id[]" class="<?= $classes['form-multiselect'] ?>" multiple="multiple" required>
										<?php foreach ($PERSONAL as $key => $value): ?>
                                            <?php if(in_array($key, [5,6,10,12])): ?>
                                                <option value="<?= $key ?>"<?= (isset($_POST['division_id']) and in_array($key, $_POST['division_id'])) ? 'selected': '' ?>><?= $value ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
									</select>
								</div>

								<div class="col-md-3">
									<label>Дата принятия:</label>
									<div class="input-group">
										<input type="text" class="<?= $classes['form-daterange'] ?>" name="date" value="<?= ( isset($_POST['date']) ) ? $_POST['date'] : '' ?>">
										<span class="input-group-append">
											<span class="input-group-text"><i class="icon-calendar22"></i></span>
										</span>
									</div>
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
					$Iam = "vs.status IN(3,7) AND vs.service_id != 1";
					$_POST['date_start'] = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[0]));
					$_POST['date_end']   = date('Y-m-d', strtotime(explode(' - ', $_POST['date'])[1]));
					$where = $Iam . " AND (DATE_FORMAT(vs.accept_date, '%Y-%m-%d') BETWEEN '".$_POST['date_start']."' AND '".$_POST['date_end']."')";
					
					$tb = new DivisionModel;
					$tb->Where("level IN(" . implode(",", $_POST['division_id']) . ")");
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

							<div class="table-responsive">
	                            <table class="table table-hover table-sm table-bordered" id="table">
	                                <thead>
	                                    <tr class="<?= $classes['table-thead'] ?>">
											<th style="width: 50px">№</th>
				                            <th>Отдел</th>
											<th class="text-center">Кол-во пациентов</th>
											<th class="text-center">Амб. услуги(ордер)</th>
											<th class="text-center">Амб. услуги(нет ордера)</th>
											<th class="text-center">Стац. услуги(ордер)</th>
											<th class="text-center">Стац. услуги(нет ордера)</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
										<?php foreach ($tb->list(1) as $row): ?>
											<tr>
												<td><?= $row->count ?></td>
												<td><?= $row->title ?></td>
												<td class="text-center">
													<?=
													number_format(
														(new VisitServicesModel)->as("vs")->Data("DISTINCT COUNT(vs.user_id) 'c'")
														->Where($where . " AND vs.division_id = $row->id")->get()->c
													)
													?>
												</td>
												<td class="text-center">
													<?=
													number_format(
														(new VisitServicesModel)->as("vs")->Data("COUNT(*) 'c'")
														->Join("visits v ON(v.id=vs.visit_id)")->JoinLEFT("visit_orders vr ON(vr.visit_id=v.id)")
														->Where($where . " AND vs.division_id = $row->id AND v.direction IS NULL AND vr.id IS NOT NULL")->get()->c
													)
													?>
												</td>
												<td class="text-center">
													<?=
													number_format(
														(new VisitServicesModel)->as("vs")->Data("COUNT(*) 'c'")
														->Join("visits v ON(v.id=vs.visit_id)")->JoinLEFT("visit_orders vr ON(vr.visit_id=v.id)")
														->Where($where . " AND vs.division_id = $row->id AND v.direction IS NULL AND vr.id IS NULL")->get()->c
													)
													?>
												</td>
												<td class="text-center">
													<?=
													number_format(
														(new VisitServicesModel)->as("vs")->Data("COUNT(*) 'c'")
														->Join("visits v ON(v.id=vs.visit_id)")->JoinLEFT("visit_orders vr ON(vr.visit_id=v.id)")
														->Where($where . " AND vs.division_id = $row->id AND v.direction IS NOT NULL AND vr.id IS NOT NULL")->get()->c
													)
													?>
												</td>
												<td class="text-center">
													<?=
													number_format(
														(new VisitServicesModel)->as("vs")->Data("COUNT(*) 'c'")
														->Join("visits v ON(v.id=vs.visit_id)")->JoinLEFT("visit_orders vr ON(vr.visit_id=v.id)")
														->Where($where . " AND vs.division_id = $row->id AND v.direction IS NOT NULL AND vr.id IS NULL")->get()->c
													)
													?>
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
		$(function(){
			$("#parent_id").chained("#division_id");
		});
	</script>

    <!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
