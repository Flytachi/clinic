<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);
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

						<form action="<?= viv('admin/admin_model') ?>" method="post" enctype="multipart/form-data">

							<fieldset class="mb-3">
								<legend class="text-uppercase font-size-sm font-weight-bold">Печать</legend>

								<div class="form-group row">
									<div class="col-form-label col-lg-2">
										<img class="border-1" src="<?= config("print_header_logotype") ?>" width="200" height="60">
									</div>
									<label class="col-form-label col-lg-1 font-weight-bold">Иконка печати:</label>
									<div class="col-lg-9">
										<input type="file" name="constant_print_header_logotype" class="form-control">
									</div>
								</div>

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

							<?php if(module('module_zetta_pacs')): ?>
								<fieldset class="mb-3">
									<legend class="text-uppercase font-size-sm font-weight-bold">ZettaPacs</legend>

									<div class="form-group row">

										<label class="col-form-label col-lg-1 font-weight-bold">Ip:</label>
										<div class="col-lg-3">
											<input type="text" name="constant_zetta_pacs_IP" value="<?= config("zetta_pacs_IP")  ?>" placeholder="Введите ip" class="form-control">
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

	<!-- Footer -->
    <?php include layout('footer') ?>
    <!-- /footer -->
</body>
</html>
