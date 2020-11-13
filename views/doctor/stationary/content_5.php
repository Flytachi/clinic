<?php
require_once '../../../tools/warframe.php';
is_auth(5);
$header = "Пациент";
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../../layout/head.php' ?>

<body>
	<!-- Main navbar -->
	<?php include '../../layout/navbar.php' ?>
	<!-- /main navbar -->

	<!-- Page content -->
	<div class="page-content">
		<!-- Main sidebar -->
		<?php include '../../layout/sidebar.php' ?>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header -->
			<?php include '../../layout/header.php' ?>
			<!-- /page header -->

			<!-- Content area -->
			<div class="content">

				<?php include "../profile_card.php"; ?>

				<div class="card border-1 border-info">
				    <div class="card-header text-dark header-elements-inline alpha-info">
				        <h6 class="card-title">Просмотр визита</h6>
				    </div>

				    <div class="card-body">
				        <?php include "content_tabs.php"; ?>

						<h4 class="card-title">Мои направление</h4>

						<button type="button" class="btn alpha-blue text-blue-800 border-blue-600 legitRipple" data-toggle="modal" data-target="#modal_full">Добавить услугу</button>
						<div id="modal_full" class="modal fade" tabindex="-1">
							<div class="modal-dialog modal-full">
								<div class="modal-content">
									<div class="modal-body">
										<div class="card-header bg-white header-elements-inline">
											<h6 class="card-title">
												Добавить Услугу <span class="text-muted font-size-base ml-2"><b>ФИО пациента:</b> Якубов Фарход Абдурасулович</span>
											</h6>
										</div>

										<form class="steps-enable-all wizard clearfix" role="application" id="steps-uid-0">
											<div class="steps clearfix">
												<ul role="tablist">
													<li role="tab" aria-disabled="false" class="first current" aria-selected="true">
														<a id="steps-uid-0-t-0" href="#steps-uid-0-h-0" aria-controls="steps-uid-0-p-0"><span class="current-info audible">current step: </span><span class="number">1</span> Добавить услуг</a>
													</li>
													<li role="tab" aria-disabled="false">
														<a id="steps-uid-0-t-1" href="#steps-uid-0-h-1" aria-controls="steps-uid-0-p-1"><span class="number">2</span> Пакет Услуг</a>
													</li>
													<li role="tab" aria-disabled="false" class="last">
														<a id="steps-uid-0-t-2" href="#steps-uid-0-h-2" aria-controls="steps-uid-0-p-2"><span class="number">3</span> Завершить</a>
													</li>
												</ul>
											</div>
											<div class="content clearfix">
												<h6 id="steps-uid-0-h-0" tabindex="-1" class="title current">Добавить услуг</h6>
												<fieldset id="steps-uid-0-p-0" role="tabpanel" aria-labelledby="steps-uid-0-h-0" class="body current" aria-hidden="false">
													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label>Выбрать Группу:</label>
																<select name="location" data-placeholder="Выбрать категорию" class="form-control form-control-select2 select2-hidden-accessible" data-fouc="" tabindex="-1" aria-hidden="true">
																	<option></option>
																	<optgroup label="Выбрать категорию">
																		<option value="1">Лаборатория</option>
																		<option value="2">Консултация</option>
																		<option value="3">Физиотерапия</option>
																		<option value="4">Нейрохирургия</option>
																		<option value="2">Травмотология</option>
																	</optgroup>
																</select>
																<span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;">
																	<span class="selection">
																		<span
																			class="select2-selection select2-selection--single"
																			role="combobox"
																			aria-haspopup="true"
																			aria-expanded="false"
																			tabindex="0"
																			aria-labelledby="select2-location-7a-container"
																		>
																			<span class="select2-selection__rendered" id="select2-location-7a-container"><span class="select2-selection__placeholder">Выбрать категорию</span></span>
																			<span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>
																		</span>
																	</span>
																	<span class="dropdown-wrapper" aria-hidden="true"></span>
																</span>
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-md-6">
															<div class="form-group">
																<label>Мед Услуги:</label>
																<select name="position" data-placeholder="Выбрать услугу" class="form-control form-control-select2 select2-hidden-accessible" data-fouc="" tabindex="-1" aria-hidden="true">
																	<option></option>
																	<optgroup label="Наши Услуги">
																		<option value="1">Осмотр Терапевта</option>
																		<option value="2">Осмотр Травмотолога</option>
																		<option value="3">Осмотр Нейрохирурга</option>
																		<option value="4">Осмотр Эндокринолога</option>
																	</optgroup>
																</select>
																<span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;">
																	<span class="selection">
																		<span
																			class="select2-selection select2-selection--single"
																			role="combobox"
																			aria-haspopup="true"
																			aria-expanded="false"
																			tabindex="0"
																			aria-labelledby="select2-position-06-container"
																		>
																			<span class="select2-selection__rendered" id="select2-position-06-container"><span class="select2-selection__placeholder">Выбрать услугу</span></span>
																			<span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>
																		</span>
																	</span>
																	<span class="dropdown-wrapper" aria-hidden="true"></span>
																</span>
															</div>
														</div>
														<div class="col-md-6">
															<div class="form-group">
																<label>Имя Специалиста:</label>
																<input type="text" name="name" class="form-control" />
															</div>
														</div>
													</div>

													<div class="row">
														<div class="col-md-4">
															<div class="form-group">
																<label>Кабинет Врача:</label>
																<input type="text" name="tel" class="form-control" />
															</div>
														</div>
													</div>
												</fieldset>

												<h6 id="steps-uid-0-h-1" tabindex="-1" class="title">Пакет Услуг</h6>
												<fieldset id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1" class="body" style="display: none;" aria-hidden="true">
													<div class="row">
														<div class="col-md-6">
															<p class="font-weight-semibold">Выбрать пакет:</p>
															<div class="sidebar sidebar-light sidebar-component position-static w-100 d-block mb-md-4">
																<div class="sidebar-content position-static">
																	<!-- User menu -->

																	<!-- /user menu -->

																	<!-- Navigation -->
																	<div class="card">
																		<ul class="nav nav-sidebar" data-nav-type="collapsible">
																			<li class="nav-item-header">
																				<div class="text-uppercase font-size-sm line-height-sm">Пакеты</div>
																			</li>

																			<li class="nav-item">
																				<a href="#" class="nav-link legitRipple"><i class="icon-add"></i> Общий наркоз ТВА 1 операция</a>

																				<ul class="nav nav-group-sub">
																					<li class="nav-item"><a href="#" class="nav-link legitRipple">Second level link</a></li>
																					<li class="nav-item"><a href="#" class="nav-link legitRipple">Second level link</a></li>
																				</ul>
																			</li>
																			<li class="nav-item">
																				<a href="#" class="nav-link legitRipple"><i class="icon-add"></i> Общий наркоз ТВА 2 операции</a>

																				<ul class="nav nav-group-sub">
																					<li class="nav-item"><a href="#" class="nav-link legitRipple">Second level link</a></li>
																					<li class="nav-item"><a href="#" class="nav-link legitRipple">Second level link</a></li>
																				</ul>
																			</li>
																			<li class="nav-item">
																				<a href="#" class="nav-link legitRipple"><i class="icon-add"></i> Общий наркоз ТВА 3 операции</a>

																				<ul class="nav nav-group-sub">
																					<li class="nav-item"><a href="#" class="nav-link legitRipple">Second level link</a></li>
																					<li class="nav-item"><a href="#" class="nav-link legitRipple">Second level link</a></li>
																				</ul>
																			</li>

																			<li class="nav-item">
																				<a href="#" class="nav-link disabled"><i class="icon-make-group"></i> Нажмите на кнопку</a>
																			</li>
																		</ul>
																	</div>
																	<!-- /navigation -->
																</div>
															</div>
														</div>

														<div class="col-md-6">
															<p class="font-weight-semibold">Выранные пакеты</p>
															<div class="sidebar sidebar-light sidebar-component position-static w-100 d-block mb-md-4">
																<div class="sidebar-content position-static">
																	<!-- Navigation -->
																	<div class="card">
																		<ul class="nav nav-sidebar" data-nav-type="accordion">
																			<li class="nav-item-header">
																				<div class="text-uppercase font-size-sm line-height-sm">Выбранные</div>
																			</li>

																			<li class="nav-item">
																				<a href="#" class="nav-link disabled"><i class="icon-make-group"></i> Смотреть список</a>
																			</li>
																		</ul>
																	</div>
																	<!-- /navigation -->
																</div>
															</div>
														</div>
													</div>
												</fieldset>

												<h6 id="steps-uid-0-h-2" tabindex="-1" class="title">Завершить</h6>
												<fieldset id="steps-uid-0-p-2" role="tabpanel" aria-labelledby="steps-uid-0-h-2" class="body" style="display: none;" aria-hidden="true">
													<div class="card">
														<div class="card-header header-elements-inline">
															<h5 class="card-title">Услуга пациента</h5>
														</div>
														<div class="table-responsive">
															<table class="table table-xl">
																<thead>
																	<tr class="bg-blue">
																		<th>ID</th>
																		<th>ФИО</th>

																		<th>Категория</th>
																		<th>Мед Услуга</th>
																		<th>Специалист</th>
																	</tr>
																</thead>
																<tbody>
																	<tr>
																		<td>1</td>
																		<td>2</td>

																		<td>4</td>
																		<td>5</td>
																		<td>6</td>
																	</tr>
																</tbody>
															</table>
														</div>
													</div>
												</fieldset>
											</div>
											<div class="actions clearfix">
												<ul role="menu" aria-label="Pagination">
													<li class="disabled" aria-disabled="true">
														<a href="#previous" class="btn btn-light disabled legitRipple" role="menuitem"><i class="icon-arrow-left13 mr-2"></i> Previous</a>
													</li>
													<li aria-hidden="false" aria-disabled="false">
														<a href="#next" class="btn btn-primary legitRipple" role="menuitem">Next <i class="icon-arrow-right14 ml-2"></i></a>
													</li>
													<li style="display: none;" aria-hidden="true">
														<a href="#finish" class="btn btn-primary legitRipple" role="menuitem">Submit form <i class="icon-arrow-right14 ml-2"></i></a>
													</li>
												</ul>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<!-- /full width modal -->

						<div class="card">
							<table class="table table-togglable table-hover">
								<thead>
									<tr class="bg-blue">
										<th>ID</th>
										<th>ФИО</th>

										<th>Дата и время</th>
										<th>Тип группы</th>
										<th>Мед Услуга</th>
										<th>Статус</th>
										<th class="text-center">Действия</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>00001</td>
										<td>Якубов Фарход Абдурасулович</td>

										<td>04.10.2020 12:01</td>
										<td>Консултация</td>
										<td>Осмотр терапевта</td>
										<td><span class="badge badge-success">Оплачено</span></td>
										<td class="text-center">
											<button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
											<div class="dropdown-menu dropdown-menu-right">
												<a href="#" class="dropdown-item"><i class="icon-paste2"></i>Заключения врача</a>
											</div>
										</td>
									</tr>
								</tbody>
								<tbody>
									<tr>
										<td>00001</td>
										<td>Якубов Фарход Абдурасулович</td>

										<td>04.10.2020 12:01</td>
										<td>Лаборатория</td>
										<td>Общий анализ крови</td>
										<td><span class="badge badge-warning">В кассе</span></td>
										<td class="text-center">
											<button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
											<div class="dropdown-menu dropdown-menu-right">
												<a href="#" class="dropdown-item"><i class="icon-paste2"></i>Заключения врача</a>
											</div>
										</td>
									</tr>
								</tbody>
								<tbody>
									<tr>
										<td>00001</td>
										<td>Якубов Фарход Абдурасулович</td>

										<td>04.10.2020 12:01</td>
										<td>Физиотерапия</td>
										<td>Магниотерапия</td>
										<td><span class="badge badge-primary">У Специалиста</span></td>
										<td class="text-center">
											<button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
											<div class="dropdown-menu dropdown-menu-right">
												<a href="#" class="dropdown-item"><i class="icon-paste2"></i>Заключения врача</a>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>

				    </div>

				    <!-- /content wrapper -->
				</div>

			</div>
            <!-- /content area -->

		</div>
		<!-- /main content -->
	</div>
	<!-- /page content -->

    <!-- Footer -->
    <?php include '../../layout/footer.php' ?>
    <!-- /footer -->
</body>
</html>
