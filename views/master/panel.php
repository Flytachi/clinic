<?php
require_once '../../tools/warframe.php';
$session->is_auth('master');
$header = "Панель управления";
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'head.php' ?>

<script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
<script src="<?= stack("vendors/js/custom.js") ?>"></script>

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

				<?php if ( isset($_POST['INITIALIZE']) ): ?>
					<?php
					$file = file_get_contents($_FILES['file_database']['tmp_name']);
					$data = json_decode($file, true);
					$_initialize =  Mixin\T_INITIALIZE_database($data);
					?>

					<?php if ($_initialize == 200): ?>
						<div class="alert alert-primary" role="alert">
                            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                            База данных создана!
                        </div>
					<?php else: ?>
						<div class="alert bg-danger alert-styled-left alert-dismissible">
							<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
							<span class="font-weight-semibold">Ошибка при создании базы данных!</span>
					    </div>
                    <?php endif; ?>

				<?php elseif ( isset($_POST['GET_START']) ): ?>

                    <?php
                    // $flush = Mixin\T_FLUSH_database();
					// $_province = province_temp();
					// $_region = region_temp();
                    // $_division = division_temp();
                    // $_user = users_temp();
                    // $_service = service_temp();
                    ?>

                    <?php if ($flush == 200): ?>
                        <div class="alert alert-primary" role="alert">
                            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                            Новая база данных готова к использованию!
                            <ul>

								<?php if ($_division == 200): ?>
                                    <li>Очищены/Созданы отделы</li>
                                <?php else: ?>
                                    <li class="text-danger">Ошибка создания отделов</li>
									<?php if ($_division): ?>
										<ol class="text-danger">
	                                        <li><?= $_division ?></li>
	                                    </ol>
									<?php endif; ?>
                                <?php endif; ?>

								<?php if ($_province == 200): ?>
                                    <li>Очищен/Создан список областей</li>
                                <?php else: ?>
                                    <li class="text-danger">Ошибка при создании списока областей</li>
									<?php if ($_province): ?>
										<ol class="text-danger">
	                                        <li><?= $_province ?></li>
	                                    </ol>
									<?php endif; ?>
                                <?php endif; ?>

								<?php if ($_region == 200): ?>
                                    <li>Очищен/Создан список регионов</li>
                                <?php else: ?>
                                    <li class="text-danger">Ошибка при создании списока регионов</li>
									<?php if ($_region): ?>
										<ol class="text-danger">
	                                        <li><?= $_region ?></li>
	                                    </ol>
									<?php endif; ?>
                                <?php endif; ?>

                                <li>Очищены склады</li>
								<li>Очищены заказы</li>
                                <li>Очищены визиты</li>

                                <li>Очищены услуги</li>
                                <?php if ($_service == 200): ?>
                                    <li>Создана услуга</li>
                                    <ol>
                                        <li>Стационарный Осмотр</li>
                                    </ol>
                                <?php else: ?>
                                    <li class="text-danger">Ошибка создания услуги</li>
									<?php if ($_service): ?>
										<ol class="text-danger">
	                                        <li><?= $_service ?></li>
	                                    </ol>
									<?php endif; ?>
                                <?php endif; ?>

                                <li>Очищены пользователи</li>
                                <?php if ($_user == 200): ?>
                                    <li>Создан администратор</li>
                                    <ol>
                                        <li>login: admin</li>
                                        <li>password: admin</li>
                                    </ol>
                                <?php else: ?>
                                    <li class="text-danger">Ошибка создания администратора</li>
									<?php if ($_user): ?>
										<ol class="text-danger">
	                                        <li><?= $_user ?></li>
	                                    </ol>
									<?php endif; ?>
                                <?php endif; ?>

                            </ul>

                        </div>
					<?php else: ?>
						<div class="alert bg-danger alert-styled-left alert-dismissible">
							<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
							<span class="font-weight-semibold">Ошибка при очистке базы данных!</span>
					    </div>
                    <?php endif; ?>

                <?php endif; ?>

                <div class="card border-1">

				    <div class="card-header header-elements-inline">
				        <h5 class="card-title">Control Panel</h5>
				    </div>

				    <div class="card-body">

                        <?php
                        if( isset($_SESSION['message']) ){
                            echo $_SESSION['message'];
                            unset($_SESSION['message']);
                        }
                        ?>

                        <div class="form-group row">


                            <div class="col-md-6">

								<form action="" method="post" enctype="multipart/form-data">
									<legend>The main</legend>
		                            <input style="display:none;" id="btn_INITIALIZE" type="submit" value="INITIALIZE" name="INITIALIZE"></input>
		                            <input style="display:none;" id="btn_GET_START" type="submit" value="GET_START" name="GET_START"></input>

									<div class="form-group row">

						                <div class="col-md-7">
						                   	<input type="file" class="form-control" name="file_database" onchange="Chemp(this)" accept="application/json">
						                </div>

						                <div class="col-md-5" style="margin-top: 10px;">
						                    <button type="button" class="btn btn-primary btn-sm" onclick="Conf('#btn_INITIALIZE')" id="btn_ini" disabled>Initialize the database</button>
											<button type="button" class="btn btn-danger btn-sm" onclick="Conf('#btn_GET_START')">GET START</button>
						                </div>

						            </div>

		                        </form>

                            </div>

							<div class="col-md-6">

								<legend>The settings</legend>

								<?php
								try {
									$comp = $db->query("SELECT * FROM company_constants")->fetchAll();
									foreach ($comp as $value) {
									    $company[$value['const_label']] = $value['const_value'];
									}
									?>
									<div class="table-responsive">
										<table class="table table-sm table-bordered">
											<tbody>
												<tr>
													<th>Laboratory</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="Const_ZP(this)" type="checkbox" class="swit bg-danger" name="module_laboratory" <?= (isset($company['module_laboratory']) and $company['module_laboratory']) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Diagnostic</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="Const_ZP(this)" type="checkbox" class="swit bg-danger" name="module_diagnostic" <?= (isset($company['module_diagnostic']) and $company['module_diagnostic']) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Pharmacy</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="Const_ZP(this)" type="checkbox" class="swit bg-danger" name="module_pharmacy" <?= (isset($company['module_pharmacy']) and $company['module_pharmacy']) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>Bypass</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="Const_ZP(this)" type="checkbox" class="swit bg-danger" name="module_bypass" <?= (isset($company['module_bypass']) and $company['module_bypass']) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
												<tr>
													<th>ZeTTa PACS</th>
													<td class="text-right">
														<div class="list-icons">
															<label class="form-check-label">
																<input onclick="Const_ZP(this)" type="checkbox" class="swit bg-danger" name="module_zetta_pacs" <?= (isset($company['module_zetta_pacs']) and $company['module_zetta_pacs']) ? "checked" : "" ?>>
															</label>
														</div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
									<?php
								} catch (\Exception $e) {
									echo "Не установлена база данных";
								}
								// dd(module());
								?>

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
		function Const_ZP(input) {
			$.ajax({
				type: "POST",
				url: "<?= ajax('master_controller') ?>",
				data: Object.assign({}, { module: input.name }, $(input).serializeArray()),
				success: function (data) {
					if (data == 1) {
						new Noty({
							text: "Успешно",
							type: 'success'
						}).show();
					}
				},
			});
		}

		function Chemp(input) {
			if (input.value.match(/\.?[^.]+$/)[0] == ".json") {
				$('#btn_ini').attr("disabled", false);
			}else {
				$('#btn_ini').attr("disabled", true);
			}
		}

		function Conf(btn) {
			swal({
				position: 'top',
				title: 'Внимание!',
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
							$(btn).click();
						}
					});
				}

			});
		}
	</script>

</body>
</html>
