<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);
$header = "Настройки";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switch.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js") ?>"></script>

<script src="<?= stack("global_assets/js/demo_pages/form_inputs.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_layouts.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_select2.js") ?>"></script>

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
				        <h5 class="card-title">Настройки</h5>
				        <div class="header-elements">
				            <div class="list-icons">
				                <a class="list-icons-item" data-action="collapse"></a>
				            </div>
				        </div>
				    </div>

				    <div class="card-body">

						<?php
						if( isset($_SESSION['message']) ){
				            echo $_SESSION['message'];
				            unset($_SESSION['message']);
				        }
						$comp = $db->query("SELECT * FROM company_constants")->fetchAll();
						foreach ($comp as $value) {
							$company[$value['const_label']] = $value['const_value'];
						}
						?>

						<form action="<?= viv('admin/admin_model') ?>" method="post" enctype="multipart/form-data">

							<fieldset class="mb-3">
								<legend class="text-uppercase font-size-sm font-weight-bold">Печать</legend>

								<div class="form-group row">
									<div class="col-form-label col-lg-2">
										<img class="border-1" src="<?= (isset($company['print_header_logotype'])) ? $company['print_header_logotype'] : '' ?>" width="200" height="60">
									</div>
									<label class="col-form-label col-lg-1 font-weight-bold">Иконка печати:</label>
									<div class="col-lg-9">
										<input type="file" name="print_header_logotype" class="form-control">
									</div>
								</div>

								<div class="form-group row">
									<label class="col-form-label col-lg-1 font-weight-bold">Заглавие:</label>
									<div class="col-lg-3">
										<input type="text" name="print_header_title" value="<?= (isset($company['print_header_title'])) ? $company['print_header_title'] : '' ?>" placeholder="Введите заглавие" class="form-control">
									</div>
									<label class="col-form-label col-lg-1 font-weight-bold">Адрес:</label>
									<div class="col-lg-3">
										<input type="text" name="print_header_address" value="<?= (isset($company['print_header_address'])) ? $company['print_header_address'] : '' ?>" placeholder="Введите адрес" class="form-control">
									</div>
									<label class="col-form-label col-lg-1 font-weight-bold">Телефон:</label>
									<div class="col-lg-3">
										<input type="text" name="print_header_phones" value="<?= (isset($company['print_header_phones'])) ? $company['print_header_phones'] : '' ?>" placeholder="Введите телефон" class="form-control">
									</div>
								</div>

							</fieldset>

							<div class="text-right">
								<button type="submit" class="btn">Send</button>
							</div>

						</form>

				    </div>

					<div class="card-body">

						<form action="<?= viv('admin/admin_model') ?>" method="post">

							<fieldset class="mb-3">

								<div class="form-group">
									<label>Резидент (процент):</label>
									<input type="number" name="const_foreigner_sale" value="<?= $company['const_foreigner_sale'] ?>" placeholder="Введите процент" class="form-control">
								</div>

							</fieldset>

							<div class="text-right">
								<button type="submit" class="btn">Send</button>
							</div>

						</form>

				    </div>

					
					<?php if(module('module_diet')): ?>
						<div class="card-body">

							<form action="<?= viv('admin/admin_model') ?>" method="post">

								<button onclick="AddinputTime()" type="button" class="btn btn-outline-success btn-sm"><i class="icon-plus22 mr-2"></i>Добавить время</button>
								<fieldset class="mb-3">

									<legend><b>Время для диеты:</b></legend>
									<div class="form-group row" id="time_div">
										<?php if( isset($company['const_diet_time']) ): ?>
											<?php foreach (json_decode($company['const_diet_time']) as $time_key => $value): ?>
												<div class="col-md-3" id="time_input_<?= $time_key ?>">
													<div class="form-group-feedback form-group-feedback-right">
														<input type="time" name="const_diet_time[<?= $time_key ?>]" class="form-control" value="<?= $value ?>" required>
														<div class="form-control-feedback text-danger">
															<i class="icon-minus-circle2" onclick="$('#time_input_<?= $time_key ?>').remove();"></i>
														</div>
													</div>
												</div>
											<?php endforeach; ?>
										<?php endif; ?>
									</div>

								</fieldset>

								<div class="text-right">
									<button type="submit" class="btn">Send</button>
								</div>

							</form>

						</div>
					<?php endif; ?>

				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<script type="text/javascript">
		let i = Number("<?= (isset($time_key)) ? $time_key + 1 : 0 ?>");
		function AddinputTime(time = null) {
			$('#time_div').append(`
				<div class="col-md-3" id="time_input_${i}">
					<div class="form-group-feedback form-group-feedback-right">
						<input type="time" name="const_diet_time[${i}]" class="form-control" value="${time}" required>
						<div class="form-control-feedback text-danger">
							<i class="icon-minus-circle2" onclick="$('#time_input_${i}').remove();"></i>
						</div>
					</div>
				</div>
			`);
			i++;
		}
	</script>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
