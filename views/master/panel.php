<?php
require_once '../../tools/warframe.php';
$session->is_auth('master');
$header = "Панель управления";
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'head.php' ?>

<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
<script src="<?= stack("assets/js/custom.js") ?>"></script>

<body>
	<!-- Main navbar -->
	<?php include 'navbar.php' ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include 'sidebar.php' ?>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

                <div class="card border-1">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">Control Panel</h5>
				    </div>

				    <div class="card-body">

                        <div class="form-group row">

							<div class="col-md-6">

								<legend>The Settings Modules</legend>

								<div class="table-responsive">
									<table class="table table-sm table-bordered">
										<tbody>
											<?php
											try {
												$company = new stdClass();
												$comp = $db->query("SELECT * FROM company_constants WHERE const_label LIKE 'module_%'")->fetchAll(PDO::FETCH_OBJ);
												foreach ($comp as $value) {
													$company->{$value->const_label} = $value->const_value;
												}
												?>
												<tr>
													<th style="width:90%">Personal Qty</th>
													<td class="text-right">
														<div class="form-group">
															<input onkeyup="ConstChange(this)" type="number" min="2" max="1000" class="form-control" name="module_personal_qty" value="<?= (isset($company->module_personal_qty)) ? $company->module_personal_qty : 5 ?>" style="height:25.5px">
														</div>
													</td>
												</tr>
												<tr>
													<th>Laboratory</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="module_laboratory" <?= (isset($company->module_laboratory) and $company->module_laboratory) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Diagnostic</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="module_diagnostic" <?= (isset($company->module_diagnostic) and $company->module_diagnostic) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Physio</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="module_physio" <?= (isset($company->module_physio) and $company->module_physio) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Pharmacy</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="module_pharmacy" <?= (isset($company->module_pharmacy) and $company->module_pharmacy) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Bypass</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="module_bypass" <?= (isset($company->module_bypass) and $company->module_bypass) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Queue</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="module_queue" <?= (isset($company->module_queue) and $company->module_queue) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Resort</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="module_resort" <?= (isset($company->module_resort) and $company->module_resort) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>ZeTTa PACS</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="module_zetta_pacs" <?= (isset($company->module_zetta_pacs) and $company->module_zetta_pacs) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<?php
											} catch (\Exception $e) {
												echo '<tr class="text-center"><th colspan="2">Не установлена база данных</th></tr>';
											}
											?>
										</tbody>
									</table>
								</div>

							</div>


                            <div class="col-md-6">

								<legend>The Settings Configurations</legend>

								<div class="table-responsive">
									<table class="table table-sm table-bordered">
										
										<?php
										try {
											$config = new stdClass();
											$comp = $db->query("SELECT * FROM company_constants WHERE const_label LIKE 'constant_%'")->fetchAll(PDO::FETCH_OBJ);
											foreach ($comp as $value) {
												$config->{$value->const_label} = $value->const_value;
											}
											?>
											
											<tbody>
												<tr>
													<th style="width:90%">Package</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_package" <?= (isset($config->constant_package) and $config->constant_package) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Template</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_template" <?= (isset($config->constant_template) and $config->constant_template) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Wards by division</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_wards_by_division" <?= (isset($config->constant_wards_by_division) and $config->constant_wards_by_division) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Document Autosave</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_document_autosave" <?= (isset($config->constant_document_autosave) and $config->constant_document_autosave) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Registry Patient On All Division(stationar)</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_stationar_on_division" <?= (isset($config->constant_stationar_on_division) and $config->constant_stationar_on_division) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Registry Appointment (Discharge Date)</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_registry_appointment_discharge" <?= (isset($config->constant_registry_appointment_discharge) and $config->constant_registry_appointment_discharge) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
											</tbody>

											<!-- Admin -->
											<tbody>
												<tr>
													<th>Admin Delete Button (users)</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_admin_delete_button_users" <?= (isset($config->constant_admin_delete_button_users) and $config->constant_admin_delete_button_users) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Admin Delete Button (services)</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_admin_delete_button_services" <?= (isset($config->constant_admin_delete_button_services) and $config->constant_admin_delete_button_services) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Admin Delete Button (analyzes)</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_admin_delete_button_analyzes" <?= (isset($config->constant_admin_delete_button_analyzes) and $config->constant_admin_delete_button_analyzes) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Admin Delete Button (warehouses)</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_admin_delete_button_warehouses" <?= (isset($config->constant_admin_delete_button_warehouses) and $config->constant_admin_delete_button_warehouses) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
											</tbody>
											<!-- End Admin -->

											<!-- Laboratory -->
											<tbody>
												<tr>
													<th>Laboratory End All Button</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_laboratory_end_all_button" <?= (isset($config->constant_laboratory_end_all_button) and $config->constant_laboratory_end_all_button) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Laboratory End Service Button</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_laboratory_end_service_button" <?= (isset($config->constant_laboratory_end_service_button) and $config->constant_laboratory_end_service_button) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Laboratory Failure Service Button</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_laboratory_failure_service_button" <?= (isset($config->constant_laboratory_failure_service_button) and $config->constant_laboratory_failure_service_button) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
											</tbody>
											<!-- End Laboratory -->

											<!-- Card -->
											<tbody>
												<tr>
													<th>Card Stationar Balance Show</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_card_stationar_balance_show" <?= (isset($config->constant_card_stationar_balance_show) and $config->constant_card_stationar_balance_show) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Card Stationar Balance Notice</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_card_stationar_balance_notice" <?= (isset($config->constant_card_stationar_balance_notice) and $config->constant_card_stationar_balance_notice) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Card Stationar Doctor Journal Edit</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_card_stationar_journal_edit" <?= (isset($config->constant_card_stationar_journal_edit) and $config->constant_card_stationar_journal_edit) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Card Stationar Doctor Button (not grant)</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_card_stationar_doctor_button" <?= (isset($config->constant_card_stationar_doctor_button) and $config->constant_card_stationar_doctor_button) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Card Stationar Analyze Button (not grant)</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_card_stationar_analyze_button" <?= (isset($config->constant_card_stationar_analyze_button) and $config->constant_card_stationar_analyze_button) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Card Stationar Diagnostic Button (not grant)</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_card_stationar_diagnostic_button" <?= (isset($config->constant_card_stationar_diagnostic_button) and $config->constant_card_stationar_diagnostic_button) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Card Stationar Physio Button (not grant)</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_card_stationar_physio_button" <?= (isset($config->constant_card_stationar_physio_button) and $config->constant_card_stationar_physio_button) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Card Stationar Doctor Add Condition Button (grant)</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_card_stationar_condition_button" <?= (isset($config->constant_card_stationar_condition_button) and $config->constant_card_stationar_condition_button) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Card Stationar Doctor Update (Discharge Date)</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_card_stationar_update_discharge" <?= (isset($config->constant_card_stationar_update_discharge) and $config->constant_card_stationar_update_discharge) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Card Stationar Notice (Discharge Date)</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="constant_card_stationar_discharge_date_notice" <?= (isset($config->constant_card_stationar_discharge_date_notice) and $config->constant_card_stationar_discharge_date_notice) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
											</tbody>
											<!-- End Card -->

											<!-- Pharmacy -->
											
											<!-- End Pharmacy -->

											<?php
										} catch (\Exception $e) {
											echo '<tr class="text-center"><th colspan="2">Не установлена база данных</th></tr>';
										}
										?>
										
									</table>
								</div>

                            </div>

                        </div>


				    </div>

				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

    <script type="text/javascript">
		function ConstChange(input) {
			$.ajax({
				type: "POST",
				url: "<?= ajax('master/controller') ?>",
				data: Object.assign({}, { module: input.name }, $(input).serializeArray()),
				success: function (data) {
					if (data == 1) {
						new Noty({
							text: "Успешно",
							type: 'success'
						}).show();
					}else{
						new Noty({
							text: data,
							type: 'error'
						}).show();
					}
				},
			});
		}
	</script>

</body>
</html>
