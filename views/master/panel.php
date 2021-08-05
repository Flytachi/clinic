<?php
require_once '../../tools/warframe.php';
require_once '../../tools/Console/command.php';
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
													<th>Diet</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="ConstChange(this)" type="checkbox" class="swit bg-danger" name="module_diet" <?= (isset($company->module_diet) and $company->module_diet) ? "checked" : "" ?>>
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
										<tbody>
											<?php
											try {
												$config = new stdClass();
												$comp = $db->query("SELECT * FROM company_constants WHERE const_label LIKE 'constant_%'")->fetchAll(PDO::FETCH_OBJ);
												foreach ($comp as $value) {
													$config->{$value->const_label} = $value->const_value;
												}
												?>
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

												<!-- Laboratory -->
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
												<?php
											} catch (\Exception $e) {
												echo '<tr class="text-center"><th colspan="2">Не установлена база данных</th></tr>';
											}
											?>
										</tbody>
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
					console.log(data);
					if (data == 1) {
						new Noty({
							text: "Успешно",
							type: 'success'
						}).show();
					}
				},
			});
		}
	</script>

</body>
</html>
