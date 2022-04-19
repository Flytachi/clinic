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

								<div class="col-md-6">
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
					$Iam = "vs.status IN(3,7)";
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

							<?php 
							importModel('VisitType');
							$amb = (new VisitType)->Where("is_ambulator IS NOT NULL")->list();
							$sta = (new VisitType)->Where("is_stationar IS NOT NULL")->list();
							$Tamb = $Tsta = [];
							?>

							<div class="table-responsive">
	                            <table class="table table-hover table-sm table-bordered" id="table">
	                                <thead class="<?= $classes['table-thead'] ?>">
	                                    <tr>
											<th style="width: 50px" rowspan="2">№</th>
				                            <th rowspan="2">Отдел</th>
											<th class="text-center" rowspan="2">Кол-во пациентов</th>
											<th class="text-center" colspan="<?= count($amb)+1 ?>">Амбулаторные услуги</th>
											<th class="text-center" colspan="<?= count($sta)+1 ?>">Стационарные услуги</th>
	                                    </tr>
										<tr>
											<th class="text-center">Без типа</th>
											<?php foreach($amb as $k => $r): ?>
												<?php $Tamb[$k] = 0; ?>
												<th class="text-center"><?= $r->name ?></th>
											<?php endforeach; ?>
											<th class="text-center">Без типа</th>
											<?php foreach($sta as $k => $r): ?>
												<?php $Tsta[$k] = 0; ?>
												<th class="text-center"><?= $r->name ?></th>
											<?php endforeach; ?>
										</tr>
	                                </thead>
	                                <tbody>
										<?php $pc = $ao = $an = 0; ?>
										<?php foreach ($tb->list(1) as $row): ?>
											<tr>
												<td><?= $row->count ?></td>
												<td><?= $row->title ?></td>
												<td class="text-center">
													<?php
													$p = (new VisitServicesModel)->as("vs")->Data("COUNT(DISTINCT vs.patient_id) 'c'")
													->Where($where . " AND vs.division_id = $row->id")->get()->c;
													$pc += $p; echo number_format($p);
													?>
												</td>

												<td class="text-center">
													<?php
													$p = (new VisitServicesModel)->as("vs")->Data("COUNT(*) 'c'")->Join("visits v", "v.id=vs.visit_id")->JoinLEFT("visit_status vr", "vr.visit_id=v.id")
													->Where($where . " AND vs.division_id = $row->id AND v.direction IS NULL AND vr.id IS NULL")->get()->c;
													$ao += $p; echo number_format($p);
													?>
												</td>
												<?php foreach($amb as $k => $r): ?>
													<td class="text-center">
														<?php
														$p = (new VisitServicesModel)->as("vs")->Data("COUNT(*) 'c'")->Join("visits v", "v.id=vs.visit_id")->JoinLEFT("visit_status vr", "vr.visit_id=v.id")
														->Where($where . " AND vs.division_id = $row->id AND v.direction IS NULL AND vr.visit_type_id = $r->id")->get()->c;
														$Tamb[$k] += $p; echo number_format($p);
														?>
													</td>
												<?php endforeach; ?>

												<td class="text-center">
													<?php
													$p = (new VisitServicesModel)->as("vs")->Data("COUNT(*) 'c'")->Join("visits v", "v.id=vs.visit_id")->JoinLEFT("visit_status vr", "vr.visit_id=v.id")
													->Where($where . " AND vs.division_id = $row->id AND v.direction IS NOT NULL AND vr.id IS NULL")->get()->c;
													$an += $p; echo number_format($p);
													?>
												</td>
												<?php foreach($sta as $k => $r): ?>
													<td class="text-center">
														<?php
														$p = (new VisitServicesModel)->as("vs")->Data("COUNT(*) 'c'")->Join("visits v", "v.id=vs.visit_id")->JoinLEFT("visit_status vr", "vr.visit_id=v.id")
														->Where($where . " AND vs.division_id = $row->id AND v.direction IS NOT NULL AND vr.visit_type_id = $r->id")->get()->c;
														$Tsta[$k] += $p; echo number_format($p);
														?>
													</td>
												<?php endforeach; ?>
												
											</tr>
										<?php endforeach; ?>
										<tr class="table-secondary">
											<th class="text-right" colspan="2">Итог:</th>
											<th class="text-center"><?= number_format($pc) ?></th>
											<th class="text-center"><?= number_format($ao) ?></th>
											<?php foreach($Tamb as $r): ?>
												<th class="text-center"><?= number_format($r) ?></th>
											<?php endforeach; ?>
											<th class="text-center"><?= number_format($an) ?></th>
											<?php foreach($Tsta as $r): ?>
												<th class="text-center"><?= number_format($r) ?></th>
											<?php endforeach; ?>
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
