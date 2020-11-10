
<?php
require_once '../../tools/warframe.php';
is_auth();
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>

<script src="<?= stack("global_assets/js/plugins/forms/wizards/steps.min.js")?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js")?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js")?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/inputs/inputmask.js")?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/validation/validate.min.js")?>"></script>
<script src="<?= stack("global_assets/js/plugins/extensions/cookie.js")?>"></script>
<script src="<?= stack("assets/js/app.js")?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_wizard.js")?>"></script>
<!-- /theme JS files -->
<!-- Theme JS files -->
<script src="<?= stack("global_assets/js/plugins/editors/summernote/summernote.min.js")?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/styling/uniform.min.js")?>"></script>
<script src="<?= stack("global_assets/js/plugins/forms/selects/select2.min.js")?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/form_select2.js")?>"></script>
<script src="<?= stack("assets/js/app.js")?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/editor_summernote.js")?> "></script>

<script src="<?= stack("global_assets/js/plugins/visualization/d3/d3.min.js") ?>"></script>
<script src="<?= stack("global_assets/js/plugins/visualization/d3/d3_tooltip.js")?>"></script>

<script src="<?= stack("assets/js/app.js")?>"></script>	
<script src="<?= stack("global_assets/js/demo_pages/charts/d3/lines/lines_basic.js")?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/charts/d3/lines/lines_basic_bivariate.js")?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/charts/d3/lines/lines_basic_area.js")?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/charts/d3/lines/lines_basic_multi_series.js")?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/charts/d3/lines/lines_basic_stacked.js")?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/charts/d3/lines/lines_basic_stacked_nest.js")?>"></script>
<script src="<?= stack("global_assets/js/demo_pages/charts/d3/lines/lines_basic_gradient.js")?>"></script>

</head>

<body>

	<!-- Main navbar -->
	<?php include '../layout/navbar.php' ?>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content">

		<!-- Main sidebar -->
		<?php include '../layout/sidebar.php' ?>
		<!-- /main sidebar -->


		<!-- Main content -->

		<div class="content-wrapper">
			<!-- Content area -->
			<div class="content">

				<div class="card">
				    <div class="card-header header-elements-inline">
				        <h6 class="card-title">Лаборатория</h6>
				        <div class="header-elements">
				            <div class="list-icons">
				                <a class="list-icons-item" data-action="collapse"></a>
				            </div>
				        </div>
				    </div>

				    <div class="card-body">
				        <ul class="nav nav-tabs nav-tabs-solid nav-justified border-0">
				            <li class="nav-item"><a href="#solid-justified-tab1" class="nav-link active legitRipple" data-toggle="tab">Амбулаторный пациенты</a></li>
				            <li class="nav-item"><a href="#solid-justified-tab2" class="nav-link legitRipple" data-toggle="tab">Стационар пациенты</a></li>
				        </ul>

				        <div class="tab-content">
				            <div class="tab-pane fade show active" id="solid-justified-tab1">
				                <!-- Multiple rows selection -->
				                <div class="card">
				                    <div class="card-header header-elements-inline">
				                        <h5 class="card-title">Информация о пациенты</h5>
				                        <div class="header-elements">
				                            <div class="list-icons">
				                                <a class="list-icons-item" data-action="reload"></a>
				                            </div>
				                        </div>
				                    </div>
				                    <table class="table datatable-selection-multiple">
				                        <thead>
				                            <tr class="bg-blue text-center">
				                                <th>ID</th>
				                                <th>ФИО</th>
				                                <th>Дата и время</th>

				                                <th>Возраст</th>
				                                <th>Мед услуги</th>
				                                <th>Тип визита</th>
				                                <th>Отправитель</th>
				                                <th class="text-center">Действия</th>
				                            </tr>
				                        </thead>
				                        <tbody>
				                            <tr>
				                                <td>0001</td>
				                                <td>Якубов Фарход Абдурасуловия</td>
				                                <td>13.03.2020 13:04</td>

				                                <td>33</td>
				                                <td>Общий анализ крови</td>
				                                <td>Амбулатор</td>
				                                <td>Мирзаева А</td>
				                                <td class="text-center">
				                                    <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="icon-eye mr-2"></i> Просмотр</button>
				                                    <div class="dropdown-menu dropdown-menu-right" x-placement="top-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(906px, 33px, 0px);">
				                                        <a href="#" class="dropdown-item btn btn-light legitRipple" data-toggle="modal" data-target="#modal_mini"><i class="icon-user-plus"></i>печатать штрих</a>
				                                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_default2"><i class="icon-fire2"></i> Добавить резултаты</a>
				                                    </div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td>0001</td>
				                                <td>Якубов Фарход Абдурасуловия</td>
				                                <td>13.03.2020 13:04</td>

				                                <td>33</td>
				                                <td>Общий анализ крови</td>
				                                <td>Амбулатор</td>
				                                <td>Мирзаева А</td>
				                                <td class="text-center">
				                                    <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
				                                    <div class="dropdown-menu dropdown-menu-right">
				                                        <a href="#" class="dropdown-item btn btn-light legitRipple" data-toggle="modal" data-target="#modal_mini"><i class="icon-user-plus"></i>печатать штрих</a>
				                                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_default2"><i class="icon-fire2"></i> Добавить резултаты</a>
				                                    </div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td>0001</td>
				                                <td>Якубов Фарход Абдурасуловия</td>
				                                <td>13.03.2020 13:04</td>

				                                <td>33</td>
				                                <td>Общий анализ крови</td>
				                                <td>Амбулатор</td>
				                                <td>Мирзаева А</td>
				                                <td class="text-center">
				                                    <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
				                                    <div class="dropdown-menu dropdown-menu-right">
				                                        <a href="#" class="dropdown-item btn btn-light legitRipple" data-toggle="modal" data-target="#modal_mini"><i class="icon-user-plus"></i>печатать штрих</a>
				                                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_default2"><i class="icon-fire2"></i> Добавить резултаты</a>
				                                    </div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td>0001</td>
				                                <td>Якубов Фарход Абдурасуловия</td>
				                                <td>13.03.2020 13:04</td>

				                                <td>33</td>
				                                <td>Общий анализ крови</td>
				                                <td>Амбулатор</td>
				                                <td>Мирзаева А</td>
				                                <td class="text-center">
				                                    <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
				                                    <div class="dropdown-menu dropdown-menu-right">
				                                        <a href="#" class="dropdown-item btn btn-light legitRipple" data-toggle="modal" data-target="#modal_mini"><i class="icon-user-plus"></i>печатать штрих</a>
				                                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_default2"><i class="icon-fire2"></i> Добавить резултаты</a>
				                                    </div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td>0001</td>
				                                <td>Якубов Фарход Абдурасуловия</td>
				                                <td>13.03.2020 13:04</td>

				                                <td>33</td>
				                                <td>Общий анализ крови</td>
				                                <td>Амбулатор</td>
				                                <td>Мирзаева А</td>
				                                <td class="text-center">
				                                    <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
				                                    <div class="dropdown-menu dropdown-menu-right">
				                                        <a href="#" class="dropdown-item btn btn-light legitRipple" data-toggle="modal" data-target="#modal_mini"><i class="icon-user-plus"></i>печатать штрих</a>
				                                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_default2"><i class="icon-fire2"></i> Добавить резултаты</a>
				                                    </div>
				                                </td>
				                            </tr>
				                        </tbody>
				                    </table>
				                </div>
				                <!-- /multiple rows selection -->
				            </div>

				            <div class="tab-pane fade" id="solid-justified-tab2">
				                <div class="card">
				                    <div class="card-header header-elements-inline">
				                        <h5 class="card-title">Информация о пациенты</h5>
				                        <div class="header-elements">
				                            <div class="list-icons">
				                                <a class="list-icons-item" data-action="reload"></a>
				                            </div>
				                        </div>
				                    </div>

				                    <table class="table datatable-selection-multiple">
				                        <thead>
				                            <tr class="bg-blue text-center">
				                                <th>ID</th>
				                                <th>ФИО</th>
				                                <th>Дата и время</th>

				                                <th>Возраст</th>
				                                <th>Мед услуги</th>
				                                <th>Тип визита</th>
				                                <th>Отправитель</th>
				                                <th class="text-center">Действия</th>
				                            </tr>
				                        </thead>
				                        <tbody>
				                            <tr>
				                                <td>0001</td>
				                                <td>Якубов Фарход Абдурасуловия</td>
				                                <td>13.03.2020 13:04</td>

				                                <td>33</td>
				                                <td>Общий анализ крови</td>
				                                <td>Стационар</td>
				                                <td>Ахмедов Ш</td>
				                                <td class="text-center">
				                                    <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
				                                    <div class="dropdown-menu dropdown-menu-right">
				                                        <a href="#" class="dropdown-item btn btn-light legitRipple" data-toggle="modal" data-target="#modal_mini"><i class="icon-user-plus"></i>печатать штрих</a>
				                                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_default2"><i class="icon-fire2"></i> Добавить резултаты</a>
				                                    </div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td>0001</td>
				                                <td>Якубов Фарход Абдурасуловия</td>
				                                <td>13.03.2020 13:04</td>

				                                <td>33</td>
				                                <td>Общий анализ крови</td>
				                                <td>Стационар</td>
				                                <td>Ахмедов Ш</td>
				                                <td class="text-center">
				                                    <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
				                                    <div class="dropdown-menu dropdown-menu-right">
				                                        <a href="#" class="dropdown-item btn btn-light legitRipple" data-toggle="modal" data-target="#modal_mini"><i class="icon-user-plus"></i>печатать штрих</a>
				                                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_default2"><i class="icon-fire2"></i> Добавить резултаты</a>
				                                    </div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td>0001</td>
				                                <td>Якубов Фарход Абдурасуловия</td>
				                                <td>13.03.2020 13:04</td>

				                                <td>33</td>
				                                <td>Общий анализ крови</td>
				                                <td>Стационар</td>
				                                <td>Ахмедов Ш</td>
				                                <td class="text-center">
				                                    <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
				                                    <div class="dropdown-menu dropdown-menu-right">
				                                        <a href="#" class="dropdown-item btn btn-light legitRipple" data-toggle="modal" data-target="#modal_mini"><i class="icon-user-plus"></i>печатать штрих</a>
				                                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_default2"><i class="icon-fire2"></i> Добавить резултаты</a>
				                                    </div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td>0001</td>
				                                <td>Якубов Фарход Абдурасуловия</td>
				                                <td>13.03.2020 13:04</td>

				                                <td>33</td>
				                                <td>Общий анализ крови</td>
				                                <td>Стационар</td>
				                                <td>Ахмедов Ш</td>
				                                <td class="text-center">
				                                    <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
				                                    <div class="dropdown-menu dropdown-menu-right">
				                                        <a href="#" class="dropdown-item btn btn-light legitRipple" data-toggle="modal" data-target="#modal_mini"><i class="icon-user-plus"></i>печатать штрих</a>
				                                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_default2"><i class="icon-fire2"></i> Добавить резултаты</a>
				                                    </div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td>0001</td>
				                                <td>Якубов Фарход Абдурасуловия</td>
				                                <td>13.03.2020 13:04</td>

				                                <td>33</td>
				                                <td>Общий анализ крови</td>
				                                <td>Стационар</td>
				                                <td>Ахмедов Ш</td>
				                                <td class="text-center">
				                                    <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
				                                    <div class="dropdown-menu dropdown-menu-right">
				                                        <a href="#" class="dropdown-item btn btn-light legitRipple" data-toggle="modal" data-target="#modal_mini"><i class="icon-user-plus"></i>печатать штрих</a>
				                                        <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal_default2"><i class="icon-fire2"></i> Добавить резултаты</a>
				                                    </div>
				                                </td>
				                            </tr>
				                        </tbody>
				                    </table>
				                </div>
				            </div>
				        </div>
				    </div>
				</div>
				<div id="modal_default2" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
				    <div class="modal-dialog modal-full">
				        <div class="modal-content">
				            <div class="modal-header">
				                <h5 class="modal-title">
				                    Анализы пациента:<b><p>Якубов Фарход</p></b>
				                </h5>
				                <button type="button" class="close" data-dismiss="modal"></button>
				            </div>

				            <div class="modal-body">
				                <div class="table-responsive">
				                    <table class="table">
				                        <thead>
				                            <tr class="bg-blue">
				                                <th>ID</th>
				                                <th>Дата и время</th>

				                                <th>Имя анализа</th>
				                                <th>Специалист</th>
				                                <th class="text-center">Результаты</th>
				                                <th>Норматив</th>
				                                <th>Примечание</th>
				                            </tr>
				                        </thead>
				                        <tbody>
				                            <tr>
				                                <td>0001</td>
				                                <td>13.03.2020 13:03</td>

				                                <td>Анализ мочи</td>
				                                <td>Ахмедова З</td>
				                                <td>
				                                    <div class="form-group row">
				                                        <label class="col-form-label col-md-3"></label>
				                                        <div class="col-md-5">
				                                            <input type="text" class="form-control font-weight-bold text-center" />
				                                        </div>
				                                    </div>
				                                </td>
				                                <td>10</td>
				                                <td>
				                                    <div class="form-group row">
				                                        <label class="col-form-label col-md-3"></label>
				                                        <div class="col-md-12">
				                                            <textarea rows="1" cols="3" class="form-control" placeholder="Примечание"></textarea>
				                                        </div>
				                                    </div>
				                                </td>
				                            </tr>

				                            <tr>
				                                <td>0001</td>
				                                <td>13.03.2020 13:03</td>

				                                <td>Анализ мочи</td>
				                                <td>Ахмедова З</td>
				                                <td>
				                                    <div class="form-group row">
				                                        <label class="col-form-label col-md-3"></label>
				                                        <div class="col-md-5">
				                                            <input type="text" class="form-control font-weight-bold text-center" />
				                                        </div>
				                                    </div>
				                                </td>
				                                <td>10</td>
				                                <td>
				                                    <div class="form-group row">
				                                        <label class="col-form-label col-md-3"></label>
				                                        <div class="col-md-12">
				                                            <textarea rows="1" cols="3" class="form-control" placeholder="Примечание"></textarea>
				                                        </div>
				                                    </div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td>0001</td>
				                                <td>13.03.2020 13:03</td>
				                                <td>Анализ мочи</td>
				                                <td>Ахмедова З</td>
				                                <td>
				                                    <div class="form-group row">
				                                        <label class="col-form-label col-md-3"></label>
				                                        <div class="col-md-5">
				                                            <input type="text" class="form-control font-weight-bold text-center" />
				                                        </div>
				                                    </div>
				                                </td>
				                                <td>10</td>
				                                <td>
				                                    <div class="form-group row">
				                                        <label class="col-form-label col-md-3"></label>
				                                        <div class="col-md-12">
				                                            <textarea rows="1" cols="3" class="form-control" placeholder="Примечание"></textarea>
				                                        </div>
				                                    </div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td>0001</td>
				                                <td>13.03.2020 13:03</td>
				                                <td>Анализ мочи</td>
				                                <td>Ахмедова З</td>
				                                <td>
				                                    <div class="form-group row">
				                                        <label class="col-form-label col-md-3"></label>
				                                        <div class="col-md-12">
				                                            <input type="text" class="form-control font-weight-bold text-center" />
				                                        </div>
				                                    </div>
				                                </td>
				                                <td>10</td>
				                                <td>
				                                    <div class="form-group row">
				                                        <label class="col-form-label col-md-3"></label>
				                                        <div class="col-md-12">
				                                            <textarea rows="1" cols="3" class="form-control" placeholder="Примечание"></textarea>
				                                        </div>
				                                    </div>
				                                </td>
				                            </tr>
				                        </tbody>
				                    </table>
				                </div>
				            </div>

				            <div class="modal-footer">
				                <button type="button" class="btn btn-link legitRipple" data-dismiss="modal">Сохранить</button>
				                <button type="button" class="btn btn-link legitRipple" data-dismiss="modal">Завершить</button>
				            </div>
				        </div>
				    </div>
				</div>
				<div id="modal_mini" class="modal fade" tabindex="-1" style="display: none;" aria-hidden="true">
				    <div class="modal-dialog modal-xs">
				        <div class="modal-content">
				            <div class="modal-header">
				                <h5 class="modal-title">печать на пробирку</h5>
				                <button type="button" class="close" data-dismiss="modal">×</button>
				            </div>

				            <div class="modal-body">
				                <h6 class="font-weight-semibold">Данные пациента</h6>
				                <p>ID пациента</p>
				                <p>ФИО</p>
				                <p>Дата и время</p>
				                <p>Дата рождение</p>
				            </div>

				            <div class="modal-footer">
				                <button type="button" class="btn btn-link legitRipple" data-dismiss="modal">
				                    Закрыть
				                    <div class="legitRipple-ripple" style="left: 46.8524%; top: 44.1228%; transform: translate3d(-50%, -50%, 0px); width: 215.559%; opacity: 0;"></div>
				                </button>
				                <button type="button" class="btn bg-primary legitRipple">печатать</button>
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





    <!-- Footer -->
    <?php include 'layout/footer.php' ?>
    <!-- /footer -->

</body>
</html>
