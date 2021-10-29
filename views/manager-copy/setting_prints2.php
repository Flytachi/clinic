<?php
require_once '../../tools/warframe.php';
$session->is_auth(1);
$header = "Настройки";
?>
<!DOCTYPE html>
<html lang="en">
<?php include layout('head') ?>
<script src="<?= stack("global_assets/js/plugins/media/cropper.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/extension_image_cropper.js") ?>"></script>

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

						<?php if( config('print_header_logotype') ): ?>
							<div class="row">
								<div class="col-md-6">
									<div class="image-cropper-container mb-3">
										<img src="<?= ( config('print_header_logotype') ) ? config('print_header_logotype') : stack('global_assets/images/placeholders/placeholder.jpg') ; ?>" alt="" class="cropper crop-drag" id="demo-cropper-image">
									</div>

									<div class="form-group demo-cropper-toolbar">
										<label class="font-weight-semibold">Toolbar:</label>
										<div class="btn-group btn-group-justified">
											<div class="btn-group">
												<button type="button" class="btn bg-blue btn-icon" data-method="setDragMode" data-option="move" title="Move">
													<span class="icon-move"></span>
												</button>
											</div>

											<div class="btn-group">
												<button type="button" class="btn bg-blue btn-icon" data-method="setDragMode" data-option="crop" title="Crop">
													<span class="icon-crop2"></span>
												</button>
											</div>

											<div class="btn-group">
												<button type="button" class="btn bg-blue btn-icon" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
													<span class="icon-arrow-left13"></span>
												</button>
											</div>

											<div class="btn-group">
												<button type="button" class="btn bg-blue btn-icon" data-method="move" data-option="10" data-second-option="0" title="Move Right">
													<span class="icon-arrow-right14"></span>
												</button>
											</div>

											<div class="btn-group">
												<button type="button" class="btn bg-blue btn-icon" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
													<span class="icon-arrow-up13"></span>
												</button>
											</div>

											<div class="btn-group">
												<button type="button" class="btn bg-blue btn-icon" data-method="move" data-option="0" data-second-option="10" title="Move Down">
													<span class="icon-arrow-down132"></span>
												</button>
											</div>
										</div>
									</div>

									<div class="form-group demo-cropper-toolbar">
										<div class="btn-group btn-group-justified">
											<div class="btn-group">
												<button type="button" class="btn bg-blue btn-icon" data-method="zoom" data-option="0.1" title="Zoom In">
													<span class="icon-zoomin3"></span>
												</button>
											</div>

											<div class="btn-group">
												<button type="button" class="btn bg-blue btn-icon" data-method="zoom" data-option="-0.1" title="Zoom Out">
													<span class="icon-zoomout3"></span>
												</button>
											</div>

											<div class="btn-group">
												<button type="button" class="btn bg-blue btn-icon" data-method="rotate" data-option="-45" title="Rotate Left">
													<span class="icon-rotate-ccw3"></span>
												</button>
											</div>

											<div class="btn-group">
												<button type="button" class="btn bg-blue btn-icon" data-method="rotate" data-option="45" title="Rotate Right">
													<span class="icon-rotate-cw3"></span>
												</button>
											</div>

											<div class="btn-group">
												<button type="button" class="btn bg-blue btn-icon" data-method="scaleX" data-option="-1" title="Flip Horizontal">
													<span class="icon-flip-vertical4"></span>
												</button>
											</div>

											<div class="btn-group">
												<button type="button" class="btn bg-blue btn-icon" data-method="scaleY" data-option="-1" title="Flip Vertical">
													<span class="icon-flip-vertical3"></span>
												</button>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="font-weight-semibold">Crop:</label>
										<div class="btn-group btn-group-justified demo-cropper-toolbar">
											<div class="btn-group">
												<button type="button" class="btn btn-light" data-method="getCroppedCanvas">
													Get Cropped Canvas
												</button>
											</div>

											<div class="btn-group">
												<button type="button" class="btn btn-light" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 150, &quot;height&quot;: 150 }">
													150&times;150
												</button>
											</div>

											<div class="btn-group">
												<button type="button" class="btn btn-light" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 120, &quot;height&quot;: 120 }">
													120&times;120
												</button>
											</div>

											<div class="btn-group">
												<button type="button" class="btn btn-light" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 90, &quot;height&quot;: 90 }">
													90&times;90
												</button>
											</div>

											<div class="btn-group">
												<button type="button" class="btn btn-light" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 60, &quot;height&quot;: 60 }">
													60&times;60
												</button>
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="font-weight-semibold">Aspect ratio:</label>
										<div class="btn-group btn-group-justified demo-cropper-ratio" data-toggle="buttons">
											<label class="btn btn-light">
												<input type="radio" class="sr-only" id="aspectRatio0" name="aspectRatio" value="1.7777777777777777">
												16:9
											</label>
											<label class="btn btn-light">
												<input type="radio" class="sr-only" id="aspectRatio1" name="aspectRatio" value="1.3333333333333333">
												4:3
											</label>
											<label class="btn btn-light">
												<input type="radio" class="sr-only" id="aspectRatio2" name="aspectRatio" value="1">
												1:1
											</label>
											<label class="btn btn-light">
												<input type="radio" class="sr-only" id="aspectRatio3" name="aspectRatio" value="0.6666666666666666">
												2:3
											</label>
											<label class="btn btn-light">
												<input type="radio" class="sr-only" id="aspectRatio4" name="aspectRatio" value="NaN">
												Free
											</label>
										</div>
									</div>

									<div class="form-group mb-0">
										<div class="row">
											<div class="col-md-4">
												<div class="form-check form-check-switchery form-check-switchery-double switchery-sm text-center">
													<label class="form-check-label">
														Clear
														<input type="checkbox" class="clear-crop-switch" checked data-fouc>
														Crop
													</label>
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-check form-check-switchery form-check-switchery-double switchery-sm text-center">
													<label class="form-check-label">
														Disable
														<input type="checkbox" class="enable-disable-switch" checked data-fouc>
														Enable
													</label>
												</div>
											</div>

											<div class="col-md-4">
												<div class="form-check form-check-switchery form-check-switchery-double switchery-sm text-center">
													<label class="form-check-label">
														Destroy
														<input type="checkbox" class="destroy-create-switch" checked data-fouc>
														Create
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="mb-3 text-center">
										<div class="eg-preview d-md-flex justify-content-md-center align-items-md-center text-center">
											<div class="preview preview-lg d-md-inline-block mt-3 mx-auto mr-md-0 mt-md-0 ml-md-3 overflow-hidden rounded"></div>
											<div class="preview preview-md d-md-inline-block mt-3 mx-auto mr-md-0 mt-md-0 ml-md-3 overflow-hidden rounded"></div>
											<div class="preview preview-md d-md-inline-block mt-3 mx-auto mr-md-0 mt-md-0 ml-md-3 overflow-hidden rounded"></div>
											<div class="preview preview-xs d-md-inline-block mt-3 mx-auto mr-md-0 mt-md-0 ml-md-3 overflow-hidden rounded"></div>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-6">
											<div class="form-group">
												<label class="font-weight-semibold">X value:</label>
												<input type="text" class="form-control" id="dataX" placeholder="x">
											</div>

											<div class="form-group">
												<label class="font-weight-semibold">Width:</label>
												<input type="text" class="form-control" id="dataWidth" placeholder="width">
											</div>

											<div class="form-group">
												<label class="font-weight-semibold">ScaleX:</label>
												<input type="text" class="form-control" id="dataScaleX" placeholder="scaleX">
											</div>
										</div>

										<div class="col-lg-6">
											<div class="form-group">
												<label class="font-weight-semibold">Y value:</label>
												<input type="text" class="form-control" id="dataY" placeholder="y">
											</div>

											<div class="form-group">
												<label class="font-weight-semibold">Height:</label>
												<input type="text" class="form-control" id="dataHeight" placeholder="height">
											</div>

											<div class="form-group">
												<label class="font-weight-semibold">ScaleY:</label>
												<input type="text" class="form-control" id="dataScaleY" placeholder="scaleY">
											</div>
										</div>
									</div>

									<div class="form-group">
										<label class="font-weight-semibold">General data:</label>
										<div class="input-group">
											<input class="form-control" id="showData1" type="text" placeholder="General data">
											<span class="input-group-append">
												<button class="btn btn-light" id="getData" type="button">Get Data</button>
												<button class="btn btn-light" id="setData" type="button">Set Data</button>
											</span>
										</div>
									</div>

									<div class="form-group">
										<label class="font-weight-semibold">Container &amp; image data:</label>
										<div class="input-group">
											<input class="form-control" id="showData2" type="text" placeholder="Container and image data">
											<span class="input-group-append">
												<button class="btn btn-light" id="getContainerData" type="button">Get Container Data</button>
												<button class="btn btn-light" id="getImageData" type="button">Get Image Data</button>
											</span>
										</div>
									</div>

									<div class="form-group">
										<label class="font-weight-semibold">Canvas data:</label>
										<div class="input-group">
											<input class="form-control" id="showData3" type="text" placeholder="Canvas data">
											<span class="input-group-append">
												<button class="btn btn-light" id="getCanvasData" type="button">Get Canvas Data</button>
												<button class="btn btn-light" id="setCanvasData" type="button">Set Canvas Data</button>
											</span>
										</div>
									</div>

									<div class="form-group">
										<label class="font-weight-semibold">Crop box data:</label>
										<div class="input-group">
											<input class="form-control" id="showData4" type="text" placeholder="Crop box data">
											<span class="input-group-append">
												<button class="btn btn-light" id="getCropBoxData" type="button">Get Crop Box Data</button>
												<button class="btn btn-light" id="setCropBoxData" type="button">Set Crop Box Data</button>
											</span>
										</div>
									</div>
								</div>
							</div>
						<?php else: ?>
							<form action="<?= ajax('admin/download_logo') ?>" method="post" enctype="multipart/form-data">

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

							</form>
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
