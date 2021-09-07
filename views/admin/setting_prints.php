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

				<!-- Document -->
				<div class="<?= $classes['card'] ?>">
					<div class="<?= $classes['card-header'] ?>">
						<h5 class="card-title">Документ</h5>
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
						<form action="<?= ajax('admin/prints') ?>" method="post" enctype="multipart/form-data">

							<div class="row">

								<div class="col-12">
									<fieldset class="mb-3">

										<div class="form-group row">

											<div class="col-6">
												<label class="col-form-label font-weight-bold">Кол-во блоков:</label>
												<input type="number" min="1" max="3" name="constant_print_document_blocks" value="<?= config("print_document_blocks") ?>" placeholder="Введите кол-во блоков" class="form-control">
											</div>

											<div class="col-6">

												<?php for ($s=1; $s <= $print_hr_count; $s++): ?>
													<div class="form-group row">
														<div class="col-3">
															<?= $s ?> разделитель
														</div>
														<div class="col-2">
															<input type="checkbox" class="swit" name="constant_print_document_hr-<?= $s ?>" <?= ( config("print_document_hr-$s") ) ? 'checked': '' ?>>
														</div>
														<div class="col-1">
															<input type="color" name="constant_print_document_hr-<?= $s ?>-color" value="<?= config("print_document_hr-$s-color") ?>" class="form-controlanimations_velocity_examples">
														</div>
													</div>
												<?php endfor; ?>

											</div>
											
										</div>
										

									</fieldset>
								</div>

								<div class="col-12">
									<fieldset class="mb-3">
										<legend class="text-uppercase font-size-sm font-weight-bold border-primary">Блоки</legend>

										<div class="row">

											<?php for ($i=1; $i <= config('print_document_blocks'); $i++): ?>
												
												<div class="col-<?= (config('print_document_blocks') < 5) ? 12 / config('print_document_blocks') : 3 ?>">
	
													<div class="<?= $classes['card'] ?>">
		
														<div class="<?= $classes['card-header'] ?>">
															<h6 class="card-title">Блок №<?= $i ?></h6>
														</div>
		
														<div class="card-body">

															<div class="form-group row">

																<div class="form-group col-6">
																	<label class="font-weight-bold">Тип:</label>
																	<div class="form-check form-check-switchery form-check-switchery-double">
																		<label class="form-check-label">
																			Текст
																			<input type="checkbox" class="swit" id="block-<?= $i ?>" onclick="Checkert(this)" name="constant_print_document_<?= $i ?>-type" <?= (config("print_document_$i-type")) ? 'checked': '' ?>>
																			Изображение
																		</label>
																	</div>
																</div>

																<div class="form-group col-6">
																	<label class="font-weight-bold">Выравнивание:</label>
																	<select name="constant_print_document_<?= $i ?>-aligin" class="<?= $classes['form-select'] ?>" required>
																		<option value="left" <?= ( config("print_document_$i-aligin") == 'left' ) ? 'selected' : '' ?>>Лево</option>
																		<option value="center" <?= ( config("print_document_$i-aligin") == 'center' ) ? 'selected' : '' ?>>Центр</option>
																		<option value="right" <?= ( config("print_document_$i-aligin") == 'right' ) ? 'selected' : '' ?>>Право</option>
																	</select>
																</div>
																
															</div>

															<legend class="border-primary"></legend>
		
															<div id="block-<?= $i ?>-text" <?= (config("print_document_$i-type")) ? 'style="display:none;"': 'style="display:block;"' ?>>

																<div class="form-group row">
																	<div class="col-7">
																		<label>Текст:</label>
																	</div>
																	<div class="col-2">
																		<label>Размер:</label>
																	</div>
																	<div class="col-2">
																		<label>Жирный:</label>
																	</div>
																	<div class="col-1">
																		<label>Цвет:</label>
																	</div>
																</div>

																<?php for ($t=1; $t <= $print_text_count; $t++): ?>
																	<div class="form-group row">
																		<div class="col-7">
																			<input type="text" name="constant_print_document_<?= $i ?>-text-<?= $t ?>" value="<?= config("print_document_$i-text-$t") ?>" class="form-control" placeholder="<?= $t ?> строка">
																		</div>
																		<div class="col-2">
																			<input type="number" min="14" max="70" name="constant_print_document_<?= $i ?>-text-<?= $t ?>-size" value="<?= config("print_document_$i-text-$t-size") ?>" class="form-control" placeholder="20px">
																		</div>
																		<div class="col-2">
																			<input type="checkbox" class="swit" name="constant_print_document_<?= $i ?>-text-<?= $t ?>-is_bold" <?= (config("print_document_$i-text-$t-is_bold") ) ? 'checked': '' ?>>
																		</div>
																		<div class="col-1">
																			<input type="color" name="constant_print_document_<?= $i ?>-text-<?= $t ?>-color" value="<?= config("print_document_$i-text-$t-color") ?>" class="form-control">
																		</div>
																	</div>
																<?php endfor; ?>

																<div class="text-center" style="margin-top: -15px;">
																	<span class="form-text text-muted">Указывать размер в пикселях (px)</span>
																</div>

															</div>

															<div id="block-<?= $i ?>-image" <?= (config("print_document_$i-type")) ? 'style="display:block;"': 'style="display:none;"' ?>>

																<div class="row">
																	<div class="form-group col-5">
																		<label>Изображение:</label>
																		<input type="file" name="constant_print_document_<?= $i ?>-logotype" class="form-control">
																	</div>
																	<div class="form-group col-7 text-right mt-2">
																		<img id="block-<?= $i ?>-image-example" class="shadow-1 <?= (config("print_document_$i-logotype-is_circle") ) ? 'rounded-circle': '' ?>" 
																			src="<?= ( config("print_document_$i-logotype") ) ? config("print_document_$i-logotype") : stack('global_assets/images/placeholders/cover.jpg') ?>" 
																			<?= ( config("print_document_$i-logotype-height") == config("print_document_$i-logotype-width") ) ? 'width="70" height="70"' : 'width="240" height="70"' ?>>
																	</div>
																	<div class="form-group col-12 text-right">
																		<div class="form-check form-check-switchery form-check-switchery-double">
																			<label class="form-check-label">
																				Округлить
																				<input type="checkbox" onclick="CheckertImage(this)" class="swit" id="block-<?= $i ?>-image" name="constant_print_document_<?= $i ?>-logotype-is_circle" <?= (config("print_document_$i-logotype-is_circle") ) ? 'checked': '' ?>>
																			</label>
																		</div>
																	</div>
																</div>

																<div class="row">
																	<div class="form-group col-6">
																		<label>Высота (px):</label>
																		<input type="number" min="50" max="600" name="constant_print_document_<?= $i ?>-logotype-height" value="<?= ( config("print_document_$i-logotype-height") ) ? config("print_document_$i-logotype-height") : 120 ?>" class="form-control" placeholder="Введите высоту">
																	</div>
																	<div class="form-group col-6">
																		<label>Ширина (px):</label>
																		<input type="number" min="50" max="1200" name="constant_print_document_<?= $i ?>-logotype-width" value="<?= ( config("print_document_$i-logotype-width") ) ? config("print_document_$i-logotype-width") : 400 ?>" class="form-control" placeholder="Введите ширину">
																	</div>
																	<div class="col-12 text-center" style="margin-top: -25px;">
																		<span class="form-text text-muted">Указывать значение в пикселях (px)</span>
																	</div>
																</div>

															</div>
		
														</div>
		
													</div> 
	
												</div>

											<?php endfor; ?>


										</div>
										
										<!-- <label class="font-weight-bold">Пропорции документа():</label>
										<div class="form-group row">
											<label class="col-form-label col-lg-2 font-weight-bold">Высота:</label>
											<div class="col-lg-4">
												<input type="text" name="constant_print_document_height" value="<?= config("print_document_height") ?>" placeholder="Введите сумму" class="form-control input-price">
											</div>
											<label class="col-form-label col-lg-2 font-weight-bold">Ширина:</label>
											<div class="col-lg-4">
												<input type="text" name="constant_print_document_width" value="<?= config("print_document_width") ?>" placeholder="Введите сумму" class="form-control input-price">
											</div>
										</div> -->

									</fieldset>
								</div>

								<!-- <div class="col-12">
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
								</div> -->

							</div>

							<div class="text-right">
								<button onclick="ConfirmFlush()" type="button" class="btn btn-outline-danger btn-sm">Сбросить настройки печати</button>
								<button onclick="Print('<?= prints('document-1').'?pk=template' ?>')" type="button" class="btn btn-outline-success btn-sm">Пример документа</button>
								<button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
									<span class="ladda-label">Сохранить данные</span>
									<span class="ladda-spinner"></span>
								</button>
							</div>

						</form>

					</div>
				</div>
				<!-- /Document -->

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

	<script type="text/javascript">

		function ConfirmFlush() {
			var wha = "Вы уверены что, хотите сбросить настройки печати?";
			swal({
				position: 'top',
				title: wha,
				type: 'info',
				showCancelButton: true,
				confirmButtonText: "Уверен"
			}).then(function(ivi) {
				if (ivi.value) {
					swal({
						position: 'top',
						title: 'Внимание!',
						text: 'Вернуть данные назад будет невозможно!',
						type: 'warning',
						showCancelButton: true,
						confirmButtonText: "Да"
					}).then(function(ivi) {
						if (ivi.value) {
							location = "<?= ajax('admin/prints-flush') ?>?flush=true";
						}
					});
				}

			});
		}

		function CheckertImage(event) {
			if(event.checked){
				document.querySelector("#"+event.id+"-example").classList.add("rounded-circle");
			}else{
				document.querySelector("#"+event.id+"-example").classList.remove("rounded-circle");
			}
		}

		function Checkert(event) {
			if(event.checked){
				$("#"+event.id+"-text").css("display","none");
				$("#"+event.id+"-image").css("display","block");
			}else{
				$("#"+event.id+"-image").css("display","none");
				$("#"+event.id+"-text").css("display","block");
			}
		}

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
