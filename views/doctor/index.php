
<?php
require_once '../../tools/warframe.php';
is_auth();
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>
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
				        <h6 class="card-title">Информация о пациенты</h6>
				        <div class="header-elements">
				            <div class="list-icons"></div>
				        </div>
				    </div>

				    <div class="card-body">
				        <ul class="nav nav-tabs nav-tabs-solid nav-justified nav-tabs-solid border-0 rounded">
				            <li class="nav-item"><a href="#colored-rounded-justified-tab1" class="nav-link rounded-left legitRipple active show" data-toggle="tab">Амбулаторные пациенти</a></li>
				            <li class="nav-item"><a href="#colored-rounded-justified-tab2" class="nav-link legitRipple" data-toggle="tab">Стационарные пациенти</a></li>
				            <li class="nav-item"><a href="#colored-rounded-justified-tab3" class="nav-link legitRipple" data-toggle="tab">Операционные пациенти</a></li>
				        </ul>

				        <div class="tab-content">
				            <div class="tab-pane fade active show" id="colored-rounded-justified-tab1">
				                <div class="card">
				                    <div class="card-header header-elements-inline">
				                        <h5 class="card-title">Амбулаторные пациенти</h5>
				                        <button type="button" id="jgrowl-custom-styled" class="btn bg-teal-400 btn-labeled btn-labeled-left rounded-round legitRipple">
				                            <b> <i class="icon-reading"></i></b>Принять пациента
				                            <div class="legitRipple-ripple" style="left: 58.2006%; top: 52.6316%; transform: translate3d(-50%, -50%, 0px); width: 207.838%; opacity: 0;"></div>
				                            <span class="badge bg-pink-400 rounded-circle badge-icon"><i class="icon-bell3"></i></span>
				                        </button>
				                        <div class="header-elements">
				                            <div class="list-icons">
				                                <a class="list-icons-item" data-action="reload"></a>
				                            </div>
				                        </div>
				                    </div>
				                    <table class="table table-hover table-columned">
				                        <thead>
				                            <tr class="bg-blue text-center">
				                                <th>ID</th>
				                                <th>ФИО</th>

				                                <th>Дата визита</th>
				                                <th>Возраст</th>
				                                <th>Мед услуга</th>
				                                <th>Тип визита</th>
				                                <th>Направление</th>
				                                <th class="text-center">Действия</th>
				                            </tr>
				                        </thead>
				                        <tbody>
				                            <tr>
				                                <td>1</td>
				                                <td>2</td>

				                                <td>5</td>
				                                <td>6</td>
				                                <td>7</td>
				                                <td>8</td>
				                                <td>9</td>
				                                <td class="text-center">
				                                    <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
				                                    <div class="dropdown-menu dropdown-menu-right">
				                                        <a href="outpatient.php" class="dropdown-item"><i class="icon-fire2"></i> Анализи Лаборатория</a>
				                                        <a href="#" class="dropdown-item"><i class="icon-add"></i> Добавить визит</a>
				                                        <a href="#" class="dropdown-item"><i class="icon-repo-forked"></i> Осмотр Врача</a>
				                                        <a href="#" class="dropdown-item"><i class="icon-plus-circle2"></i> Другие визити</a>
				                                    </div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td>1</td>
				                                <td>2</td>

				                                <td>5</td>
				                                <td>5</td>
				                                <td>6</td>
				                                <td>7</td>
				                                <td>8</td>
				                                <td class="text-center">
				                                    <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>				  <div class="dropdown-menu dropdown-menu-right">
				                                        <a href="outpatient.php" class="dropdown-item"><i class="icon-fire2"></i> Анализи Лаборатория</a>
				                                        <a href="#" class="dropdown-item"><i class="icon-add"></i> Добавить визит</a>
				                                        <a href="#" class="dropdown-item"><i class="icon-repo-forked"></i> Осмотр Врача</a>
				                                        <a href="#" class="dropdown-item"><i class="icon-plus-circle2"></i> Другие визити</a>
				                                    </div>
				                                </td>
				                            </tr>
				                        </tbody>
				                    </table>
				                </div>
				            </div>
				            <div class="tab-pane fade" id="colored-rounded-justified-tab2">
				                <div class="card">
				                    <div class="card-header header-elements-inline">
				                        <h5 class="card-title">Стационарные пациенти</h5>
				                        <button type="button" class="btn bg-teal-400 btn-labeled btn-labeled-left rounded-round legitRipple">
				                            <b> <i class="icon-reading"></i></b>Принять пациента
				                            <div class="legitRipple-ripple" style="left: 58.2006%; top: 52.6316%; transform: translate3d(-50%, -50%, 0px); width: 207.838%; opacity: 0;"></div>
				                            <span class="badge bg-pink-400 rounded-circle badge-icon"><i class="icon-bell3"></i></span>
				                        </button>
				                        <div class="header-elements">
				                            <div class="list-icons">
				                                <a class="list-icons-item" data-action="collapse"></a>
				                                <a class="list-icons-item" data-action="reload"></a>
				                            </div>
				                        </div>
				                    </div>
				                    <table class="table table-hover table-columned">
				                        <thead>
				                            <tr class="bg-blue text-center">
				                                <th>ID</th>
				                                <th>Имя</th>
				                                <th>Фамилия</th>
				                                <th>Отчество</th>
				                                <th>Дата визита</th>
				                                <th>Суток</th>
				                                <th>Койка</th>
				                                <th>Возраст</th>
				                                <th class="text-center">Действия</th>
				                            </tr>
				                        </thead>
				                        <tbody>
				                            <tr>
				                                <td>1</td>
				                                <td>2</td>
				                                <td>3</td>
				                                <td>4</td>
				                                <td>5</td>
				                                <td>6</td>
				                                <td>7</td>
				                                <td>8</td>
				                                <td class="text-center">
				                                    <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
				                                    <div class="dropdown-menu dropdown-menu-right">
				                                        <a href="hospital.php" class="dropdown-item"><i class="icon-user-plus"></i>Обход</a>
				                                        <a href="#" class="dropdown-item"><i class="icon-fire2"></i> Анализи Лаборатория</a>
				                                        <a href="#" class="dropdown-item"><i class="icon-clipboard3"></i>Назначение врача</a>
				                                        <a href="#" class="dropdown-item"><i class="icon-clipboard2"></i> Записи медсестры</a>
				                                        <a href="#" class="dropdown-item"><i class="icon-diff-ignored"></i> Анестизиолог</a>
				                                        <a href="#" class="dropdown-item"><i class="icon-file-eye"></i> Операционные</a>
				                                    </div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td>1</td>
				                                <td>2</td>
				                                <td>3</td>
				                                <td>4</td>
				                                <td>5</td>
				                                <td>6</td>
				                                <td>7</td>
				                                <td>8</td>
				                                <td class="text-center">
				                                    <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
				                                    <div class="dropdown-menu dropdown-menu-right">
				                                        <a href="hospital" class="dropdown-item"><i class="icon-user-plus"></i>Обход</a>
				                                        <a href="#" class="dropdown-item"><i class="icon-fire2"></i> Анализи Лаборатория</a>
				                                        <a href="#" class="dropdown-item"><i class="icon-clipboard3"></i>Назначение врача</a>
				                                        <a href="#" class="dropdown-item"><i class="icon-clipboard2"></i> Записи медсестры</a>
				                                        <a href="#" class="dropdown-item"><i class="icon-diff-ignored"></i> Анестизиолог</a>
				                                        <a href="#" class="dropdown-item"><i class="icon-file-eye"></i> Операционные</a>
				                                    </div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td>1</td>
				                                <td>2</td>
				                                <td>3</td>
				                                <td>4</td>
				                                <td>5</td>
				                                <td>6</td>
				                                <td>7</td>
				                                <td>8</td>
				                                <td class="text-center">
				                                    <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
				                                    <div class="dropdown-menu dropdown-menu-right">
				                                        <a href="#" class="dropdown-item"><i class="icon-user-plus"></i>Обход</a>
				                                        <a href="#" class="dropdown-item"><i class="icon-fire2"></i> Анализи Лаборатория</a>
				                                        <a href="#" class="dropdown-item"><i class="icon-clipboard3"></i>Назначение врача</a>
				                                        <a href="#" class="dropdown-item"><i class="icon-clipboard2"></i> Записи медсестры</a>
				                                        <a href="#" class="dropdown-item"><i class="icon-diff-ignored"></i> Анестизиолог</a>
				                                        <a href="#" class="dropdown-item"><i class="icon-file-eye"></i> Операционные</a>
				                                    </div>
				                                </td>
				                            </tr>
				                        </tbody>
				                    </table>
				                </div>
				            </div>
				            <div class="tab-pane fade" id="colored-rounded-justified-tab3">
				                <div class="card">
				                    <div class="card-header header-elements-inline">
				                        <h5 class="card-title">Операционные пациенти</h5>
				                        <div class="header-elements">
				                            <div class="list-icons">
				                                <a class="list-icons-item" data-action="collapse"></a>
				                                <a class="list-icons-item" data-action="reload"></a>
				                            </div>
				                        </div>
				                    </div>
				                    <table class="table table-hover table-columned">
				                        <thead>
				                            <tr class="bg-blue text-center">
				                                <th>ID</th>
				                                <th>ФИО</th>

				                                <th>Дата рождение</th>
				                                <th>Отделение</th>
				                                <th>Тип операции</th>
				                                <th>Дата операции</th>
				                                <th>Койка</th>
				                                <th class="text-center">Действия</th>
				                            </tr>
				                        </thead>
				                        <tbody>
				                            <tr>
				                                <td>0001</td>
				                                <td>Якубов Фарход Абдурасулович</td>

				                                <td>19.04.1988</td>
				                                <td>Неврология</td>
				                                <td>Грижа диска</td>
				                                <td>13.03.2020 13:03</td>
				                                <td>3-палата</td>
				                                <td class="text-center">
				                                    <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
				                                    <div class="dropdown-menu dropdown-menu-right">
				                                        <a href="#" class="dropdown-item"><i class="icon-menu7"></i> Редактировать</a>
				                                    </div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td>1</td>
				                                <td>2</td>

				                                <td>5</td>
				                                <td>6</td>
				                                <td>7</td>
				                                <td>8</td>
				                                <td>9</td>
				                                <td class="text-center">
				                                    <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
				                                    <div class="dropdown-menu dropdown-menu-right">
				                                        <a href="#" class="dropdown-item"><i class="icon-menu7"></i> Редактировать</a>
				                                    </div>
				                                </td>
				                            </tr>
				                            <tr>
				                                <td>1</td>
				                                <td>2</td>

				                                <td>5</td>
				                                <td>6</td>
				                                <td>7</td>
				                                <td>8</td>
				                                <td>9</td>
				                                <td class="text-center">
				                                    <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
				                                    <div class="dropdown-menu dropdown-menu-right">
				                                        <a href="#" class="dropdown-item"><i class="icon-menu7"></i> Редактировать</a>
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
