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

				<div>

	               <div class="row">
                        <div class="card col-md-3">
                            <div class="card-img-actions">
                                <img class="card-img-top img-fluid" src="<?= stack("vendors/image/user3.jpg")?>" alt="">
                                <div class="card-img-actions-overlay card-img-top">
                                    <a href="#" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round legitRipple">
                                        <i class="icon-plus3"></i>
                                    </a>
                                    <a href="user_pages_profile.html" class="btn btn-outline bg-white text-white border-white border-2 btn-icon rounded-round ml-2 legitRipple">
                                        <i class="icon-link"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="card-body text-center">
                                <button type="button" class="btn alpha-blue text-blue-800 border-blue-600 legitRipple">Добавить Фото</button>
                            </div>
                        </div>
                        <div class="card col-md-9">
                            <div class="card-header header-elements-inline">
                                <h5 class="card-title"><b>Информация о пациенты</b></h5>
                            </div>

                            <div class="card-body">
                                <form action="#">
                                    <fieldset class="mb-3">
                                        <legend class="text-uppercase font-size-sm font-weight-bold"></legend>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div>
                                                    <h6 style="margin-top: 5px;"><b>ФИО пациента: </b> Якубов Фарход Абдурасулович</h6>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div>
                                                    <h6 style="margin-top: 9px;"><b>ID: </b> 0003</h6>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 style="margin-top: 9px;"><b>Дата рождение: </b> 19.04.1988</h6>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 style="margin-top: 9px;"><b>Жалоба пациента: </b> Болить голова</h6>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 style="margin-top: 9px;"><b>Телефон: </b> +998912474353</h6>
                                            </div>
                                            <div class="col-md-6">
                                                <h6 style="margin-top: 9px;"><b>Аллергия: </b> зуд, чихание, затруднения дыхания</h6>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 style="margin-top: 9px;"><b>Пол:</b> Мужчина</h6>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 style="margin-top: 9px;"><b>Адрес проживание:</b> г.Бухара ул. Рухшобод</h6>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6 style="margin-top: 9px;"><b>Адрес прописки:</b> г.Бухара ул. Кучабог 8</h6>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <!-- /starting step -->
                                </form>
                            </div>
                        </div>
                        <!-- /content area -->
                    </div>


	            <!-- /starting step -->


				</div>

				<div class="card">
				    <div class="card-header header-elements-inline">
				        <h6 class="card-title">Просмотр визита</h6>
				    </div>

				    <div class="card-body">
				        <ul class="nav nav-tabs nav-tabs-highlight">
				            <li class="nav-item">
				                <a href="#right-icon-tab1" class="nav-link active legitRipple" data-toggle="tab">Подробно <i class="icon-nbsp ml-3"></i></a>
				            </li>
				            <li class="nav-item">
				                <a href="#right-icon-tab2" class="nav-link legitRipple" data-toggle="tab">Осмотр <i class="icon-compose ml-3"></i></a>
				            </li>
				            <li class="nav-item">
				                <a href="#right-icon-tab4" class="nav-link legitRipple" data-toggle="tab">Другие визиты <i class="icon-users4 ml-3"></i></a>
				            </li>
				            <li class="nav-item">
				                <a href="#right-icon-tab5" class="nav-link legitRipple" data-toggle="tab">Назначить услугу <i class="icon-user-plus ml-3"></i></a>
				            </li>
				            <li class="nav-item">
				                <a href="#right-icon-tab6" class="nav-link legitRipple" data-toggle="tab">Визиты <i class="icon-spinner11 ml-3"></i></a>
				            </li>
				            <li class="nav-item">
				                <a href="#right-icon-tab8" class="nav-link legitRipple" data-toggle="tab">Анализы<i class="icon-droplets ml-3"></i></a>
				            </li>
				        </ul>

				        <div class="tab-content">
				            <div class="tab-pane fade show active" id="right-icon-tab1">
				                <div class="card">
				                    <table class="table table-togglable table-hover">
				                        <thead>
				                            <tr class="bg-blue text-center">
				                                <th>ID</th>
				                                <th>ФИО</th>

				                                <th>Дата визита</th>
				                                <th>Мед Услуга</th>
				                                <th>Статус</th>
				                            </tr>
				                        </thead>
				                        <tbody>
				                            <tr class="text-center">
				                                <td>00001</td>
				                                <td>Якубов Фарход Абдурасулович</td>

				                                <td>04.10.2020</td>
				                                <td>Осмотр терапевта</td>
				                                <td><span class="badge badge-success">Оплачено</span></td>
				                            </tr>
				                        </tbody>
				                    </table>
				                </div>
				            </div>
				            <div class="tab-pane fade" id="right-icon-tab2">
				                <div class="card">
				                    <div class="card-header header-elements-inline">
				                        <h5 class="card-title">Осмотр Пациента</h5>
				                    </div>
				                    <div class="card-body">
				                        <div class="summernote" style="display: none;">
				                            <h2>Apollo 11</h2>
				                            <div class="float-right" style="margin-left: 20px;"><img alt="Saturn V carrying Apollo 11" class="right" src="http://c.cksource.com/a/1/img/sample.jpg" /></div>
				                            <p>
				                                <strong>Apollo 11</strong> was the spaceflight that landed the first humans, Americans <a href="#">Neil Armstrong</a> and <a href="#">Buzz Aldrin</a>, on the Moon on July 20, 1969, at 20:18 UTC. Armstrong
				                                became the first to step onto the lunar surface 6 hours later on July 21 at 02:56 UTC.
				                            </p>
				                            <p class="mb-3">
				                                Armstrong spent about <s>three and a half</s> two and a half hours outside the spacecraft, Aldrin slightly less; and together they collected 47.5 pounds (21.5&nbsp;kg) of lunar material for return to Earth. A
				                                third member of the mission, <a href="#">Michael Collins</a>, piloted the <a href="#">command</a> spacecraft alone in lunar orbit until Armstrong and Aldrin returned to it for the trip back to Earth.
				                            </p>
				                            <h5 class="font-weight-semibold">Technical details</h5>
				                            <p>
				                                Launched by a <strong>Saturn V</strong> rocket from <a href="#">Kennedy Space Center</a> in Merritt Island, Florida on July 16, Apollo 11 was the fifth manned mission of <a href="#">NASA</a>'s Apollo program.
				                                The Apollo spacecraft had three parts:
				                            </p>
				                            <ol>
				                                <li><strong>Command Module</strong> with a cabin for the three astronauts which was the only part which landed back on Earth</li>
				                                <li><strong>Service Module</strong> which supported the Command Module with propulsion, electrical power, oxygen and water</li>
				                                <li><strong>Lunar Module</strong> for landing on the Moon.</li>
				                            </ol>
				                            <p class="mb-3">
				                                After being sent to the Moon by the Saturn V's upper stage, the astronauts separated the spacecraft from it and travelled for three days until they entered into lunar orbit. Armstrong and Aldrin then moved
				                                into the Lunar Module and landed in the <a href="#">Sea of Tranquility</a>. They stayed a total of about 21 and a half hours on the lunar surface. After lifting off in the upper part of the Lunar Module and
				                                rejoining Collins in the Command Module, they returned to Earth and landed in the <a href="#">Pacific Ocean</a> on July 24.
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
				                            Заключение Врача:
				                        </div>
				                        <div class="note-editor note-frame card">
				                            <div class="note-dropzone"><div class="note-dropzone-message"></div></div>
				                            <div class="note-toolbar-wrapper" style="height: 0px;">
				                                <div class="note-toolbar card-header" role="toolbar" style="position: relative; top: 0px; width: 100%;">
				                                    <div class="note-btn-group btn-group note-style">
				                                        <div class="note-btn-group btn-group">
				                                            <button type="button" class="note-btn btn btn-light btn-sm dropdown-toggle legitRipple" role="button" tabindex="-1" data-toggle="dropdown" title="" aria-label="Style" data-original-title="Style">
				                                                <i class="note-icon-magic"></i>
				                                            </button>
				                                            <div class="dropdown-menu dropdown-style" role="list" aria-label="Style">
				                                                <a class="dropdown-item" href="#" data-value="p" role="listitem" aria-label="p"><p>Normal</p></a>
				                                                <a class="dropdown-item" href="#" data-value="blockquote" role="listitem" aria-label="[object Object]"><blockquote class="blockquote">Blockquote</blockquote></a>
				                                                <a class="dropdown-item" href="#" data-value="h1" role="listitem" aria-label="h1"><h1>Header 1</h1></a>
				                                                <a class="dropdown-item" href="#" data-value="h2" role="listitem" aria-label="h2"><h2>Header 2</h2></a>
				                                                <a class="dropdown-item" href="#" data-value="h3" role="listitem" aria-label="h3"><h3>Header 3</h3></a>
				                                                <a class="dropdown-item" href="#" data-value="h4" role="listitem" aria-label="h4"><h4>Header 4</h4></a>
				                                                <a class="dropdown-item" href="#" data-value="h5" role="listitem" aria-label="h5"><h5>Header 5</h5></a>
				                                                <a class="dropdown-item" href="#" data-value="h6" role="listitem" aria-label="h6"><h6>Header 6</h6></a>
				                                            </div>
				                                        </div>
				                                    </div>
				                                    <div class="note-btn-group btn-group note-font">
				                                        <button type="button" class="note-btn btn btn-light btn-sm note-btn-bold legitRipple" role="button" tabindex="-1" title="" aria-label="Bold (CTRL+B)" data-original-title="Bold (CTRL+B)">
				                                            <i class="note-icon-bold"></i>
				                                        </button>
				                                        <button
				                                            type="button"
				                                            class="note-btn btn btn-light btn-sm note-btn-underline legitRipple"
				                                            role="button"
				                                            tabindex="-1"
				                                            title=""
				                                            aria-label="Underline (CTRL+U)"
				                                            data-original-title="Underline (CTRL+U)"
				                                        >
				                                            <i class="note-icon-underline"></i>
				                                        </button>
				                                        <button type="button" class="note-btn btn btn-light btn-sm legitRipple" role="button" tabindex="-1" title="" aria-label="Remove Font Style (CTRL+\)" data-original-title="Remove Font Style (CTRL+\)">
				                                            <i class="note-icon-eraser"></i>
				                                        </button>
				                                    </div>
				                                    <div class="note-btn-group btn-group note-fontname">
				                                        <div class="note-btn-group btn-group">
				                                            <button
				                                                type="button"
				                                                class="note-btn btn btn-light btn-sm dropdown-toggle legitRipple"
				                                                role="button"
				                                                tabindex="-1"
				                                                data-toggle="dropdown"
				                                                title=""
				                                                aria-label="Font Family"
				                                                data-original-title="Font Family"
				                                            >
				                                                <span class="note-current-fontname" style="font-family: Roboto;">Roboto</span>
				                                            </button>
				                                            <div class="dropdown-menu note-check dropdown-fontname" role="list" aria-label="Font Family">
				                                                <a class="dropdown-item" href="#" data-value="Arial" role="listitem" aria-label="Arial"><i class="note-icon-menu-check"></i> <span style="font-family: 'Arial';">Arial</span></a>
				                                                <a class="dropdown-item" href="#" data-value="Courier New" role="listitem" aria-label="Courier New">
				                                                    <i class="note-icon-menu-check"></i> <span style="font-family: 'Courier New';">Courier New</span>
				                                                </a>
				                                                <a class="dropdown-item" href="#" data-value="Helvetica" role="listitem" aria-label="Helvetica">
				                                                    <i class="note-icon-menu-check"></i> <span style="font-family: 'Helvetica';">Helvetica</span>
				                                                </a>
				                                                <a class="dropdown-item" href="#" data-value="Times New Roman" role="listitem" aria-label="Times New Roman">
				                                                    <i class="note-icon-menu-check"></i> <span style="font-family: 'Times New Roman';">Times New Roman</span>
				                                                </a>
				                                                <a class="dropdown-item checked" href="#" data-value="Roboto" role="listitem" aria-label="Roboto"><i class="note-icon-menu-check"></i> <span style="font-family: 'Roboto';">Roboto</span></a>
				                                            </div>
				                                        </div>
				                                    </div>
				                                    <div class="note-btn-group btn-group note-color">
				                                        <div class="note-btn-group btn-group note-color">
				                                            <button
				                                                type="button"
				                                                class="note-btn btn btn-light btn-sm note-current-color-button legitRipple"
				                                                role="button"
				                                                tabindex="-1"
				                                                title=""
				                                                aria-label="Recent Color"
				                                                data-original-title="Recent Color"
				                                                data-backcolor="#FFFF00"
				                                            >
				                                                <i class="note-icon-font note-recent-color" style="background-color: rgb(255, 255, 0);"></i>
				                                            </button>
				                                            <button
				                                                type="button"
				                                                class="note-btn btn btn-light btn-sm dropdown-toggle legitRipple legitRipple-empty"
				                                                role="button"
				                                                tabindex="-1"
				                                                data-toggle="dropdown"
				                                                title=""
				                                                aria-label="More Color"
				                                                data-original-title="More Color"
				                                            ></button>
				                                            <div class="dropdown-menu" role="list">
				                                                <div class="note-palette">
				                                                    <div class="note-palette-title">Background Color</div>
				                                                    <div><button type="button" class="note-color-reset btn btn-light legitRipple" data-event="backColor" data-value="inherit">Transparent</button></div>
				                                                    <div class="note-holder" data-event="backColor">
				                                                        <div class="note-color-palette">
				                                                            <div class="note-color-row">
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #000000;"
				                                                                    data-event="backColor"
				                                                                    data-value="#000000"
				                                                                    title=""
				                                                                    aria-label="Black"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Black"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #424242;"
				                                                                    data-event="backColor"
				                                                                    data-value="#424242"
				                                                                    title=""
				                                                                    aria-label="Tundora"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Tundora"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #636363;"
				                                                                    data-event="backColor"
				                                                                    data-value="#636363"
				                                                                    title=""
				                                                                    aria-label="Dove Gray"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Dove Gray"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #9c9c94;"
				                                                                    data-event="backColor"
				                                                                    data-value="#9C9C94"
				                                                                    title=""
				                                                                    aria-label="Star Dust"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Star Dust"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #cec6ce;"
				                                                                    data-event="backColor"
				                                                                    data-value="#CEC6CE"
				                                                                    title=""
				                                                                    aria-label="Pale Slate"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Pale Slate"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #efefef;"
				                                                                    data-event="backColor"
				                                                                    data-value="#EFEFEF"
				                                                                    title=""
				                                                                    aria-label="Gallery"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Gallery"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #f7f7f7;"
				                                                                    data-event="backColor"
				                                                                    data-value="#F7F7F7"
				                                                                    title=""
				                                                                    aria-label="Alabaster"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Alabaster"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #ffffff;"
				                                                                    data-event="backColor"
				                                                                    data-value="#FFFFFF"
				                                                                    title=""
				                                                                    aria-label="White"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="White"
				                                                                ></button>
				                                                            </div>
				                                                            <div class="note-color-row">
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #ff0000;"
				                                                                    data-event="backColor"
				                                                                    data-value="#FF0000"
				                                                                    title=""
				                                                                    aria-label="Red"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Red"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #ff9c00;"
				                                                                    data-event="backColor"
				                                                                    data-value="#FF9C00"
				                                                                    title=""
				                                                                    aria-label="Orange Peel"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Orange Peel"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #ffff00;"
				                                                                    data-event="backColor"
				                                                                    data-value="#FFFF00"
				                                                                    title=""
				                                                                    aria-label="Yellow"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Yellow"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #00ff00;"
				                                                                    data-event="backColor"
				                                                                    data-value="#00FF00"
				                                                                    title=""
				                                                                    aria-label="Green"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Green"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #00ffff;"
				                                                                    data-event="backColor"
				                                                                    data-value="#00FFFF"
				                                                                    title=""
				                                                                    aria-label="Cyan"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Cyan"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #0000ff;"
				                                                                    data-event="backColor"
				                                                                    data-value="#0000FF"
				                                                                    title=""
				                                                                    aria-label="Blue"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Blue"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #9c00ff;"
				                                                                    data-event="backColor"
				                                                                    data-value="#9C00FF"
				                                                                    title=""
				                                                                    aria-label="Electric Violet"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Electric Violet"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #ff00ff;"
				                                                                    data-event="backColor"
				                                                                    data-value="#FF00FF"
				                                                                    title=""
				                                                                    aria-label="Magenta"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Magenta"
				                                                                ></button>
				                                                            </div>
				                                                            <div class="note-color-row">
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #f7c6ce;"
				                                                                    data-event="backColor"
				                                                                    data-value="#F7C6CE"
				                                                                    title=""
				                                                                    aria-label="Azalea"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Azalea"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #ffe7ce;"
				                                                                    data-event="backColor"
				                                                                    data-value="#FFE7CE"
				                                                                    title=""
				                                                                    aria-label="Karry"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Karry"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #ffefc6;"
				                                                                    data-event="backColor"
				                                                                    data-value="#FFEFC6"
				                                                                    title=""
				                                                                    aria-label="Egg White"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Egg White"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #d6efd6;"
				                                                                    data-event="backColor"
				                                                                    data-value="#D6EFD6"
				                                                                    title=""
				                                                                    aria-label="Zanah"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Zanah"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #cedee7;"
				                                                                    data-event="backColor"
				                                                                    data-value="#CEDEE7"
				                                                                    title=""
				                                                                    aria-label="Botticelli"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Botticelli"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #cee7f7;"
				                                                                    data-event="backColor"
				                                                                    data-value="#CEE7F7"
				                                                                    title=""
				                                                                    aria-label="Tropical Blue"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Tropical Blue"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #d6d6e7;"
				                                                                    data-event="backColor"
				                                                                    data-value="#D6D6E7"
				                                                                    title=""
				                                                                    aria-label="Mischka"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Mischka"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #e7d6de;"
				                                                                    data-event="backColor"
				                                                                    data-value="#E7D6DE"
				                                                                    title=""
				                                                                    aria-label="Twilight"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Twilight"
				                                                                ></button>
				                                                            </div>
				                                                            <div class="note-color-row">
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #e79c9c;"
				                                                                    data-event="backColor"
				                                                                    data-value="#E79C9C"
				                                                                    title=""
				                                                                    aria-label="Tonys Pink"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Tonys Pink"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #ffc69c;"
				                                                                    data-event="backColor"
				                                                                    data-value="#FFC69C"
				                                                                    title=""
				                                                                    aria-label="Peach Orange"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Peach Orange"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #ffe79c;"
				                                                                    data-event="backColor"
				                                                                    data-value="#FFE79C"
				                                                                    title=""
				                                                                    aria-label="Cream Brulee"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Cream Brulee"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #b5d6a5;"
				                                                                    data-event="backColor"
				                                                                    data-value="#B5D6A5"
				                                                                    title=""
				                                                                    aria-label="Sprout"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Sprout"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #a5c6ce;"
				                                                                    data-event="backColor"
				                                                                    data-value="#A5C6CE"
				                                                                    title=""
				                                                                    aria-label="Casper"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Casper"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #9cc6ef;"
				                                                                    data-event="backColor"
				                                                                    data-value="#9CC6EF"
				                                                                    title=""
				                                                                    aria-label="Perano"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Perano"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #b5a5d6;"
				                                                                    data-event="backColor"
				                                                                    data-value="#B5A5D6"
				                                                                    title=""
				                                                                    aria-label="Cold Purple"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Cold Purple"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #d6a5bd;"
				                                                                    data-event="backColor"
				                                                                    data-value="#D6A5BD"
				                                                                    title=""
				                                                                    aria-label="Careys Pink"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Careys Pink"
				                                                                ></button>
				                                                            </div>
				                                                            <div class="note-color-row">
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #e76363;"
				                                                                    data-event="backColor"
				                                                                    data-value="#E76363"
				                                                                    title=""
				                                                                    aria-label="Mandy"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Mandy"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #f7ad6b;"
				                                                                    data-event="backColor"
				                                                                    data-value="#F7AD6B"
				                                                                    title=""
				                                                                    aria-label="Rajah"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Rajah"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #ffd663;"
				                                                                    data-event="backColor"
				                                                                    data-value="#FFD663"
				                                                                    title=""
				                                                                    aria-label="Dandelion"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Dandelion"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #94bd7b;"
				                                                                    data-event="backColor"
				                                                                    data-value="#94BD7B"
				                                                                    title=""
				                                                                    aria-label="Olivine"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Olivine"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #73a5ad;"
				                                                                    data-event="backColor"
				                                                                    data-value="#73A5AD"
				                                                                    title=""
				                                                                    aria-label="Gulf Stream"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Gulf Stream"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #6badde;"
				                                                                    data-event="backColor"
				                                                                    data-value="#6BADDE"
				                                                                    title=""
				                                                                    aria-label="Viking"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Viking"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #8c7bc6;"
				                                                                    data-event="backColor"
				                                                                    data-value="#8C7BC6"
				                                                                    title=""
				                                                                    aria-label="Blue Marguerite"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Blue Marguerite"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #c67ba5;"
				                                                                    data-event="backColor"
				                                                                    data-value="#C67BA5"
				                                                                    title=""
				                                                                    aria-label="Puce"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Puce"
				                                                                ></button>
				                                                            </div>
				                                                            <div class="note-color-row">
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #ce0000;"
				                                                                    data-event="backColor"
				                                                                    data-value="#CE0000"
				                                                                    title=""
				                                                                    aria-label="Guardsman Red"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Guardsman Red"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #e79439;"
				                                                                    data-event="backColor"
				                                                                    data-value="#E79439"
				                                                                    title=""
				                                                                    aria-label="Fire Bush"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Fire Bush"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #efc631;"
				                                                                    data-event="backColor"
				                                                                    data-value="#EFC631"
				                                                                    title=""
				                                                                    aria-label="Golden Dream"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Golden Dream"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #6ba54a;"
				                                                                    data-event="backColor"
				                                                                    data-value="#6BA54A"
				                                                                    title=""
				                                                                    aria-label="Chelsea Cucumber"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Chelsea Cucumber"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #4a7b8c;"
				                                                                    data-event="backColor"
				                                                                    data-value="#4A7B8C"
				                                                                    title=""
				                                                                    aria-label="Smalt Blue"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Smalt Blue"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #3984c6;"
				                                                                    data-event="backColor"
				                                                                    data-value="#3984C6"
				                                                                    title=""
				                                                                    aria-label="Boston Blue"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Boston Blue"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #634aa5;"
				                                                                    data-event="backColor"
				                                                                    data-value="#634AA5"
				                                                                    title=""
				                                                                    aria-label="Butterfly Bush"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Butterfly Bush"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #a54a7b;"
				                                                                    data-event="backColor"
				                                                                    data-value="#A54A7B"
				                                                                    title=""
				                                                                    aria-label="Cadillac"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Cadillac"
				                                                                ></button>
				                                                            </div>
				                                                            <div class="note-color-row">
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #9c0000;"
				                                                                    data-event="backColor"
				                                                                    data-value="#9C0000"
				                                                                    title=""
				                                                                    aria-label="Sangria"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Sangria"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #b56308;"
				                                                                    data-event="backColor"
				                                                                    data-value="#B56308"
				                                                                    title=""
				                                                                    aria-label="Mai Tai"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Mai Tai"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #bd9400;"
				                                                                    data-event="backColor"
				                                                                    data-value="#BD9400"
				                                                                    title=""
				                                                                    aria-label="Buddha Gold"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Buddha Gold"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #397b21;"
				                                                                    data-event="backColor"
				                                                                    data-value="#397B21"
				                                                                    title=""
				                                                                    aria-label="Forest Green"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Forest Green"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #104a5a;"
				                                                                    data-event="backColor"
				                                                                    data-value="#104A5A"
				                                                                    title=""
				                                                                    aria-label="Eden"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Eden"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #085294;"
				                                                                    data-event="backColor"
				                                                                    data-value="#085294"
				                                                                    title=""
				                                                                    aria-label="Venice Blue"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Venice Blue"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #311873;"
				                                                                    data-event="backColor"
				                                                                    data-value="#311873"
				                                                                    title=""
				                                                                    aria-label="Meteorite"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Meteorite"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #731842;"
				                                                                    data-event="backColor"
				                                                                    data-value="#731842"
				                                                                    title=""
				                                                                    aria-label="Claret"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Claret"
				                                                                ></button>
				                                                            </div>
				                                                            <div class="note-color-row">
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #630000;"
				                                                                    data-event="backColor"
				                                                                    data-value="#630000"
				                                                                    title=""
				                                                                    aria-label="Rosewood"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Rosewood"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #7b3900;"
				                                                                    data-event="backColor"
				                                                                    data-value="#7B3900"
				                                                                    title=""
				                                                                    aria-label="Cinnamon"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Cinnamon"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #846300;"
				                                                                    data-event="backColor"
				                                                                    data-value="#846300"
				                                                                    title=""
				                                                                    aria-label="Olive"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Olive"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #295218;"
				                                                                    data-event="backColor"
				                                                                    data-value="#295218"
				                                                                    title=""
				                                                                    aria-label="Parsley"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Parsley"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #083139;"
				                                                                    data-event="backColor"
				                                                                    data-value="#083139"
				                                                                    title=""
				                                                                    aria-label="Tiber"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Tiber"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #003163;"
				                                                                    data-event="backColor"
				                                                                    data-value="#003163"
				                                                                    title=""
				                                                                    aria-label="Midnight Blue"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Midnight Blue"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #21104a;"
				                                                                    data-event="backColor"
				                                                                    data-value="#21104A"
				                                                                    title=""
				                                                                    aria-label="Valentino"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Valentino"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #4a1031;"
				                                                                    data-event="backColor"
				                                                                    data-value="#4A1031"
				                                                                    title=""
				                                                                    aria-label="Loulou"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Loulou"
				                                                                ></button>
				                                                            </div>
				                                                        </div>
				                                                    </div>
				                                                </div>
				                                                <div class="note-palette">
				                                                    <div class="note-palette-title">Foreground Color</div>
				                                                    <div><button type="button" class="note-color-reset btn btn-light legitRipple" data-event="removeFormat" data-value="foreColor">Reset to default</button></div>
				                                                    <div class="note-holder" data-event="foreColor">
				                                                        <div class="note-color-palette">
				                                                            <div class="note-color-row">
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #000000;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#000000"
				                                                                    title=""
				                                                                    aria-label="Black"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Black"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #424242;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#424242"
				                                                                    title=""
				                                                                    aria-label="Tundora"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Tundora"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #636363;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#636363"
				                                                                    title=""
				                                                                    aria-label="Dove Gray"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Dove Gray"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #9c9c94;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#9C9C94"
				                                                                    title=""
				                                                                    aria-label="Star Dust"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Star Dust"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #cec6ce;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#CEC6CE"
				                                                                    title=""
				                                                                    aria-label="Pale Slate"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Pale Slate"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #efefef;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#EFEFEF"
				                                                                    title=""
				                                                                    aria-label="Gallery"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Gallery"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #f7f7f7;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#F7F7F7"
				                                                                    title=""
				                                                                    aria-label="Alabaster"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Alabaster"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #ffffff;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#FFFFFF"
				                                                                    title=""
				                                                                    aria-label="White"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="White"
				                                                                ></button>
				                                                            </div>
				                                                            <div class="note-color-row">
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #ff0000;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#FF0000"
				                                                                    title=""
				                                                                    aria-label="Red"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Red"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #ff9c00;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#FF9C00"
				                                                                    title=""
				                                                                    aria-label="Orange Peel"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Orange Peel"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #ffff00;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#FFFF00"
				                                                                    title=""
				                                                                    aria-label="Yellow"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Yellow"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #00ff00;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#00FF00"
				                                                                    title=""
				                                                                    aria-label="Green"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Green"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #00ffff;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#00FFFF"
				                                                                    title=""
				                                                                    aria-label="Cyan"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Cyan"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #0000ff;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#0000FF"
				                                                                    title=""
				                                                                    aria-label="Blue"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Blue"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #9c00ff;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#9C00FF"
				                                                                    title=""
				                                                                    aria-label="Electric Violet"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Electric Violet"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #ff00ff;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#FF00FF"
				                                                                    title=""
				                                                                    aria-label="Magenta"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Magenta"
				                                                                ></button>
				                                                            </div>
				                                                            <div class="note-color-row">
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #f7c6ce;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#F7C6CE"
				                                                                    title=""
				                                                                    aria-label="Azalea"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Azalea"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #ffe7ce;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#FFE7CE"
				                                                                    title=""
				                                                                    aria-label="Karry"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Karry"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #ffefc6;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#FFEFC6"
				                                                                    title=""
				                                                                    aria-label="Egg White"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Egg White"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #d6efd6;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#D6EFD6"
				                                                                    title=""
				                                                                    aria-label="Zanah"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Zanah"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #cedee7;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#CEDEE7"
				                                                                    title=""
				                                                                    aria-label="Botticelli"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Botticelli"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #cee7f7;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#CEE7F7"
				                                                                    title=""
				                                                                    aria-label="Tropical Blue"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Tropical Blue"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #d6d6e7;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#D6D6E7"
				                                                                    title=""
				                                                                    aria-label="Mischka"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Mischka"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #e7d6de;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#E7D6DE"
				                                                                    title=""
				                                                                    aria-label="Twilight"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Twilight"
				                                                                ></button>
				                                                            </div>
				                                                            <div class="note-color-row">
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #e79c9c;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#E79C9C"
				                                                                    title=""
				                                                                    aria-label="Tonys Pink"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Tonys Pink"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #ffc69c;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#FFC69C"
				                                                                    title=""
				                                                                    aria-label="Peach Orange"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Peach Orange"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #ffe79c;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#FFE79C"
				                                                                    title=""
				                                                                    aria-label="Cream Brulee"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Cream Brulee"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #b5d6a5;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#B5D6A5"
				                                                                    title=""
				                                                                    aria-label="Sprout"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Sprout"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #a5c6ce;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#A5C6CE"
				                                                                    title=""
				                                                                    aria-label="Casper"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Casper"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #9cc6ef;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#9CC6EF"
				                                                                    title=""
				                                                                    aria-label="Perano"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Perano"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #b5a5d6;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#B5A5D6"
				                                                                    title=""
				                                                                    aria-label="Cold Purple"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Cold Purple"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #d6a5bd;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#D6A5BD"
				                                                                    title=""
				                                                                    aria-label="Careys Pink"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Careys Pink"
				                                                                ></button>
				                                                            </div>
				                                                            <div class="note-color-row">
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #e76363;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#E76363"
				                                                                    title=""
				                                                                    aria-label="Mandy"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Mandy"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #f7ad6b;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#F7AD6B"
				                                                                    title=""
				                                                                    aria-label="Rajah"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Rajah"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #ffd663;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#FFD663"
				                                                                    title=""
				                                                                    aria-label="Dandelion"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Dandelion"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #94bd7b;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#94BD7B"
				                                                                    title=""
				                                                                    aria-label="Olivine"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Olivine"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #73a5ad;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#73A5AD"
				                                                                    title=""
				                                                                    aria-label="Gulf Stream"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Gulf Stream"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #6badde;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#6BADDE"
				                                                                    title=""
				                                                                    aria-label="Viking"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Viking"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #8c7bc6;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#8C7BC6"
				                                                                    title=""
				                                                                    aria-label="Blue Marguerite"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Blue Marguerite"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #c67ba5;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#C67BA5"
				                                                                    title=""
				                                                                    aria-label="Puce"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Puce"
				                                                                ></button>
				                                                            </div>
				                                                            <div class="note-color-row">
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #ce0000;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#CE0000"
				                                                                    title=""
				                                                                    aria-label="Guardsman Red"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Guardsman Red"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #e79439;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#E79439"
				                                                                    title=""
				                                                                    aria-label="Fire Bush"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Fire Bush"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #efc631;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#EFC631"
				                                                                    title=""
				                                                                    aria-label="Golden Dream"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Golden Dream"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #6ba54a;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#6BA54A"
				                                                                    title=""
				                                                                    aria-label="Chelsea Cucumber"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Chelsea Cucumber"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #4a7b8c;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#4A7B8C"
				                                                                    title=""
				                                                                    aria-label="Smalt Blue"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Smalt Blue"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #3984c6;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#3984C6"
				                                                                    title=""
				                                                                    aria-label="Boston Blue"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Boston Blue"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #634aa5;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#634AA5"
				                                                                    title=""
				                                                                    aria-label="Butterfly Bush"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Butterfly Bush"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #a54a7b;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#A54A7B"
				                                                                    title=""
				                                                                    aria-label="Cadillac"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Cadillac"
				                                                                ></button>
				                                                            </div>
				                                                            <div class="note-color-row">
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #9c0000;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#9C0000"
				                                                                    title=""
				                                                                    aria-label="Sangria"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Sangria"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #b56308;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#B56308"
				                                                                    title=""
				                                                                    aria-label="Mai Tai"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Mai Tai"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #bd9400;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#BD9400"
				                                                                    title=""
				                                                                    aria-label="Buddha Gold"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Buddha Gold"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #397b21;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#397B21"
				                                                                    title=""
				                                                                    aria-label="Forest Green"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Forest Green"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #104a5a;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#104A5A"
				                                                                    title=""
				                                                                    aria-label="Eden"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Eden"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #085294;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#085294"
				                                                                    title=""
				                                                                    aria-label="Venice Blue"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Venice Blue"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #311873;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#311873"
				                                                                    title=""
				                                                                    aria-label="Meteorite"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Meteorite"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #731842;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#731842"
				                                                                    title=""
				                                                                    aria-label="Claret"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Claret"
				                                                                ></button>
				                                                            </div>
				                                                            <div class="note-color-row">
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #630000;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#630000"
				                                                                    title=""
				                                                                    aria-label="Rosewood"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Rosewood"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #7b3900;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#7B3900"
				                                                                    title=""
				                                                                    aria-label="Cinnamon"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Cinnamon"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #846300;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#846300"
				                                                                    title=""
				                                                                    aria-label="Olive"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Olive"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #295218;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#295218"
				                                                                    title=""
				                                                                    aria-label="Parsley"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Parsley"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #083139;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#083139"
				                                                                    title=""
				                                                                    aria-label="Tiber"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Tiber"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #003163;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#003163"
				                                                                    title=""
				                                                                    aria-label="Midnight Blue"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Midnight Blue"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #21104a;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#21104A"
				                                                                    title=""
				                                                                    aria-label="Valentino"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Valentino"
				                                                                ></button>
				                                                                <button
				                                                                    type="button"
				                                                                    class="note-color-btn"
				                                                                    style="background-color: #4a1031;"
				                                                                    data-event="foreColor"
				                                                                    data-value="#4A1031"
				                                                                    title=""
				                                                                    aria-label="Loulou"
				                                                                    data-toggle="button"
				                                                                    tabindex="-1"
				                                                                    data-original-title="Loulou"
				                                                                ></button>
				                                                            </div>
				                                                        </div>
				                                                    </div>
				                                                </div>
				                                            </div>
				                                        </div>
				                                    </div>
				                                    <div class="note-btn-group btn-group note-para">
				                                        <button
				                                            type="button"
				                                            class="note-btn btn btn-light btn-sm legitRipple"
				                                            role="button"
				                                            tabindex="-1"
				                                            title=""
				                                            aria-label="Unordered list (CTRL+SHIFT+NUM7)"
				                                            data-original-title="Unordered list (CTRL+SHIFT+NUM7)"
				                                        >
				                                            <i class="note-icon-unorderedlist"></i>
				                                        </button>
				                                        <button
				                                            type="button"
				                                            class="note-btn btn btn-light btn-sm legitRipple"
				                                            role="button"
				                                            tabindex="-1"
				                                            title=""
				                                            aria-label="Ordered list (CTRL+SHIFT+NUM8)"
				                                            data-original-title="Ordered list (CTRL+SHIFT+NUM8)"
				                                        >
				                                            <i class="note-icon-orderedlist"></i>
				                                        </button>
				                                        <div class="note-btn-group btn-group">
				                                            <button
				                                                type="button"
				                                                class="note-btn btn btn-light btn-sm dropdown-toggle legitRipple"
				                                                role="button"
				                                                tabindex="-1"
				                                                data-toggle="dropdown"
				                                                title=""
				                                                aria-label="Paragraph"
				                                                data-original-title="Paragraph"
				                                            >
				                                                <i class="note-icon-align-left"></i>
				                                            </button>
				                                            <div class="dropdown-menu" role="list">
				                                                <div class="note-btn-group btn-group note-align">
				                                                    <button
				                                                        type="button"
				                                                        class="note-btn btn btn-light btn-sm legitRipple"
				                                                        role="button"
				                                                        tabindex="-1"
				                                                        title=""
				                                                        aria-label="Align left (CTRL+SHIFT+L)"
				                                                        data-original-title="Align left (CTRL+SHIFT+L)"
				                                                    >
				                                                        <i class="note-icon-align-left"></i>
				                                                    </button>
				                                                    <button
				                                                        type="button"
				                                                        class="note-btn btn btn-light btn-sm legitRipple"
				                                                        role="button"
				                                                        tabindex="-1"
				                                                        title=""
				                                                        aria-label="Align center (CTRL+SHIFT+E)"
				                                                        data-original-title="Align center (CTRL+SHIFT+E)"
				                                                    >
				                                                        <i class="note-icon-align-center"></i>
				                                                    </button>
				                                                    <button
				                                                        type="button"
				                                                        class="note-btn btn btn-light btn-sm legitRipple"
				                                                        role="button"
				                                                        tabindex="-1"
				                                                        title=""
				                                                        aria-label="Align right (CTRL+SHIFT+R)"
				                                                        data-original-title="Align right (CTRL+SHIFT+R)"
				                                                    >
				                                                        <i class="note-icon-align-right"></i>
				                                                    </button>
				                                                    <button
				                                                        type="button"
				                                                        class="note-btn btn btn-light btn-sm legitRipple"
				                                                        role="button"
				                                                        tabindex="-1"
				                                                        title=""
				                                                        aria-label="Justify full (CTRL+SHIFT+J)"
				                                                        data-original-title="Justify full (CTRL+SHIFT+J)"
				                                                    >
				                                                        <i class="note-icon-align-justify"></i>
				                                                    </button>
				                                                </div>
				                                                <div class="note-btn-group btn-group note-list">
				                                                    <button type="button" class="note-btn btn btn-light btn-sm legitRipple" role="button" tabindex="-1" title="" aria-label="Outdent (CTRL+[)" data-original-title="Outdent (CTRL+[)">
				                                                        <i class="note-icon-align-outdent"></i>
				                                                    </button>
				                                                    <button type="button" class="note-btn btn btn-light btn-sm legitRipple" role="button" tabindex="-1" title="" aria-label="Indent (CTRL+])" data-original-title="Indent (CTRL+])">
				                                                        <i class="note-icon-align-indent"></i>
				                                                    </button>
				                                                </div>
				                                            </div>
				                                        </div>
				                                    </div>
				                                    <div class="note-btn-group btn-group note-table">
				                                        <div class="note-btn-group btn-group">
				                                            <button type="button" class="note-btn btn btn-light btn-sm dropdown-toggle legitRipple" role="button" tabindex="-1" data-toggle="dropdown" title="" aria-label="Table" data-original-title="Table">
				                                                <i class="note-icon-table"></i>
				                                            </button>
				                                            <div class="dropdown-menu note-table" role="list" aria-label="Table">
				                                                <div class="note-dimension-picker">
				                                                    <div class="note-dimension-picker-mousecatcher" data-event="insertTable" data-value="1x1" style="width: 10em; height: 10em;"></div>
				                                                    <div class="note-dimension-picker-highlighted"></div>
				                                                    <div class="note-dimension-picker-unhighlighted"></div>
				                                                </div>
				                                                <div class="note-dimension-display">1 x 1</div>
				                                            </div>
				                                        </div>
				                                    </div>
				                                    <div class="note-btn-group btn-group note-insert">
				                                        <button type="button" class="note-btn btn btn-light btn-sm legitRipple" role="button" tabindex="-1" title="" aria-label="Link (CTRL+K)" data-original-title="Link (CTRL+K)">
				                                            <i class="note-icon-link"></i>
				                                        </button>
				                                        <button type="button" class="note-btn btn btn-light btn-sm legitRipple" role="button" tabindex="-1" title="" aria-label="Picture" data-original-title="Picture">
				                                            <i class="note-icon-picture"></i>
				                                        </button>
				                                        <button type="button" class="note-btn btn btn-light btn-sm legitRipple" role="button" tabindex="-1" title="" aria-label="Video" data-original-title="Video"><i class="note-icon-video"></i></button>
				                                    </div>
				                                    <div class="note-btn-group btn-group note-view">
				                                        <button type="button" class="note-btn btn btn-light btn-sm btn-fullscreen legitRipple" role="button" tabindex="-1" title="" aria-label="Full Screen" data-original-title="Full Screen">
				                                            <i class="note-icon-arrows-alt"></i>
				                                        </button>
				                                        <button type="button" class="note-btn btn btn-light btn-sm btn-codeview legitRipple" role="button" tabindex="-1" title="" aria-label="Code View" data-original-title="Code View">
				                                            <i class="note-icon-code"></i>
				                                        </button>
				                                        <button type="button" class="note-btn btn btn-light btn-sm legitRipple" role="button" tabindex="-1" title="" aria-label="Help" data-original-title="Help"><i class="note-icon-question"></i></button>
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="note-editing-area">
				                                <div class="note-handle">
				                                    <div class="note-control-selection">
				                                        <div class="note-control-selection-bg"></div>
				                                        <div class="note-control-holder note-control-nw"></div>
				                                        <div class="note-control-holder note-control-ne"></div>
				                                        <div class="note-control-holder note-control-sw"></div>
				                                        <div class="note-control-sizing note-control-se"></div>
				                                        <div class="note-control-selection-info"></div>
				                                    </div>
				                                </div>
				                                <textarea class="note-codable" role="textbox" aria-multiline="true"></textarea>
				                                <div class="note-editable card-block" role="textbox" aria-multiline="true" contenteditable="true">
				                                    <h2>Apollo 11</h2>
				                                    <div class="float-right" style="margin-left: 20px;"><img alt="Saturn V carrying Apollo 11" class="right" src="http://c.cksource.com/a/1/img/sample.jpg" /></div>
				                                    <p>
				                                        <strong>Apollo 11</strong> was the spaceflight that landed the first humans, Americans <a href="#">Neil Armstrong</a> and <a href="#">Buzz Aldrin</a>, on the Moon on July 20, 1969, at 20:18 UTC.
				                                        Armstrong became the first to step onto the lunar surface 6 hours later on July 21 at 02:56 UTC.
				                                    </p>
				                                    <p class="mb-3">
				                                        Armstrong spent about <s>three and a half</s> two and a half hours outside the spacecraft, Aldrin slightly less; and together they collected 47.5 pounds (21.5&nbsp;kg) of lunar material for return to
				                                        Earth. A third member of the mission, <a href="#">Michael Collins</a>, piloted the <a href="#">command</a> spacecraft alone in lunar orbit until Armstrong and Aldrin returned to it for the trip back
				                                        to Earth.
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
				                                        moved into the Lunar Module and landed in the <a href="#">Sea of Tranquility</a>. They stayed a total of about 21 and a half hours on the lunar surface. After lifting off in the upper part of the
				                                        Lunar Module and rejoining Collins in the Command Module, they returned to Earth and landed in the <a href="#">Pacific Ocean</a> on July 24.
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
				                                    Заключение Врача:
				                                </div>
				                            </div>
				                            <output class="note-status-output" aria-live="polite"></output>
				                            <div class="note-statusbar" role="status">
				                                <output class="note-status-output" aria-live="polite"></output>
				                                <div class="note-resizebar" role="seperator" aria-orientation="horizontal" aria-label="Resize">
				                                    <div class="note-icon-bar"></div>
				                                    <div class="note-icon-bar"></div>
				                                    <div class="note-icon-bar"></div>
				                                </div>
				                            </div>
				                            <div class="modal link-dialog" aria-hidden="false" tabindex="-1" role="dialog" aria-label="Insert Link">
				                                <div class="modal-dialog">
				                                    <div class="modal-content">
				                                        <div class="modal-header">
				                                            <h4 class="modal-title">Insert Link</h4>
				                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">×</button>
				                                        </div>
				                                        <div class="modal-body">
				                                            <div class="form-group note-form-group"><label class="note-form-label">Text to display</label><input class="note-link-text form-control note-form-control note-input" type="text" /></div>
				                                            <div class="form-group note-form-group">
				                                                <label class="note-form-label">To what URL should this link go?</label><input class="note-link-url form-control note-form-control note-input" type="text" value="http://" />
				                                            </div>
				                                            <label class="custom-control custom-checkbox" for="sn-checkbox-open-in-new-window">
				                                                <input role="checkbox" type="checkbox" class="custom-control-input" id="sn-checkbox-open-in-new-window" checked="" aria-checked="true" /> <span class="custom-control-indicator"></span>
				                                                <span class="custom-control-description">Open in new window</span>
				                                            </label>
				                                        </div>
				                                        <div class="modal-footer"><button type="submit" href="#" class="btn btn-primary note-btn note-btn-primary note-link-btn legitRipple" disabled="">Insert Link</button></div>
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="modal" aria-hidden="false" tabindex="-1" role="dialog" aria-label="Insert Image">
				                                <div class="modal-dialog">
				                                    <div class="modal-content">
				                                        <div class="modal-header">
				                                            <h4 class="modal-title">Insert Image</h4>
				                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">×</button>
				                                        </div>
				                                        <div class="modal-body">
				                                            <div class="form-group note-form-group note-group-select-from-files">
				                                                <label class="note-form-label">Select from files</label>
				                                                <div class="uniform-uploader">
				                                                    <input class="note-image-input note-form-control note-input" type="file" name="files" accept="image/*" multiple="multiple" />
				                                                    <span class="filename" style="user-select: none;">No file selected</span><span class="action btn bg-warning-400 legitRipple" style="user-select: none;">Choose Files</span>
				                                                </div>
				                                            </div>
				                                            <div class="form-group note-group-image-url" style="overflow: auto;">
				                                                <label class="note-form-label">Image URL</label><input class="note-image-url form-control note-form-control note-input col-md-12" type="text" />
				                                            </div>
				                                        </div>
				                                        <div class="modal-footer"><button type="submit" href="#" class="btn btn-primary note-btn note-btn-primary note-image-btn legitRipple" disabled="">Insert Image</button></div>
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="modal" aria-hidden="false" tabindex="-1" role="dialog" aria-label="Insert Video">
				                                <div class="modal-dialog">
				                                    <div class="modal-content">
				                                        <div class="modal-header">
				                                            <h4 class="modal-title">Insert Video</h4>
				                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">×</button>
				                                        </div>
				                                        <div class="modal-body">
				                                            <div class="form-group note-form-group row-fluid">
				                                                <label class="note-form-label">Video URL <small class="text-muted">(YouTube, Vimeo, Vine, Instagram, DailyMotion or Youku)</small></label>
				                                                <input class="note-video-url form-control note-form-control note-input" type="text" />
				                                            </div>
				                                        </div>
				                                        <div class="modal-footer"><button type="submit" href="#" class="btn btn-primary note-btn note-btn-primary note-video-btn legitRipple" disabled="">Insert Video</button></div>
				                                    </div>
				                                </div>
				                            </div>
				                            <div class="modal" aria-hidden="false" tabindex="-1" role="dialog" aria-label="Help">
				                                <div class="modal-dialog">
				                                    <div class="modal-content">
				                                        <div class="modal-header">
				                                            <h4 class="modal-title">Help</h4>
				                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">×</button>
				                                        </div>
				                                        <div class="modal-body" style="max-height: 300px; overflow: scroll;">
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>ENTER</kbd></label><span>Insert Paragraph</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+Z</kbd></label><span>Undoes the last command</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+Y</kbd></label><span>Redoes the last command</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>TAB</kbd></label><span>Tab</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>SHIFT+TAB</kbd></label><span>Untab</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+B</kbd></label><span>Set a bold style</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+I</kbd></label><span>Set a italic style</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+U</kbd></label><span>Set a underline style</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+SHIFT+S</kbd></label><span>Set a strikethrough style</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+BACKSLASH</kbd></label><span>Clean a style</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+SHIFT+L</kbd></label><span>Set left align</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+SHIFT+E</kbd></label><span>Set center align</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+SHIFT+R</kbd></label><span>Set right align</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+SHIFT+J</kbd></label><span>Set full align</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+SHIFT+NUM7</kbd></label><span>Toggle unordered list</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+SHIFT+NUM8</kbd></label><span>Toggle ordered list</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+LEFTBRACKET</kbd></label><span>Outdent on current paragraph</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+RIGHTBRACKET</kbd></label><span>Indent on current paragraph</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+NUM0</kbd></label><span>Change current block's format as a paragraph(P tag)</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+NUM1</kbd></label><span>Change current block's format as H1</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+NUM2</kbd></label><span>Change current block's format as H2</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+NUM3</kbd></label><span>Change current block's format as H3</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+NUM4</kbd></label><span>Change current block's format as H4</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+NUM5</kbd></label><span>Change current block's format as H5</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+NUM6</kbd></label><span>Change current block's format as H6</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+ENTER</kbd></label><span>Insert horizontal rule</span>
				                                            <div class="help-list-item"></div>
				                                            <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+K</kbd></label><span>Show Link Dialog</span>
				                                        </div>
				                                        <div class="modal-footer">
				                                            <p class="text-center">
				                                                <a href="http://summernote.org/" target="_blank">Summernote 0.8.10</a> · <a href="https://github.com/summernote/summernote" target="_blank">Project</a> ·
				                                                <a href="https://github.com/summernote/summernote/issues" target="_blank">Issues</a>
				                                            </p>
				                                        </div>
				                                    </div>
				                                </div>
				                            </div>
				                        </div>
				                    </div>
				                    <output class="note-status-output" aria-live="polite"></output>
				                    <div class="note-statusbar" role="status">
				                        <output class="note-status-output" aria-live="polite"></output>
				                        <div class="note-resizebar" role="seperator" aria-orientation="horizontal" aria-label="Resize">
				                            <div class="note-icon-bar"></div>
				                            <div class="note-icon-bar"></div>
				                            <div class="note-icon-bar"></div>
				                        </div>
				                    </div>
				                    <div class="modal link-dialog" aria-hidden="false" tabindex="-1" role="dialog" aria-label="Insert Link">
				                        <div class="modal-dialog">
				                            <div class="modal-content">
				                                <div class="modal-header">
				                                    <h4 class="modal-title">Insert Link</h4>
				                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">×</button>
				                                </div>
				                                <div class="modal-body">
				                                    <div class="form-group note-form-group"><label class="note-form-label">Text to display</label><input class="note-link-text form-control note-form-control note-input" type="text" /></div>
				                                    <div class="form-group note-form-group">
				                                        <label class="note-form-label">To what URL should this link go?</label><input class="note-link-url form-control note-form-control note-input" type="text" value="http://" />
				                                    </div>
				                                    <label class="custom-control custom-checkbox" for="sn-checkbox-open-in-new-window">
				                                        <input role="checkbox" type="checkbox" class="custom-control-input" id="sn-checkbox-open-in-new-window" checked="" aria-checked="true" /> <span class="custom-control-indicator"></span>
				                                        <span class="custom-control-description">Open in new window</span>
				                                    </label>
				                                </div>
				                                <div class="modal-footer"><button type="submit" href="#" class="btn btn-primary note-btn note-btn-primary note-link-btn legitRipple" disabled="">Insert Link</button></div>
				                            </div>
				                        </div>
				                    </div>
				                    <div class="modal" aria-hidden="false" tabindex="-1" role="dialog" aria-label="Insert Image">
				                        <div class="modal-dialog">
				                            <div class="modal-content">
				                                <div class="modal-header">
				                                    <h4 class="modal-title">Insert Image</h4>
				                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">×</button>
				                                </div>
				                                <div class="modal-body">
				                                    <div class="form-group note-form-group note-group-select-from-files">
				                                        <label class="note-form-label">Select from files</label>
				                                        <div class="uniform-uploader">
				                                            <div class="uniform-uploader">
				                                                <input class="note-image-input note-form-control note-input" type="file" name="files" accept="image/*" multiple="multiple" />
				                                                <span class="filename" style="user-select: none;">No file selected</span><span class="action btn bg-warning-400 legitRipple" style="user-select: none;">Choose Files</span>
				                                            </div>
				                                            <span class="filename" style="user-select: none;">No file selected</span><span class="action btn bg-warning-400 legitRipple" style="user-select: none;">Choose Files</span>
				                                        </div>
				                                    </div>
				                                    <div class="form-group note-group-image-url" style="overflow: auto;">
				                                        <label class="note-form-label">Image URL</label><input class="note-image-url form-control note-form-control note-input col-md-12" type="text" />
				                                    </div>
				                                </div>
				                                <div class="modal-footer"><button type="submit" href="#" class="btn btn-primary note-btn note-btn-primary note-image-btn legitRipple" disabled="">Insert Image</button></div>
				                            </div>
				                        </div>
				                    </div>
				                    <div class="modal" aria-hidden="false" tabindex="-1" role="dialog" aria-label="Insert Video">
				                        <div class="modal-dialog">
				                            <div class="modal-content">
				                                <div class="modal-header">
				                                    <h4 class="modal-title">Insert Video</h4>
				                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">×</button>
				                                </div>
				                                <div class="modal-body">
				                                    <div class="form-group note-form-group row-fluid">
				                                        <label class="note-form-label">Video URL <small class="text-muted">(YouTube, Vimeo, Vine, Instagram, DailyMotion or Youku)</small></label>
				                                        <input class="note-video-url form-control note-form-control note-input" type="text" />
				                                    </div>
				                                </div>
				                                <div class="modal-footer"><button type="submit" href="#" class="btn btn-primary note-btn note-btn-primary note-video-btn legitRipple" disabled="">Insert Video</button></div>
				                            </div>
				                        </div>
				                    </div>
				                    <div class="modal" aria-hidden="false" tabindex="-1" role="dialog" aria-label="Help">
				                        <div class="modal-dialog">
				                            <div class="modal-content">
				                                <div class="modal-header">
				                                    <h4 class="modal-title">Help</h4>
				                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" aria-hidden="true">×</button>
				                                </div>
				                                <div class="modal-body" style="max-height: 300px; overflow: scroll;">
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>ENTER</kbd></label><span>Insert Paragraph</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+Z</kbd></label><span>Undoes the last command</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+Y</kbd></label><span>Redoes the last command</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>TAB</kbd></label><span>Tab</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>SHIFT+TAB</kbd></label><span>Untab</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+B</kbd></label><span>Set a bold style</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+I</kbd></label><span>Set a italic style</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+U</kbd></label><span>Set a underline style</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+SHIFT+S</kbd></label><span>Set a strikethrough style</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+BACKSLASH</kbd></label><span>Clean a style</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+SHIFT+L</kbd></label><span>Set left align</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+SHIFT+E</kbd></label><span>Set center align</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+SHIFT+R</kbd></label><span>Set right align</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+SHIFT+J</kbd></label><span>Set full align</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+SHIFT+NUM7</kbd></label><span>Toggle unordered list</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+SHIFT+NUM8</kbd></label><span>Toggle ordered list</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+LEFTBRACKET</kbd></label><span>Outdent on current paragraph</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+RIGHTBRACKET</kbd></label><span>Indent on current paragraph</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+NUM0</kbd></label><span>Change current block's format as a paragraph(P tag)</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+NUM1</kbd></label><span>Change current block's format as H1</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+NUM2</kbd></label><span>Change current block's format as H2</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+NUM3</kbd></label><span>Change current block's format as H3</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+NUM4</kbd></label><span>Change current block's format as H4</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+NUM5</kbd></label><span>Change current block's format as H5</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+NUM6</kbd></label><span>Change current block's format as H6</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+ENTER</kbd></label><span>Insert horizontal rule</span>
				                                    <div class="help-list-item"></div>
				                                    <label style="width: 180px; margin-right: 10px;"><kbd>CTRL+K</kbd></label><span>Show Link Dialog</span>
				                                </div>
				                                <div class="modal-footer">
				                                    <p class="text-center">
				                                        <a href="http://summernote.org/" target="_blank">Summernote 0.8.10</a> · <a href="https://github.com/summernote/summernote" target="_blank">Project</a> ·
				                                        <a href="https://github.com/summernote/summernote/issues" target="_blank">Issues</a>
				                                    </p>
				                                </div>
				                            </div>
				                        </div>
				                    </div>
				                </div>
				            </div>
				            <div class="tab-pane fade" id="right-icon-tab4">
				                <h4 class="card-title">Осмотр других специалистов</h4>
				                <table class="table table-hover table-columned">
				                    <thead>
				                        <tr class="bg-blue text-center">
				                            <th>ID</th>
				                            <th>ФИО</th>

				                            <th>Дата визита</th>
				                            <th>Специалист</th>
				                            <th>Тип Группы</th>
				                            <th>Мед услуга</th>
				                            <th class="text-center">Действия</th>
				                        </tr>
				                    </thead>
				                    <tbody>
				                        <tr class="text-center">
				                            <td>1</td>
				                            <td>2</td>

				                            <td>4</td>
				                            <td>5</td>
				                            <td>5</td>
				                            <td>6</td>
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
				            <div class="tab-pane fade" id="right-icon-tab5">
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
				                                                                    aria-labelledby="select2-location-eh-container"
				                                                                >
				                                                                    <span class="select2-selection__rendered" id="select2-location-eh-container"><span class="select2-selection__placeholder">Выбрать категорию</span></span>
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
				                                                                    aria-labelledby="select2-position-0e-container"
				                                                                >
				                                                                    <span class="select2-selection__rendered" id="select2-position-0e-container"><span class="select2-selection__placeholder">Выбрать услугу</span></span>
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
				                                                            <tr class="bg-blue text-center">
				                                                                <th>ID</th>
				                                                                <th>ФИО</th>

				                                                                <th>Категория</th>
				                                                                <th>Мед Услуга</th>
				                                                                <th>Специалист</th>
				                                                            </tr>
				                                                        </thead>
				                                                        <tbody>
				                                                            <tr class="text-center">
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
				                            <tr class="bg-blue text-center">
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
				                            <tr class="text-center">
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
				                            <tr class="text-center">
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
				                            <tr class="text-center">
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

				            <div class="tab-pane fade" id="right-icon-tab6">
				                <h4 class="card-title">Мои Заключение</h4>
				                <table class="table table-hover table-columned">
				                    <thead>
				                        <tr class="bg-blue text-center">
				                            <th>ID</th>
				                            <th>ФИО</th>
				                            <th>Дата и время</th>
				                            <th>Тип визита</th>
				                            <th>Тип Группы</th>
				                            <th>Мед услуга</th>
				                            <th class="text-center">Действия</th>
				                        </tr>
				                    </thead>
				                    <tbody>
				                        <tr class="text-center">
				                            <td>1</td>
				                            <td>2</td>
				                            <td>4</td>
				                            <td>5</td>
				                            <td>6</td>
				                            <td>7</td>
				                            <td class="text-center">
				                                <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle" data-toggle="dropdown"><i class="icon-eye mr-2"></i> Просмотр</button>
				                                <div class="dropdown-menu dropdown-menu-right">
				                                    <a href="#" data-toggle="modal" data-target="#modal_2323" class="dropdown-item"><i class="icon-paste2"></i>История</a>
				                                </div>
				                            </td>
				                        </tr>
				                    </tbody>
				                </table>
				            </div>

				            <!-- Basic modal -->
				            <div id="modal_2323" class="modal fade" tabindex="-1">
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

				            <div class="tab-pane fade" id="right-icon-tab8">
				                <h4 class="card-title">Анализ Пациента</h4>
				                <div class="card">
				                    <div class="table-responsive">
				                        <table class="table">
				                            <thead>
				                                <tr class="bg-blue text-center">
				                                    <th>ID</th>
				                                    <th>ФИО</th>
				                                    <th>Дата и время</th>
				                                    <th>Имя анализа</th>
				                                    <th>Специалист</th>
				                                    <th>Результаты</th>
				                                    <th>Норматив</th>
				                                    <th>Примечание</th>
				                                </tr>
				                            </thead>
				                            <tbody>
				                                <tr class="text-center">
				                                    <td>0001</td>
				                                    <td>Якубов Фарход Абдурасулович</td>
				                                    <td>13.03.2020 13:04</td>

				                                    <td>Анализ мочи</td>
				                                    <td>Ахмедова З</td>
				                                    <td>10-12</td>
				                                    <td>10</td>
				                                    <td>Тест</td>
				                                </tr>
				                                <tr class="text-center">
				                                    <td>0001</td>
				                                    <td>Якубов Фарход Абдурасулович</td>
				                                    <td>13.03.2020 13:04</td>

				                                    <td>Анализ мочи</td>
				                                    <td>Ахмедова З</td>
				                                    <td>10-12</td>
				                                    <td>10</td>
				                                    <td>Тест</td>
				                                </tr>
				                                <tr class="text-center">
				                                    <td>0001</td>
				                                    <td>Якубов Фарход Абдурасулович</td>
				                                    <td>13.03.2020 13:04</td>

				                                    <td>Анализ мочи</td>
				                                    <td>Ахмедова З</td>
				                                    <td>10-12</td>
				                                    <td>10</td>
				                                    <td>Тест</td>
				                                </tr>
				                                <tr class="text-center">
				                                    <td>0001</td>
				                                    <td>Якубов Фарход Абдурасулович</td>
				                                    <td>13.03.2020 13:04</td>

				                                    <td>Анализ мочи</td>
				                                    <td>Ахмедова З</td>
				                                    <td>10-12</td>
				                                    <td>10</td>
				                                    <td>Тест</td>
				                                </tr>
				                            </tbody>
				                        </table>
				                    </div>
				                </div>
				            </div>
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
    <?php include 'layout/footer.php' ?>
    <!-- /footer -->

</body>
</html>
