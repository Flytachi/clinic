<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);
$header = "Настройки";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>
<script src="<?= stack("assets/js/custom.js") ?>"></script>

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

				<!-- Cropper demonstration -->
				<div class="<?= $classes['card'] ?>">
					<div class="<?= $classes['card-header'] ?>">
						<h5 class="card-title">Cropper demonstration</h5>
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
						<form action="<?= ajax('admin/config') ?>" method="post" enctype="multipart/form-data">

							<div class="row">

								<div class="col-12">
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
										<div class="form-group row">
											<label class="col-form-label col-lg-3 font-weight-bold">Тип:</label>
											<div class="form-check form-check-switchery form-check-switchery-double">
												<label class="form-check-label">
													2-x 
													<input type="checkbox" class="swit" name="constant_print_document_type" <?= (config("print_document_type")) ? "checked" : "" ?>>
													3-x
												</label>
											</div>
										</div>

									</fieldset>
								</div>

								<div class="col-6">
									<fieldset class="mb-3">
										<legend class="text-uppercase font-size-sm font-weight-bold">Документ</legend>

										<label class="font-weight-bold">Пропорции документа(логотип):</label>
										<div class="form-group row">
											<label class="col-form-label col-lg-2 font-weight-bold">Высота:</label>
											<div class="col-lg-4">
												<input type="text" name="constant_print_document_height" value="<?= config("print_document_height") ?>" placeholder="Введите сумму" class="form-control input-price">
											</div>
											<label class="col-form-label col-lg-2 font-weight-bold">Ширина:</label>
											<div class="col-lg-4">
												<input type="text" name="constant_print_document_width" value="<?= config("print_document_width") ?>" placeholder="Введите сумму" class="form-control input-price">
											</div>
										</div>

									</fieldset>
								</div>

								<!-- <div class="col-6">
									<fieldset class="mb-3">
										<legend class="text-uppercase font-size-sm font-weight-bold">Чек</legend>

										<label class="font-weight-bold">Пропорции чека(логотип):</label>
										<div class="row">
											<label class="col-form-label col-lg-2 font-weight-bold">Высота:</label>
											<div class="col-lg-4">
												<input type="text" name="constant_print_check_height" value="<?= config("print_check_height") ?>" placeholder="Введите сумму" class="form-control input-price">
											</div>
											<label class="col-form-label col-lg-2 font-weight-bold">Ширина:</label>
											<div class="col-lg-4">
												<input type="text" name="constant_print_check_width" value="<?= config("print_check_width") ?>" placeholder="Введите сумму" class="form-control input-price">
											</div>
										</div>

									</fieldset>
								</div> -->

							</div>

							<div class="text-right">
								<button type="submit" class="btn btn-sm">Send</button>
							</div>

						</form>

						<?php if( config('print_header_logotype') ): ?>
							
						<?php else: ?>
							<!-- <form action="<?= ajax('admin/download_logo') ?>" method="post" enctype="multipart/form-data">

								<fieldset class="mb-3">
									<legend class="text-uppercase font-size-sm font-weight-bold">Печать</legend>

									<div class="form-group row">
										<label class="col-form-label col-lg-1 font-weight-bold">Иконка печати:</label>
										<div class="col-lg-9">
											<input type="file" name="constant_print_header_logotype" class="form-control">
										</div>
									</div>

								</fieldset>

								<div class="text-right">
									<button type="submit" class="btn btn-sm">Send</button>
								</div>

							</form> -->
						<?php endif; ?>

					</div>
				</div>
				<!-- /cropper demonstration -->

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<!-- Modal with cropped image -->
	<div id="getCroppedCanvasModal" class="modal fade docs-cropped" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h6 class="modal-title" id="getCroppedCanvasTitle">Cropped</h6>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body text-center"></div>
				<div class="modal-footer">
					<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
					<a href="#" class="btn btn-primary" id="download" download="cropped.jpg">Download</a>
				</div>
			</div>
		</div>
	</div>
	<!-- /modal with cropped image -->

	<script type="text/javascript">


		$( document ).ready(function() {
			$("#aspectRatio4").click();
		});

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
