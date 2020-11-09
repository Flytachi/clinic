<?php
require_once '../../tools/warframe.php';
is_auth();
?>
<!DOCTYPE html>
<html lang="en">
<?php include '../layout/head.php' ?>

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
				        <h6 class="card-title">Просмотр визита</h6>
				        <span>ФИО-0008-Палата №5 - Койка -4</span>
				        <div class="header-elements">
				            <div class="list-icons">
				                <a class="list-icons-item" data-action="collapse"></a>
				                <a class="list-icons-item" data-action="reload"></a>
				            </div>
				        </div>
				    </div>

				    <div class="card-body">
				        <ul class="nav nav-tabs nav-tabs-highlight">
				            <li class="nav-item">
				                <a href="#right-icon-tab1" class="nav-link legitRipple" data-toggle="tab">История пациента <i class="icon-nbsp ml-3"></i></a>
				            </li>
				            <li class="nav-item">
				                <a href="#right-icon-tab2" class="nav-link legitRipple" data-toggle="tab">Анализи Лаборатория <i class="icon-compose ml-3"></i></a>
				            </li>
				            <li class="nav-item">
				                <a href="#right-icon-tab4" class="nav-link legitRipple" data-toggle="tab">Добавить Записки <i class="icon-users4 ml-3"></i></a>
				            </li>
				            <li class="nav-item">
				                <a href="#right-icon-tab5" class="nav-link legitRipple" data-toggle="tab">Записки врача <i class="icon-user-plus ml-3"></i></a>
				            </li>
				            <li class="nav-item">
				                <a href="#right-icon-tab6" class="nav-link legitRipple active show" data-toggle="tab">Блюда <i class="icon-spinner11 ml-3"></i></a>
				            </li>
				            <li class="nav-item">
				                <a href="#right-icon-tab7" class="nav-link legitRipple" data-toggle="tab">Состаение <i class="icon-bubble9 ml-3"></i></a>
				            </li>
				        </ul>

				        <div class="tab-content">
				            <div class="tab-pane fade" id="right-icon-tab1">
				                <div class="mb-4">
				                    <h6 class="font-weight-semibold" id="scrollspy-options">История пациента</h6>
				                    <div class="table-responsive">
				                        <table class="table table-bordered">
				                            <thead>
				                                <tr>
				                                    <th>Дата и время</th>
				                                    <th>Группы</th>
				                                    <th>Специалист</th>
				                                    <th>Примечаниеы</th>
				                                </tr>
				                            </thead>
				                            <tbody>
				                                <tr>
				                                    <td><button type="button" class="btn btn-light legitRipple" data-toggle="modal" data-target="#modal_default">13.03.2020 15:08</button></td>
				                                    <td>Лаборатория</td>
				                                    <td>Камолов Ш</td>
				                                    <td>тесттесттесттесттесттесттесттесттесттесттесттесттесттесттесттест</td>
				                                </tr>
				                            </tbody>
				                        </table>
				                    </div>
				                </div>
				                <!-- Basic modal -->
				                <div id="modal_default" class="modal fade" tabindex="-1">
				                    <div class="modal-dialog">
				                        <div class="modal-content">
				                            <div class="modal-header">
				                                <h5 class="modal-title">История пациента подробно</h5>
				                                <button type="button" class="close" data-dismiss="modal">×</button>
				                            </div>

				                            <div class="modal-body">
				                                <ul>
				                                    <li><b>Группа</b> - Лаборатория</li>
				                                    <li><b>Специалист</b> - Камолов.Ш</li>
				                                    <li><b>Примечание</b> - тесттесттесттесттесттесттесттесттесттесттесттесттесттесттесттест</li>
				                                </ul>
				                            </div>

				                            <div class="modal-footer">
				                                <button type="button" class="btn btn-link legitRipple" data-dismiss="modal">Закрыть</button>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				                <!-- /basic modal -->
				            </div>
				            <div class="tab-pane fade" id="right-icon-tab2">
				                <div class="table-responsive">
				                    <table class="table">
				                        <thead>
				                            <tr class="bg-blue">
				                                <th>ID</th>
				                                <th>Имя анализа</th>
				                                <th>Специалист</th>
				                                <th>Результаты</th>
				                                <th>Норматив</th>
				                                <th>Примечание</th>
				                            </tr>
				                        </thead>
				                        <tbody>
				                            <tr>
				                                <td>0001</td>
				                                <td>Анализ мочи</td>
				                                <td>Ахмедова З</td>
				                                <td>10-12</td>
				                                <td>10</td>
				                                <td>10</td>
				                            </tr>
				                            <tr>
				                                <td>0001</td>
				                                <td>Анализ мочи</td>
				                                <td>Ахмедова З</td>
				                                <td>10-12</td>
				                                <td>10</td>
				                                <td>10</td>
				                            </tr>
				                            <tr>
				                                <td>0001</td>
				                                <td>Анализ мочи</td>
				                                <td>Ахмедова З</td>
				                                <td>10-12</td>
				                                <td>10</td>
				                                <td>10</td>
				                            </tr>
				                            <tr>
				                                <td>0001</td>
				                                <td>Анализ мочи</td>
				                                <td>Ахмедова З</td>
				                                <td>10-12</td>
				                                <td>10</td>
				                            </tr>
				                        </tbody>
				                    </table>
				                </div>
				            </div>

				            <div class="tab-pane fade" id="right-icon-tab4">
				                <!-- Summernote click to edit -->
				                <div class="card">
				                    <div class="card-header header-elements-inline">
				                        <h5 class="card-title">Добавить записи</h5>
				                        <div class="header-elements">
				                            <div class="list-icons">
				                                <a class="list-icons-item" data-action="collapse"></a>
				                                <a class="list-icons-item" data-action="reload"></a>
				                                <a class="list-icons-item" data-action="remove"></a>
				                            </div>
				                        </div>
				                    </div>

				                    <div class="card-body">
				                        <div class="form-group">
				                            <button type="button" id="edit" class="btn btn-primary legitRipple"><i class="icon-pencil3 mr-2"></i> Редактировать</button>
				                            <button type="button" id="save" class="btn btn-success legitRipple"><i class="icon-checkmark3 mr-2"></i> Сохранить</button>
				                        </div>

				                        <div class="click2edit">
				                            <h2>Apollo 11</h2>
				                            <div class="float-right" style="margin-left: 20px;"><img alt="Saturn V carrying Apollo 11" class="right" src="http://c.cksource.com/a/1/img/sample.jpg" /></div>

				                            <p>
				                                <strong>Apollo 11</strong> was the spaceflight that landed the first humans, Americans <a href="#">Neil Armstrong</a> and <a href="#">Buzz Aldrin</a>, on the Moon on July 20, 1969, at 20:18 UTC. Armstrong
				                                became the first to step onto the lunar surface 6 hours later on July 21 at 02:56 UTC.
				                            </p>

				                            <p class="mb-3">
				                                Armstrong spent about <s>three and a half</s> two and a half hours outside the spacecraft, Aldrin slightly less; and together they collected 47.5 pounds (21.5&nbsp;kg) of lunar material for return to
				                                Earth. A third member of the mission, <a href="#">Michael Collins</a>, piloted the <a href="#">command</a> spacecraft alone in lunar orbit until Armstrong and Aldrin returned to it for the trip back to
				                                Earth.
				                            </p>

				                            <h5 class="font-weight-semibold">Technical details</h5>
				                            <p>
				                                Launched by a <strong>Saturn V</strong> rocket from <a href="#">Kennedy Space Center</a> in Merritt Island, Florida on July 16, Apollo 11 was the fifth manned mission of <a href="#">NASA</a>'s Apollo
				                                program. The Apollo spacecraft had three parts:
				                            </p>
				                            <ol>
				                                <li><strong>Command Module</strong> with a cabin for the three astronauts which was the only part which landed back on Earth</li>
				                                <li><strong>Service Module</strong> which supported the Command Module with propulsion, electrical power, oxygen and water</li>
				                                <li><strong>Lunar Module</strong> for landing on the Moon.</li>
				                            </ol>
				                            <p class="mb-3">
				                                After being sent to the Moon by the Saturn V's upper stage, the astronauts separated the spacecraft from it and travelled for three days until they entered into lunar orbit. Armstrong and Aldrin then
				                                moved into the Lunar Module and landed in the <a href="#">Sea of Tranquility</a>. They stayed a total of about 21 and a half hours on the lunar surface. After lifting off in the upper part of the Lunar
				                                Module and rejoining Collins in the Command Module, they returned to Earth and landed in the <a href="#">Pacific Ocean</a> on July 24.
				                            </p>

				                            <h5 class="font-weight-semibold">Mission crew</h5>
				                            <div class="card card-table table-responsive shadow-0">
				                                <table class="table table-bordered">
				                                    <thead>
				                                        <tr>
				                                            <th>Position</th>
				                                            <th>Astronaut</th>
				                                        </tr>
				                                    </thead>
				                                    <tbody>
				                                        <tr>
				                                            <td>Commander</td>
				                                            <td>Neil A. Armstrong</td>
				                                        </tr>
				                                        <tr>
				                                            <td>Command Module Pilot</td>
				                                            <td>Michael Collins</td>
				                                        </tr>
				                                        <tr>
				                                            <td>Lunar Module Pilot</td>
				                                            <td>Edwin "Buzz" E. Aldrin, Jr.</td>
				                                        </tr>
				                                    </tbody>
				                                </table>
				                            </div>

				                            Source: <a href="http://en.wikipedia.org/wiki/Apollo_11">Wikipedia.org</a>
				                        </div>
				                    </div>
				                </div>
				                <!-- /summernote click to edit -->
				            </div>
				            <div class="tab-pane fade" id="right-icon-tab5">
				                <!-- Summernote click to edit -->
				                <div class="card">
				                    <div class="card-header header-elements-inline">
				                        <h5 class="card-title">Добавить записи</h5>
				                        <div class="header-elements">
				                            <div class="list-icons">
				                                <a class="list-icons-item" data-action="collapse"></a>
				                                <a class="list-icons-item" data-action="reload"></a>
				                                <a class="list-icons-item" data-action="remove"></a>
				                            </div>
				                        </div>
				                    </div>

				                    <div class="card-body">
				                        <div class="form-group">
				                            <button type="button" id="edit" class="btn btn-primary legitRipple"><i class="icon-pencil3 mr-2"></i> Редактировать</button>
				                            <button type="button" id="save" class="btn btn-success legitRipple"><i class="icon-checkmark3 mr-2"></i> Сохранить</button>
				                        </div>

				                        <div class="click2edit">
				                            <h2>Apollo 11</h2>
				                            <div class="float-right" style="margin-left: 20px;"><img alt="Saturn V carrying Apollo 11" class="right" src="http://c.cksource.com/a/1/img/sample.jpg" /></div>

				                            <p>
				                                <strong>Apollo 11</strong> was the spaceflight that landed the first humans, Americans <a href="#">Neil Armstrong</a> and <a href="#">Buzz Aldrin</a>, on the Moon on July 20, 1969, at 20:18 UTC. Armstrong
				                                became the first to step onto the lunar surface 6 hours later on July 21 at 02:56 UTC.
				                            </p>

				                            <p class="mb-3">
				                                Armstrong spent about <s>three and a half</s> two and a half hours outside the spacecraft, Aldrin slightly less; and together they collected 47.5 pounds (21.5&nbsp;kg) of lunar material for return to
				                                Earth. A third member of the mission, <a href="#">Michael Collins</a>, piloted the <a href="#">command</a> spacecraft alone in lunar orbit until Armstrong and Aldrin returned to it for the trip back to
				                                Earth.
				                            </p>

				                            <h5 class="font-weight-semibold">Technical details</h5>
				                            <p>
				                                Launched by a <strong>Saturn V</strong> rocket from <a href="#">Kennedy Space Center</a> in Merritt Island, Florida on July 16, Apollo 11 was the fifth manned mission of <a href="#">NASA</a>'s Apollo
				                                program. The Apollo spacecraft had three parts:
				                            </p>
				                            <ol>
				                                <li><strong>Command Module</strong> with a cabin for the three astronauts which was the only part which landed back on Earth</li>
				                                <li><strong>Service Module</strong> which supported the Command Module with propulsion, electrical power, oxygen and water</li>
				                                <li><strong>Lunar Module</strong> for landing on the Moon.</li>
				                            </ol>
				                            <p class="mb-3">
				                                After being sent to the Moon by the Saturn V's upper stage, the astronauts separated the spacecraft from it and travelled for three days until they entered into lunar orbit. Armstrong and Aldrin then
				                                moved into the Lunar Module and landed in the <a href="#">Sea of Tranquility</a>. They stayed a total of about 21 and a half hours on the lunar surface. After lifting off in the upper part of the Lunar
				                                Module and rejoining Collins in the Command Module, they returned to Earth and landed in the <a href="#">Pacific Ocean</a> on July 24.
				                            </p>

				                            <h5 class="font-weight-semibold">Mission crew</h5>
				                            <div class="card card-table table-responsive shadow-0">
				                                <table class="table table-bordered">
				                                    <thead>
				                                        <tr>
				                                            <th>Position</th>
				                                            <th>Astronaut</th>
				                                        </tr>
				                                    </thead>
				                                    <tbody>
				                                        <tr>
				                                            <td>Commander</td>
				                                            <td>Neil A. Armstrong</td>
				                                        </tr>
				                                        <tr>
				                                            <td>Command Module Pilot</td>
				                                            <td>Michael Collins</td>
				                                        </tr>
				                                        <tr>
				                                            <td>Lunar Module Pilot</td>
				                                            <td>Edwin "Buzz" E. Aldrin, Jr.</td>
				                                        </tr>
				                                    </tbody>
				                                </table>
				                            </div>

				                            Source: <a href="http://en.wikipedia.org/wiki/Apollo_11">Wikipedia.org</a>
				                        </div>
				                    </div>
				                </div>
				                <!-- /summernote click to edit -->
				            </div>
				            <div class="tab-pane fade active show" id="right-icon-tab6">
				                <h4 class="card-title">Добавить блюдо</h4>
				                <button type="button" class="btn btn-light legitRipple" data-toggle="modal" data-target="#modal_default22">Выбрать <i class="icon-play3 ml-2"></i></button>
				                <p></p>
				                <div class="table-responsive">
				                    <table class="table">
				                        <thead>
				                            <tr class="bg-blue">
				                                <th>Питание</th>
				                                <th>Дата и время</th>
				                                <th>Категория</th>
				                                <th>Медсестра ФИО</th>
				                            </tr>
				                        </thead>
				                        <tbody>
				                            <tr>
				                                <td>Завтрик</td>
				                                <td>06.03.2020 07:02</td>
				                                <td>Диета №2-Атрофический гастрит. колиты</td>
				                                <td>Мирзаева С</td>
				                            </tr>
				                        </tbody>
				                    </table>
				                </div>

				                <div id="modal_default22" class="modal fade" tabindex="-1">
				                    <div class="modal-dialog">
				                        <div class="modal-content">
				                            <div class="modal-header">
				                                <h5 class="modal-title">Категория блюд</h5>
				                                <button type="button" class="close" data-dismiss="modal">×</button>
				                            </div>

				                            <div class="modal-body">
				                                <form action="#">
				                                    <div class="modal-body">
				                                        <div class="form-group">
				                                            <div class="row">
				                                                <div class="col-sm-6">
				                                                    <label>ФИО пациента и ID </label>
				                                                    <input type="text" placeholder="" class="form-control" />
				                                                </div>

				                                                <div class="col-sm-6">
				                                                    <label>Медсестра</label>
				                                                    <input type="text" placeholder="" class="form-control" />
				                                                </div>
				                                            </div>
				                                        </div>

				                                        <div class="form-group">
				                                            <div class="row">
				                                                <div class="col-sm-6">
				                                                    <label></label>
				                                                    <input type="date" placeholder="" class="form-control" />
				                                                </div>

				                                                <div class="col-sm-6">
				                                                    <label></label>
				                                                    <input type="text" value="1 этаж" disabled="" class="form-control" />
				                                                </div>
				                                            </div>
				                                        </div>

				                                        <div class="form-group">
				                                            <div class="row">
				                                                <div class="col-sm-6">
				                                                    <label></label>
				                                                    <input type="text" value="3 палата" disabled="" class="form-control" />
				                                                </div>

				                                                <div class="col-sm-6">
				                                                    <label></label>
				                                                    <input type="text" value="4 койка" disabled="" class="form-control" />
				                                                </div>
				                                            </div>
				                                        </div>

				                                        <div class="form-group">
				                                            <div class="row">
				                                                <div class="col-sm-12">
				                                                    <select class="form-control select select2-hidden-accessible" data-placeholder="Завтрак" data-fouc="" tabindex="-1" aria-hidden="true">
				                                                        <option value="">Завтрак</option>
				                                                        <option value="№1">Диета №1-1-а.1-б Язва желудка и двенадцатиперсной кишки</option>
				                                                        <option value="№2">Диета №2-Атрофический гастрит. колиты</option>
				                                                        <option value="№3">Диета №3-Запоры</option>
				                                                        <option value="№4">Диета №4-4а.4б.4в-болезни кишечника с диареей</option>
				                                                        <option value="№5">Диета №5-5а.Заболевание желчных</option>
				                                                        <option value="№6">Диета №6-Мочекаменная болезнь. подагра</option>
				                                                        <option value="№7">Диета №7-7а.7б.7в.7г-хронический и острый нефрит. ХПН</option>
				                                                        <option value="№8">Диета №8-Ожирение</option>
				                                                        <option value="№9">Диета №9-Сахарный диабет</option>
				                                                        <option value="№10">Диета №10-Заболевания сердечно-сосудистой системы</option>
				                                                        <option value="№11">Диета №11-Туберкулез</option>
				                                                        <option value="№12">Диета №12-Заболевания нервной системы</option>
				                                                        <option value="№13">Диета №13-Острые инфекционные заболевания</option>
				                                                        <option value="№14">Диета №14-Болезнь почек с отхождением камней из фосфатов</option>
				                                                        <option value="№15">Диета №15-Заболевания не требующие особых диет</option>
				                                                    </select>
				                                                    <span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;">
				                                                        <span class="selection">
				                                                            <span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-5won-container">
				                                                                <span class="select2-selection__rendered" id="select2-5won-container"><span class="select2-selection__placeholder">Завтрак</span></span>
				                                                                <span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>
				                                                            </span>
				                                                        </span>
				                                                        <span class="dropdown-wrapper" aria-hidden="true"></span>
				                                                    </span>
				                                                </div>
				                                            </div>
				                                        </div>

				                                        <div class="form-group">
				                                            <div class="row">
				                                                <div class="col-sm-12">
				                                                    <select class="form-control select select2-hidden-accessible" data-placeholder="Обед" data-fouc="" tabindex="-1" aria-hidden="true">
				                                                        <option value=""></option>
				                                                        <option value="№1">Диета №1-1-а.1-б Язва желудка и двенадцатиперсной кишки</option>
				                                                        <option value="№2">Диета №2-Атрофический гастрит. колиты</option>
				                                                        <option value="№3">Диета №3-Запоры</option>
				                                                        <option value="№4">Диета №4-4а.4б.4в-болезни кишечника с диареей</option>
				                                                        <option value="№5">Диета №5-5а.Заболевание желчных</option>
				                                                        <option value="№6">Диета №6-Мочекаменная болезнь. подагра</option>
				                                                        <option value="№7">Диета №7-7а.7б.7в.7г-хронический и острый нефрит. ХПН</option>
				                                                        <option value="№8">Диета №8-Ожирение</option>
				                                                        <option value="№9">Диета №9-Сахарный диабет</option>
				                                                        <option value="№10">Диета №10-Заболевания сердечно-сосудистой системы</option>
				                                                        <option value="№11">Диета №11-Туберкулез</option>
				                                                        <option value="№12">Диета №12-Заболевания нервной системы</option>
				                                                        <option value="№13">Диета №13-Острые инфекционные заболевания</option>
				                                                        <option value="№14">Диета №14-Болезнь почек с отхождением камней из фосфатов</option>
				                                                        <option value="№15">Диета №15-Заболевания не требующие особых диет</option>
				                                                    </select>
				                                                    <span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;">
				                                                        <span class="selection">
				                                                            <span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-olac-container">
				                                                                <span class="select2-selection__rendered" id="select2-olac-container"><span class="select2-selection__placeholder">Обед</span></span>
				                                                                <span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>
				                                                            </span>
				                                                        </span>
				                                                        <span class="dropdown-wrapper" aria-hidden="true"></span>
				                                                    </span>
				                                                </div>
				                                            </div>
				                                        </div>

				                                        <div class="form-group">
				                                            <div class="row">
				                                                <div class="col-sm-12">
				                                                    <select class="form-control select select2-hidden-accessible" data-placeholder="Ужин" data-fouc="" tabindex="-1" aria-hidden="true">
				                                                        <option value="">Завтрак</option>
				                                                        <option value="№1">Диета №1-1-а.1-б Язва желудка и двенадцатиперсной кишки</option>
				                                                        <option value="№2">Диета №2-Атрофический гастрит. колиты</option>
				                                                        <option value="№3">Диета №3-Запоры</option>
				                                                        <option value="№4">Диета №4-4а.4б.4в-болезни кишечника с диареей</option>
				                                                        <option value="№5">Диета №5-5а.Заболевание желчных</option>
				                                                        <option value="№6">Диета №6-Мочекаменная болезнь. подагра</option>
				                                                        <option value="№7">Диета №7-7а.7б.7в.7г-хронический и острый нефрит. ХПН</option>
				                                                        <option value="№8">Диета №8-Ожирение</option>
				                                                        <option value="№9">Диета №9-Сахарный диабет</option>
				                                                        <option value="№10">Диета №10-Заболевания сердечно-сосудистой системы</option>
				                                                        <option value="№11">Диета №11-Туберкулез</option>
				                                                        <option value="№12">Диета №12-Заболевания нервной системы</option>
				                                                        <option value="№13">Диета №13-Острые инфекционные заболевания</option>
				                                                        <option value="№14">Диета №14-Болезнь почек с отхождением камней из фосфатов</option>
				                                                        <option value="№15">Диета №15-Заболевания не требующие особых диет</option>
				                                                    </select>
				                                                    <span class="select2 select2-container select2-container--default" dir="ltr" style="width: 100%;">
				                                                        <span class="selection">
				                                                            <span class="select2-selection select2-selection--single" role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="0" aria-labelledby="select2-1ulj-container">
				                                                                <span class="select2-selection__rendered" id="select2-1ulj-container"><span class="select2-selection__placeholder">Ужин</span></span>
				                                                                <span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>
				                                                            </span>
				                                                        </span>
				                                                        <span class="dropdown-wrapper" aria-hidden="true"></span>
				                                                    </span>
				                                                </div>
				                                            </div>
				                                        </div>
				                                    </div>
				                                </form>
				                            </div>

				                            <div class="modal-footer">
				                                <button type="submit" class="btn bg-primary legitRipple">Сохранить</button>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				            </div>
				            <!-- /basic modal -->

				            <div class="tab-pane fade" id="right-icon-tab7">
				                <form action="#">
				                    <div class="modal-body">
				                        <div class="form-group">
				                            <div class="row">
				                                <div class="col-sm-6">
				                                    <label>ФИО пациента и ID </label>
				                                    <input type="text" placeholder="" class="form-control" />
				                                </div>

				                                <div class="col-sm-6">
				                                    <label>Медсестра</label>
				                                    <input type="text" placeholder="" class="form-control" />
				                                </div>
				                            </div>
				                        </div>

				                        <div class="form-group">
				                            <div class="row">
				                                <div class="col-sm-6">
				                                    <label></label>
				                                    <input type="date" value="11.11.2020" class="form-control" />
				                                </div>

				                                <div class="col-sm-6">
				                                    <label></label>
				                                    <input type="text" value="1 этаж" disabled="" class="form-control" />
				                                </div>
				                            </div>
				                        </div>

				                        <div class="form-group">
				                            <div class="row">
				                                <div class="col-sm-6">
				                                    <label></label>
				                                    <input type="text" value="3-палата" disabled="" class="form-control" />
				                                </div>

				                                <div class="col-sm-6">
				                                    <label></label>
				                                    <input type="text" value="4-койка" disabled="" class="form-control" />
				                                </div>
				                            </div>
				                        </div>

				                        <div class="form-group">
				                            <div class="row">
				                                <div class="col-sm-12">
				                                    <select class="form-control select select2-hidden-accessible" data-placeholder="Состаение пациента утром" data-fouc="" tabindex="-1" aria-hidden="true">
				                                        <option value=""></option>
				                                        <option value="№1">Хорошо</option>
				                                        <option value="№2">Нормальное</option>
				                                        <option value="№3">Тяжелое</option>
				                                    </select>
				                                </div>
				                            </div>
				                        </div>

				                        <div class="form-group">
				                            <div class="row">
				                                <div class="col-sm-12">
				                                    <select class="form-control select select2-hidden-accessible" data-placeholder="Состаение пациента в обед" data-fouc="" tabindex="-1" aria-hidden="true">
				                                        <option value=""></option>
				                                        <option value="№1">Хорошо</option>
				                                        <option value="№2">Нормальное</option>
				                                        <option value="№3">Тяжелое</option>
				                                    </select>
				                                </div>
				                            </div>
				                        </div>

				                        <div class="form-group">
				                            <div class="row">
				                                <div class="col-sm-12">
				                                    <select class="form-control select select2-hidden-accessible" data-placeholder="Состаение пациента вечером" data-fouc="" tabindex="-1" aria-hidden="true">
				                                        <option value=""></option>
				                                        <option value="№1">Хорошо</option>
				                                        <option value="№2">Нормальное</option>
				                                        <option value="№3">Тяжелое</option>
				                                    </select>
				                                </div>
				                            </div>
				                        </div>

				                        <div class="modal-footer">
				                            <button type="submit" class="btn bg-primary legitRipple">Сохранить</button>
				                        </div>

				                        <div class="table-responsive">
				                            <table class="table">
				                                <thead>
				                                    <tr class="bg-blue">
				                                        <th>Дата и время</th>
				                                        <th>Состояние пациента</th>
				                                        <th>Медсестра ФИО</th>
				                                    </tr>
				                                </thead>
				                                <tbody>
				                                    <tr>
				                                        <td>0001</td>
				                                        <td>Анализ мочи</td>
				                                        <td>Ахмедова З</td>
				                                    </tr>
				                                </tbody>
				                            </table>
				                        </div>
				                    </div>
				                </form>
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
