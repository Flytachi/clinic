<?php
require_once '../../tools/warframe.php';
$session->is_auth(3);
$header = "Настройки";
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
						?>

						<form action="<?= ajax('manager/config') ?>" method="post" enctype="multipart/form-data">

							<fieldset class="mb-3">
								<legend class="text-uppercase font-size-sm font-weight-bold">Печать</legend>

								<div class="form-group row">
									<label class="col-form-label col-lg-1 font-weight-bold">Заглавие:</label>
									<div class="col-lg-3">
										<input type="text" name="constant_print_header_title" value="<?= config("print_header_title") ?>" placeholder="Введите заглавие" class="form-control">
									</div>
									<label class="col-form-label col-lg-1 font-weight-bold">Адрес:</label>
									<div class="col-lg-3">
										<input type="text" name="constant_print_header_address" value="<?= config("print_header_address") ?>" placeholder="Введите адрес" class="form-control">
									</div>
									<label class="col-form-label col-lg-1 font-weight-bold">Телефон:</label>
									<div class="col-lg-3">
										<input type="text" name="constant_print_header_phones" value="<?= config("print_header_phones") ?>" placeholder="Введите телефон" class="form-control">
									</div>
								</div>
								
							</fieldset>

							<fieldset class="mb-3">
								<legend class="text-uppercase font-size-sm font-weight-bold">Касса</legend>

								<div class="form-group row">

									<div class="col-md-6">

										<label class="font-weight-bold">Пропускная цена(Амбулатор):</label>
										<div class="row">
											<label class="col-form-label col-lg-2 font-weight-bold">От:</label>
											<div class="col-lg-4">
												<input type="text" name="constant_throughput_ambulator_from" value="<?= number_format(config("throughput_ambulator_from")) ?>" placeholder="Введите сумму" class="form-control input-price">
											</div>
											<label class="col-form-label col-lg-2 font-weight-bold">До:</label>
											<div class="col-lg-4">
												<input type="text" name="constant_throughput_ambulator_before" value="<?= number_format(config("throughput_ambulator_before")) ?>" placeholder="Введите сумму" class="form-control input-price">
											</div>
										</div>

									</div>

									<div class="col-md-6">

										<label class="font-weight-bold">Пропускная цена(Стационар):</label>
										<div class="row">
											<label class="col-form-label col-lg-2 font-weight-bold">От:</label>
											<div class="col-lg-4">
												<input type="text" name="constant_throughput_stationar_from" value="<?= number_format(config("throughput_stationar_from")) ?>" placeholder="Введите сумму" class="form-control input-price">
											</div>
											<label class="col-form-label col-lg-2 font-weight-bold">До:</label>
											<div class="col-lg-4">
												<input type="text" name="constant_throughput_stationar_before" value="<?= number_format(config("throughput_stationar_before")) ?>" placeholder="Введите сумму" class="form-control input-price">
											</div>
										</div>

									</div>

									
								</div>

							</fieldset>

							<?php if(module('module_zetta_pacs')): ?>
								<fieldset class="mb-3">
									<legend class="text-uppercase font-size-sm font-weight-bold">ZettaPacs</legend>

									<div class="form-group row">

										<label class="col-form-label col-lg-1 font-weight-bold">Ip:</label>
										<div class="col-lg-3">
											<input type="text" name="constant_zetta_pacs_IP" value="<?= config("zetta_pacs_IP") ?>" placeholder="Введите ip" class="form-control">
										</div>

										<label class="col-form-label col-lg-1 font-weight-bold">LICD:</label>
										<div class="col-lg-3">
											<input type="text" name="constant_zetta_pacs_LICD" value="<?= config("zetta_pacs_LICD") ?>" placeholder="Введите LICD" class="form-control">
										</div>

										<label class="col-form-label col-lg-1 font-weight-bold">VTYPE:</label>
										<div class="col-lg-3">
											<input type="text" name="constant_zetta_pacs_VTYPE" value="<?= config("zetta_pacs_VTYPE") ?>" placeholder="Введите VTYPE" class="form-control">
										</div>

									</div>

								</fieldset>
							<?php endif; ?>

							<div class="text-right">
								<button type="submit" class="btn">Send</button>
							</div>

						</form>

				    </div>
					

				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<script type="text/javascript">

		$(".input-price").on("input", function (event) {
			if (isNaN(Number(event.target.value.replace(/,/g, "")))) {
				try {
					event.target.value = event.target.value.replace(
						new RegExp(event.originalEvent.data, "g"),
						""
					);
				} catch (e) {
					event.target.value = event.target.value.replace(
						event.originalEvent.data,
						""
					);
				}
			} else {
				event.target.value = number_with(
					event.target.value.replace(/,/g, "")
				);
			}
		});
		
	</script>

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
