<div class="content">
<!-- Starting step -->
<div class="card">
    <div class="card-header bg-white header-elements-inline">
        <h6 class="card-title">
            Добавить Услугу
            <span class="text-muted font-size-base ml-2">
                Направит пациента
            </span>
        </h6>
    </div>
    <form class="wizard-form steps-enable-all" action="#" data-fouc>
        <h6>
            Пациент
        </h6>
        <fieldset>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>
                            Выбрать Группу:
                        </label>
                        <select name="location" data-placeholder="Выбрать категорию" class="form-control select select2-hidden-accessible"
                        data-fouc>
                            <option>
                            </option>
                            <optgroup label="Выбрать категорию">
                                <option value="1">
                                    Лаборатория
                                </option>
                                <option value="2">
                                    Консултация
                                </option>
                                <option value="3">
                                    Физиотерапия
                                </option>
                                <option value="4">
                                    Нейрохирургия
                                </option>
                                <option value="2">
                                    Травмотология
                                </option>
                            </optgroup>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>
                            Мед Услуги:
                        </label>
                        <select name="position" data-placeholder="Выбрать услугу" class="form-control select select2-hidden-accessible"
                        data-fouc>
                            <option>
                            </option>
                            <optgroup label="Наши Услуги">
                                <option value="1">
                                    Осмотр Терапевта
                                </option>
                                <option value="2">
                                    Осмотр Травмотолога
                                </option>
                                <option value="3">
                                    Осмотр Нейрохирурга
                                </option>
                                <option value="4">
                                    Осмотр Эндокринолога
                                </option>
                            </optgroup>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>
                            Имя Специалиста:
                        </label>
                        <input type="text" name="name" class="form-control">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>
                            Кабинет Врача:
                        </label>
                        <input type="text" name="tel" class="form-control"> </div>
                    </div>
                </div>
        </fieldset>
        <h6>
            Создать Пакет
        </h6>
        <fieldset>
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">
                        Создать пакет услуг
                    </h5>
                </div>
                <button type="button" data-toggle="modal" data-target="#modal_default333"
                class="btn alpha-blue text-blue-800 border-blue-600 legitRipple">
                    Создать пакет
                </button>
                <!-- Basic modal -->
                <div id="modal_default333" class="modal fade" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">
                                    Создать пакет
                                </h5>
                                <button type="button" class="close" data-dismiss="modal">
                                    &times;
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">
                                                Название пакета
                                            </label>
                                            <input type="text" class="form-control" placeholder="Название пакета">
                                        </div>
                                        <h6>
                                            Список услуг
                                        </h6>
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">
                                                Выберите группу услуг
                                            </label>
                                            <input type="text" class="form-control" placeholder="Группа услуг">
                                        </div>
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">
                                                Выберите услугу
                                            </label>
                                            <input type="text" class="form-control" placeholder="Услуга">
                                        </div>
                                        <div class="form-group form-group-float">
                                            <label class="form-group-float-label is-visible">
                                                Количество
                                            </label>
                                            <input type="number" class="form-control" placeholder="Количество">
                                        </div>
                                        <button type="button" class="btn btn-outline bg-primary border-primary text-primary-800 btn-icon border-2 ml-2 legitRipple">
                                            <i class="icon-check">
                                            </i>
                                            Добавить
                                        </button>
                                        <p>
                                        </p>
                                        <div class="form-group form-group-float">
                                            <h6>
                                                Выбранные услуги
                                            </h6>
                                        </div>
                                        <table class="table">
                                            <thead>
                                                <tr class="bg-blue">
                                                    <th>
                                                        Услуга
                                                    </th>
                                                    <th>
                                                        Количество
                                                    </th>
                                                    <th>
                                                        Действия
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        Название услуги
                                                    </td>
                                                    <td>
                                                        <div class="form-group form-group-float mt-2">
                                                            <input type="number" class="form-control" readonly placeholder="Количество">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-outline bg-danger border-danger text-danger-800 btn-icon border-2 ml-2 legitRipple">
                                                            <i class="icon-trash">
                                                            </i>
                                                        </button>
                                                        <button type="button" class="btn btn-outline bg-primary border-primary text-primary-800 btn-icon border-2 ml-2 legitRipple">
                                                            <i class="icon-pencil">
                                                            </i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-link" data-dismiss="modal">
                                    Отмена
                                </button>
                                <button type="button" class="btn bg-primary">
                                    Сохранить
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /basic modal -->
                <div class="card-body">
                    <div class="bootstrap-duallistbox-container row moveonselect">
                        <div class="box1 col-md-6">
                            <label for="bootstrap-duallistbox-nonselected-list_" style="display: none;">
                            </label>
                            <input class="filter form-control" type="text" placeholder="Filter">
                            <div class="btn-group buttons">
                                <button type="button" class="btn moveall btn-light legitRipple" title="Move all">
                                    <i class="icon-arrow-right22">
                                    </i>
                                    <i class="icon-arrow-right22">
                                    </i>
                                </button>
                                <button type="button" class="btn move btn-light legitRipple" title="Move selected">
                                    <i class="icon-arrow-right22">
                                    </i>
                                </button>
                            </div>
                            <select multiple="multiple" id="bootstrap-duallistbox-nonselected-list_"
                            class="form-control" name="_helper1" style="height: 302px;">
                                <option value="option1" selected="">
                                    Classical mechanics
                                </option>
                                <option value="option2">
                                    Electromagnetism
                                </option>
                                <option value="option4">
                                    Relativity
                                </option>
                                <option value="option5" selected="">
                                    Quantum mechanics
                                </option>
                                <option value="option7">
                                    Astrophysics
                                </option>
                                <option value="option8" selected="">
                                    Biophysics
                                </option>
                                <option value="option9">
                                    Chemical physics
                                </option>
                                <option value="option10">
                                    Econophysics
                                </option>
                                <option value="option11">
                                    Geophysics
                                </option>
                                <option value="option12">
                                    Medical physics
                                </option>
                                <option value="option13">
                                    Physical chemistry
                                </option>
                                <option value="option14" selected="">
                                    Continuum mechanics
                                </option>
                                <option value="option15">
                                    Electrodynamics
                                </option>
                                <option value="option16" selected="">
                                    Quantum field theory
                                </option>
                                <option value="option17">
                                    Scattering theory
                                </option>
                                <option value="option18" selected="">
                                    Chaos theory
                                </option>
                                <option value="option19" selected="">
                                    Newton's laws of motion
                                </option>
                                <option value="option20">
                                    Thermodynamics
                                </option>
                            </select>
                            <span class="info-container">
                                <span class="info">
                                    Showing all 18
                                </span>
                                <button type="button" class="btn clear1 float-right btn-light btn-xs legitRipple">
                                    show all
                                </button>
                            </span>
                        </div>
                        <div class="box2 col-md-6">
                            <label for="bootstrap-duallistbox-selected-list_" style="display: none;">
                            </label>
                            <input class="filter form-control" type="text" placeholder="Filter">
                            <div class="btn-group buttons">
                                <button type="button" class="btn remove btn-light legitRipple" title="Remove selected">
                                    <i class="icon-arrow-left22">
                                    </i>
                                </button>
                                <button type="button" class="btn removeall btn-light legitRipple" title="Remove all">
                                    <i class="icon-arrow-left22">
                                    </i>
                                    <i class="icon-arrow-left22">
                                    </i>
                                </button>
                            </div>
                            <select multiple="multiple" id="bootstrap-duallistbox-selected-list_"
                            class="form-control" name="_helper2" style="height: 302px;">
                            </select>
                            <span class="info-container">
                                <span class="info">
                                    Empty list
                                </span>
                                <button type="button" class="btn clear2 float-right btn-light btn-xs legitRipple">
                                    show all
                                </button>
                            </span>
                        </div>
                    </div>
                    <select multiple="multiple" class="form-control listbox-tall" data-fouc=""
                    style="display: none;">
                        <option value="option1" selected="">
                            Classical mechanics
                        </option>
                        <option value="option2">
                            Electromagnetism
                        </option>
                        <option value="option4">
                            Relativity
                        </option>
                        <option value="option5" selected="">
                            Quantum mechanics
                        </option>
                        <option value="option7">
                            Astrophysics
                        </option>
                        <option value="option8" selected="">
                            Biophysics
                        </option>
                        <option value="option9">
                            Chemical physics
                        </option>
                        <option value="option10">
                            Econophysics
                        </option>
                        <option value="option11">
                            Geophysics
                        </option>
                        <option value="option12">
                            Medical physics
                        </option>
                        <option value="option13">
                            Physical chemistry
                        </option>
                        <option value="option14" selected="">
                            Continuum mechanics
                        </option>
                        <option value="option15">
                            Electrodynamics
                        </option>
                        <option value="option16" selected="">
                            Quantum field theory
                        </option>
                        <option value="option17">
                            Scattering theory
                        </option>
                        <option value="option18" selected="">
                            Chaos theory
                        </option>
                        <option value="option19" selected="">
                            Newton's laws of motion
                        </option>
                        <option value="option20">
                            Thermodynamics
                        </option>
                    </select>
                </div>
            </div>
        </fieldset>
        <h6>
            Завершить
        </h6>
        <fieldset>
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">
                        Услуга пациента
                    </h5>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                            <a class="list-icons-item" data-action="reload"></a>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-xl">
                        <thead>
                            <tr class="bg-blue">
                                <th>
                                    ID
                                </th>
                                <th>
                                    ФИО
                                </th>
                                <th>
                                    Услуга/Пакет
                                </th>
                                <th>
                                    Состав услуги или пакета
                                </th>
                                <th>
                                    Стоимость
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    1
                                </td>
                                <td>
                                    2
                                </td>
                                <td>
                                    <span class="badge badge-success">
                                        Услуга
                                    </span>
                                    <span class="badge badge-warning">
                                        Пакет
                                    </span>
                                </td>
                                <td>
                                    5
                                </td>
                                <td>
                                    6
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </fieldset>
    </form>
    </div>

<div class="card">
    <div class="card-header header-elements-inline">
        <h6 class="card-title">
            Просмотр визита
        </h6>
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
                <a href="#right-icon-tab1" class="nav-link active" data-toggle="tab">Подробно <i class="icon-nbsp ml-3"></i></a>
            </li>
            <li class="nav-item">
                <a href="#right-icon-tab2" class="nav-link" data-toggle="tab">Осмотр <i class="icon-compose ml-3"></i></a>
            </li>
            <li class="nav-item">
                <a href="#right-icon-tab4" class="nav-link " data-toggle="tab">Другие визиты <i class="icon-users4 ml-3"></i></a>
            </li>
            <li class="nav-item">
                <a href="#right-icon-tab5" class="nav-link " data-toggle="tab">Направления <i class="icon-user-plus ml-3"></i></a>
            </li>
            <li class="nav-item">
                <a href="#right-icon-tab6" class="nav-link " data-toggle="tab">Визиты <i class="icon-spinner11 ml-3"></i></a>
            </li>
            <li class="nav-item">
                <a href="#right-icon-tab8" class="nav-link " data-toggle="tab">Анализы<i class="icon-droplets ml-3"></i></a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="right-icon-tab1">
                <div class="card">
                    <table class="table table-togglable table-hover">
                        <thead>
                            <tr class="bg-blue">
                                <th>
                                    ID
                                </th>
                                <th>
                                    Имя
                                </th>
                                <th>
                                    Фамилия
                                </th>
                                <th>
                                    Дата визита
                                </th>
                                <th>
                                    Мед Услуга
                                </th>
                                <th>
                                    Статус
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    00001
                                </td>
                                <td>
                                    Фарход
                                </td>
                                <td>
                                    Якубов
                                </td>
                                <td>
                                    04.10.2020
                                </td>
                                <td>
                                    Осмотр терапевта
                                </td>
                                <td>
                                    <span class="badge badge-success">
                                        Оплачено
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="right-icon-tab2">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">
                            Осмотр Пациента
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="summernote" style="display: none;">
                            <h2>
                                Apollo 11
                            </h2>
                            <div class="float-right" style="margin-left: 20px;">
                                <img alt="Saturn V carrying Apollo 11" class="right" src="http://c.cksource.com/a/1/img/sample.jpg">
                            </div>
                            <p>
                                <strong>
                                    Apollo 11
                                </strong>
                                was the spaceflight that landed the first humans, Americans
                                <a href="#">Neil Armstrong</a>
                                and
                                <a href="#">Buzz Aldrin</a>
                                , on the Moon on July 20, 1969, at 20:18 UTC. Armstrong became the first
                                to step onto the lunar surface 6 hours later on July 21 at 02:56 UTC.
                            </p>
                            <p class="mb-3">
                                Armstrong spent about
                                <s>
                                    three and a half
                                </s>
                                two and a half hours outside the spacecraft, Aldrin slightly less; and
                                together they collected 47.5 pounds (21.5&nbsp;kg) of lunar material for
                                return to Earth. A third member of the mission,
                                <a href="#">Michael Collins</a>
                                , piloted the
                                <a href="#">command</a>
                                spacecraft alone in lunar orbit until Armstrong and Aldrin returned to
                                it for the trip back to Earth.
                            </p>
                            <h5 class="font-weight-semibold">
                                Technical details
                            </h5>
                            <p>
                                Launched by a
                                <strong>
                                    Saturn V
                                </strong>
                                rocket from
                                <a href="#">Kennedy Space Center</a>
                                in Merritt Island, Florida on July 16, Apollo 11 was the fifth manned
                                mission of
                                <a href="#">NASA</a>
                                's Apollo program. The Apollo spacecraft had three parts:
                            </p>
                            <ol>
                                <li>
                                    <strong>
                                        Command Module
                                    </strong>
                                    with a cabin for the three astronauts which was the only part which landed
                                    back on Earth
                                </li>
                                <li>
                                    <strong>
                                        Service Module
                                    </strong>
                                    which supported the Command Module with propulsion, electrical power,
                                    oxygen and water
                                </li>
                                <li>
                                    <strong>
                                        Lunar Module
                                    </strong>
                                    for landing on the Moon.
                                </li>
                            </ol>
                            <p class="mb-3">
                                After being sent to the Moon by the Saturn V's upper stage, the astronauts
                                separated the spacecraft from it and travelled for three days until they
                                entered into lunar orbit. Armstrong and Aldrin then moved into the Lunar
                                Module and landed in the
                                <a href="#">Sea of Tranquility</a>
                                . They stayed a total of about 21 and a half hours on the lunar surface.
                                After lifting off in the upper part of the Lunar Module and rejoining Collins
                                in the Command Module, they returned to Earth and landed in the
                                <a href="#">Pacific Ocean</a>
                                on July 24.
                            </p>
                            <h5 class="font-weight-semibold">
                                Mission crew
                            </h5>
                            <div class="card card-table table-responsive shadow-0">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>
                                                Position
                                            </th>
                                            <th>
                                                Astronaut
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                Commander
                                            </td>
                                            <td>
                                                Neil A. Armstrong
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Command Module Pilot
                                            </td>
                                            <td>
                                                Michael Collins
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Lunar Module Pilot
                                            </td>
                                            <td>
                                                Edwin "Buzz" E. Aldrin, Jr.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            Заключение Врача:
                        </div>
                    </div>
                    <output class="note-status-output" aria-live="polite">
                    </output>
                    <div class="note-statusbar" role="status">
                        <output class="note-status-output" aria-live="polite">
                        </output>
                        <div class="note-resizebar" role="seperator" aria-orientation="horizontal"
                        aria-label="Resize">
                            <div class="note-icon-bar">
                            </div>
                            <div class="note-icon-bar">
                            </div>
                            <div class="note-icon-bar">
                            </div>
                        </div>
                    </div>
                    <div class="modal link-dialog" aria-hidden="false" tabindex="-1" role="dialog"
                    aria-label="Insert Link">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">
                                        Insert Link
                                    </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    aria-hidden="true">
                                        ×
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group note-form-group">
                                        <label class="note-form-label">
                                            Text to display
                                        </label>
                                        <input class="note-link-text form-control note-form-control  note-input"
                                        type="text">
                                    </div>
                                    <div class="form-group note-form-group">
                                        <label class="note-form-label">
                                            To what URL should this link go?
                                        </label>
                                        <input class="note-link-url form-control note-form-control note-input"
                                        type="text" value="http://">
                                    </div>
                                    <label class="custom-control custom-checkbox" for="sn-checkbox-open-in-new-window">
                                        <input role="checkbox" type="checkbox" class="custom-control-input" id="sn-checkbox-open-in-new-window"
                                        checked="" aria-checked="true">
                                        <span class="custom-control-indicator">
                                        </span>
                                        <span class="custom-control-description">
                                            Open in new window
                                        </span>
                                    </label>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" href="#" class="btn btn-primary note-btn note-btn-primary note-link-btn legitRipple"
                                    disabled="">
                                        Insert Link
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal" aria-hidden="false" tabindex="-1" role="dialog" aria-label="Insert Image">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">
                                        Insert Image
                                    </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    aria-hidden="true">
                                        ×
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group note-form-group note-group-select-from-files">
                                        <label class="note-form-label">
                                            Select from files
                                        </label>
                                        <div class="uniform-uploader">
                                            <input class="note-image-input note-form-control note-input" type="file"
                                            name="files" accept="image/*" multiple="multiple">
                                            <span class="filename" style="user-select: none;">
                                                No file selected
                                            </span>
                                            <span class="action btn bg-warning-400 legitRipple" style="user-select: none;">
                                                Choose Files
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group note-group-image-url" style="overflow:auto;">
                                        <label class="note-form-label">
                                            Image URL
                                        </label>
                                        <input class="note-image-url form-control note-form-control note-input  col-md-12"
                                        type="text">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" href="#" class="btn btn-primary note-btn note-btn-primary note-image-btn legitRipple"
                                    disabled="">
                                        Insert Image
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal" aria-hidden="false" tabindex="-1" role="dialog" aria-label="Insert Video">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">
                                        Insert Video
                                    </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    aria-hidden="true">
                                        ×
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group note-form-group row-fluid">
                                        <label class="note-form-label">
                                            Video URL
                                            <small class="text-muted">
                                                (YouTube, Vimeo, Vine, Instagram, DailyMotion or Youku)
                                            </small>
                                        </label>
                                        <input class="note-video-url form-control note-form-control note-input"
                                        type="text">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" href="#" class="btn btn-primary note-btn note-btn-primary note-video-btn legitRipple"
                                    disabled="">
                                        Insert Video
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal" aria-hidden="false" tabindex="-1" role="dialog" aria-label="Help">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">
                                        Help
                                    </h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                                    aria-hidden="true">
                                        ×
                                    </button>
                                </div>
                                <div class="modal-body" style="max-height: 300px; overflow: scroll;">
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            ENTER
                                        </kbd>
                                    </label>
                                    <span>
                                        Insert Paragraph
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+Z
                                        </kbd>
                                    </label>
                                    <span>
                                        Undoes the last command
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+Y
                                        </kbd>
                                    </label>
                                    <span>
                                        Redoes the last command
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            TAB
                                        </kbd>
                                    </label>
                                    <span>
                                        Tab
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            SHIFT+TAB
                                        </kbd>
                                    </label>
                                    <span>
                                        Untab
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+B
                                        </kbd>
                                    </label>
                                    <span>
                                        Set a bold style
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+I
                                        </kbd>
                                    </label>
                                    <span>
                                        Set a italic style
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+U
                                        </kbd>
                                    </label>
                                    <span>
                                        Set a underline style
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+SHIFT+S
                                        </kbd>
                                    </label>
                                    <span>
                                        Set a strikethrough style
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+BACKSLASH
                                        </kbd>
                                    </label>
                                    <span>
                                        Clean a style
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+SHIFT+L
                                        </kbd>
                                    </label>
                                    <span>
                                        Set left align
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+SHIFT+E
                                        </kbd>
                                    </label>
                                    <span>
                                        Set center align
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+SHIFT+R
                                        </kbd>
                                    </label>
                                    <span>
                                        Set right align
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+SHIFT+J
                                        </kbd>
                                    </label>
                                    <span>
                                        Set full align
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+SHIFT+NUM7
                                        </kbd>
                                    </label>
                                    <span>
                                        Toggle unordered list
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+SHIFT+NUM8
                                        </kbd>
                                    </label>
                                    <span>
                                        Toggle ordered list
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+LEFTBRACKET
                                        </kbd>
                                    </label>
                                    <span>
                                        Outdent on current paragraph
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+RIGHTBRACKET
                                        </kbd>
                                    </label>
                                    <span>
                                        Indent on current paragraph
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+NUM0
                                        </kbd>
                                    </label>
                                    <span>
                                        Change current block's format as a paragraph(P tag)
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+NUM1
                                        </kbd>
                                    </label>
                                    <span>
                                        Change current block's format as H1
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+NUM2
                                        </kbd>
                                    </label>
                                    <span>
                                        Change current block's format as H2
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+NUM3
                                        </kbd>
                                    </label>
                                    <span>
                                        Change current block's format as H3
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+NUM4
                                        </kbd>
                                    </label>
                                    <span>
                                        Change current block's format as H4
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+NUM5
                                        </kbd>
                                    </label>
                                    <span>
                                        Change current block's format as H5
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+NUM6
                                        </kbd>
                                    </label>
                                    <span>
                                        Change current block's format as H6
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+ENTER
                                        </kbd>
                                    </label>
                                    <span>
                                        Insert horizontal rule
                                    </span>
                                    <div class="help-list-item">
                                    </div>
                                    <label style="width: 180px; margin-right: 10px;">
                                        <kbd>
                                            CTRL+K
                                        </kbd>
                                    </label>
                                    <span>
                                        Show Link Dialog
                                    </span>
                                </div>
                                <div class="modal-footer">
                                    <p class="text-center">
                                        <a href="http://summernote.org/" target="_blank">Summernote 0.8.10</a>
                                        ·
                                        <a href="https://github.com/summernote/summernote" target="_blank">Project</a>
                                        ·
                                        <a href="https://github.com/summernote/summernote/issues" target="_blank">Issues</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="right-icon-tab4">
                <h4 class="card-title">
                    Осмотр других специалистов
                </h4>
                <table class="table table-hover table-columned">
                    <thead>
                        <tr class="bg-blue">
                            <th>
                                ID
                            </th>
                            <th>
                                Имя
                            </th>
                            <th>
                                Фамилия
                            </th>
                            <th>
                                Дата визита
                            </th>
                            <th>
                                Специалист
                            </th>
                            <th>
                                Тип Группы
                            </th>
                            <th>
                                Мед услуга
                            </th>
                            <th class="text-center">
                                Действия
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                1
                            </td>
                            <td>
                                2
                            </td>
                            <td>
                                3
                            </td>
                            <td>
                                4
                            </td>
                            <td>
                                5
                            </td>
                            <td>
                                5
                            </td>
                            <td>
                                6
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle"
                                data-toggle="dropdown">
                                    <i class="icon-eye mr-2">
                                    </i>
                                    Просмотр
                                </button>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#" class="dropdown-item"><i class="icon-paste2"></i>Заключения врача</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="right-icon-tab5">
                <h4 class="card-title">
                    Мои направление
                </h4>
                <div class="card">
                    <table class="table table-togglable table-hover">
                        <thead>
                            <tr class="bg-blue">
                                <th>
                                    ID
                                </th>
                                <th>
                                    Имя
                                </th>
                                <th>
                                    Фамилия
                                </th>
                                <th>
                                    Дата и время
                                </th>
                                <th>
                                    Тип группы
                                </th>
                                <th>
                                    Мед Услуга
                                </th>
                                <th>
                                    Статус
                                </th>
                                <th class="text-center">
                                    Действия
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    00001
                                </td>
                                <td>
                                    Фарход
                                </td>
                                <td>
                                    Якубов
                                </td>
                                <td>
                                    04.10.2020 12:01
                                </td>
                                <td>
                                    Консултация
                                </td>
                                <td>
                                    Осмотр терапевта
                                </td>
                                <td>
                                    <span class="badge badge-success">
                                        Оплачено
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle"
                                    data-toggle="dropdown">
                                        <i class="icon-eye mr-2">
                                        </i>
                                        Просмотр
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item"><i class="icon-paste2"></i>Заключения врача</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <td>
                                    00001
                                </td>
                                <td>
                                    Фарход
                                </td>
                                <td>
                                    Якубов
                                </td>
                                <td>
                                    04.10.2020 12:01
                                </td>
                                <td>
                                    Лаборатория
                                </td>
                                <td>
                                    Общий анализ крови
                                </td>
                                <td>
                                    <span class="badge badge-warning">
                                        В кассе
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle"
                                    data-toggle="dropdown">
                                        <i class="icon-eye mr-2">
                                        </i>
                                        Просмотр
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a href="#" class="dropdown-item"><i class="icon-paste2"></i>Заключения врача</a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr>
                                <td>
                                    00001
                                </td>
                                <td>
                                    Фарход
                                </td>
                                <td>
                                    Якубов
                                </td>
                                <td>
                                    04.10.2020 12:01
                                </td>
                                <td>
                                    Физиотерапия
                                </td>
                                <td>
                                    Магниотерапия
                                </td>
                                <td>
                                    <span class="badge badge-primary">
                                        У Специалиста
                                    </span>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle"
                                    data-toggle="dropdown">
                                        <i class="icon-eye mr-2">
                                        </i>
                                        Просмотр
                                    </button>
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
                <h4 class="card-title">
                    Мои пациенты
                </h4>
                <table class="table table-hover table-columned">
                    <thead>
                        <tr class="bg-blue">
                            <th>
                                ID
                            </th>
                            <th>
                                ФИО
                            </th>
                            <th>
                                Дата и время
                            </th>
                            <th>
                                Тип визита
                            </th>
                            <th>
                                Тип Группы
                            </th>
                            <th>
                                Мед услуга
                            </th>
                            <th class="text-center">
                                Действия
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                1
                            </td>
                            <td>
                                2
                            </td>
                            <td>
                                4
                            </td>
                            <td>
                                5
                            </td>
                            <td>
                                6
                            </td>
                            <td>
                                7
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-primary btn-lg legitRipple dropdown-toggle"
                                data-toggle="dropdown">
                                    <i class="icon-eye mr-2">
                                    </i>
                                    Просмотр
                                </button>
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
                            <h5 class="modal-title">
                                История пациента подробно
                            </h5>
                            <button type="button" class="close" data-dismiss="modal">
                                &times;
                            </button>
                        </div>
                        <div class="modal-body">
                            <ul>
                                <li>
                                    <b>
                                        Группа
                                    </b>
                                    - Лаборатория
                                </li>
                                <li>
                                    <b>
                                        Специалист
                                    </b>
                                    - Камолов.Ш
                                </li>
                                <li>
                                    <b>
                                        Примечание
                                    </b>
                                    - тесттесттесттесттесттесттесттесттесттесттесттесттесттесттесттест
                                </li>
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-link" data-dismiss="modal">
                                Закрыть
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /basic modal -->
	<div class="tab-pane fade" id="right-icon-tab8">
	    <h4 class="card-title">
	        Анализ Пациента
	    </h4>
	    <div class="card">
	        <div class="table-responsive">
	            <table class="table">
	                <thead>
	                    <tr class="bg-blue">
	                        <th>
	                            ID
	                        </th>
	                        <th>
	                            ФИО
	                        </th>
	                        <th>
	                            Имя анализа
	                        </th>
	                        <th>
	                            Специалист
	                        </th>
	                        <th>
	                            Результаты
	                        </th>
	                        <th>
	                            Норматив
	                        </th>
	                        <th>
	                            Примечание
	                        </th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <tr>
	                        <td>
	                            0001
	                        </td>
	                        <td>
	                            Якубов Фарход Абдурасулович
	                        </td>
	                        <td>
	                            Анализ мочи
	                        </td>
	                        <td>
	                            Ахмедова З
	                        </td>
	                        <td>
	                            10-12
	                        </td>
	                        <td>
	                            10
	                        </td>
	                        <td>
	                            Тест
	                        </td>
	                    </tr>
	                    <tr>
	                        <td>
	                            0001
	                        </td>
	                        <td>
	                            Якубов Фарход Абдурасулович
	                        </td>
	                        <td>
	                            Анализ мочи
	                        </td>
	                        <td>
	                            Ахмедова З
	                        </td>
	                        <td>
	                            10-12
	                        </td>
	                        <td>
	                            10
	                        </td>
	                        <td>
	                            Тест
	                        </td>
	                    </tr>
	                    <tr>
	                        <td>
	                            0001
	                        </td>
	                        <td>
	                            Якубов Фарход Абдурасулович
	                        </td>
	                        <td>
	                            Анализ мочи
	                        </td>
	                        <td>
	                            Ахмедова З
	                        </td>
	                        <td>
	                            10-12
	                        </td>
	                        <td>
	                            10
	                        </td>
	                        <td>
	                            Тест
	                        </td>
	                    </tr>
	                    <tr>
	                        <td>
	                            0001
	                        </td>
	                        <td>
	                            Якубов Фарход Абдурасулович
	                        </td>
	                        <td>
	                            Анализ мочи
	                        </td>
	                        <td>
	                            Ахмедова З
	                        </td>
	                        <td>
	                            10-12
	                        </td>
	                        <td>
	                            10
	                        </td>
	                        <td>
	                            Тест
	                        </td>
	                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
                                    <!-- /content wrapper -->
                                    <!-- Footer -->
                                    <!-- /footer -->
    <!-- /starting step -->
</div>
