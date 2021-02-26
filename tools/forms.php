<?php

// include 'functions/model.php';

class PatientForm extends Model
{
    public $table = 'users';

    public function form($pk = null)
    {
        global $db;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        if($_SESSION['message']){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="user_level" value="15">
            <input type="hidden" name="status" value="0">

            <div class="row">
                <div class="col-md-3">
                    <fieldset>

                        <div class="form-group">
                            <label>Фамилия пациента:</label>
                            <input type="text" name="last_name" class="form-control" placeholder="Введите Фамилия" value="<?= $post['last_name']?>" required>
                        </div>
                        <div class="form-group">
                            <label>Имя пациента:</label>
                            <input type="text" name="first_name" class="form-control" placeholder="Введите имя" value="<?= $post['first_name']?>" required>
                        </div>
                        <div class="form-group">
                            <label>Отчество пациента:</label>
                            <input type="text" name="father_name" class="form-control" placeholder="Введите Отчество" value="<?= $post['father_name']?>" required>
                        </div>
                        <div class="form-group">
                            <label>Дата рождение:</label>
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                </span>
                                <input type="date" name="dateBith" class="form-control daterange-single" value="<?= $post['dateBith']?>" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-group">
                                <label>Выбирите регион:</label>
                                <select data-placeholder="Выбрать регион" name="region" class="form-control form-control-select2" required>
                                    <option></option>
                                    <?php foreach ($db->query("SELECT DISTINCT pv.name, pv.id FROM region rg LEFT JOIN province pv ON(pv.id=rg.province_id)") as $province): ?>
                                        <optgroup label="<?= $province['name'] ?>">
                                            <?php foreach ($db->query("SELECT * FROM region WHERE province_id = {$province['id']}") as $region): ?>
                                                <option value="<?= $region['name'] ?>" <?= ($post['region'] == $region['name']) ? "selected" : "" ?>><?= $region['name'] ?></option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Адрес проживание:</label>
                            <input type="text" name="residenceAddress" class="form-control" placeholder="Введите адрес" value="<?= $post['residenceAddress']?>">
                        </div>

                        <div class="form-group">
                            <label>Адрес по прописке:</label>
                            <input type="text" name="registrationAddress" class="form-control" placeholder="Введите адрес" value="<?= $post['registrationAddress']?>">
                        </div>


                        <div class="form-group">
                           <label class="d-block font-weight-semibold">Пол</label>

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="gender" <?php if(1 == $post['gender']){echo "checked";} ?> value="1" class="form-check-input" name="unstyled-radio-left" checked>
                                        Мужчина
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" name="gender" <?php if(0 == $post['gender']){echo "checked";} ?> value="0" class="form-check-input" name="unstyled-radio-left">
                                        Женщина
                                    </label>
                                </div>
                        </div>

                    </fieldset>
                </div>

                <div class="col-md-9">

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Серия и номер паспорта:</label>
                            <input type="text" name="passport" placeholder="Серия паспорта" class="form-control" value="<?= $post['passport']?>">
                        </div>
                        <div class="col-md-6">
                            <label>Телефон номер:</label>
                            <input type="text" name="numberPhone" class="form-control" value="<?= ($post['numberPhone']) ? $post['numberPhone'] : '+998'?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Место работы:</label>
                        <input type="text" name="placeWork" placeholder="Введите место работы" class="form-control" value="<?= $post['placeWork']?>">
                    </div>

                    <div class="form-group">
                        <label>Должность:</label>
                        <input type="text" name="position" placeholder="Введите должность" class="form-control" value="<?= $post['position']?>">
                    </div>

                    <!-- <div class="form-group">
                        <label class="d-block font-weight-semibold">Статус</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="resident" id="custom_checkbox_stacked_unchecked">
                            <label class="custom-control-label" for="custom_checkbox_stacked_unchecked">Резидент</label>
                        </div>
                    </div> -->

                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить <i class="icon-paperplane ml-2"></i></button>
            </div>

        </form>
        <?php
    }

    public function success()
    {
        $_SESSION['message'] = '
        <div class="alert alert-info" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render();
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
			<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
			<span class="font-weight-semibold"> '.$message.'</span>
	    </div>
        ';
        render();
    }
}

class VisitReport extends Model
{
    public $table = 'visit';

    public function form_2($pk = null)
    {
        global $db, $patient;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        ?>
        <form method="post" id="form_<?= __CLASS__ ?>" action="<?= add_url() ?>">

            <div class="modal-header bg-info">
                <h5 class="modal-title">Заключение</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="id" id="rep_id" value="<?= $pk ?>">
                <?php if (division_assist() == 2): ?>
                    <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">
                <?php endif; ?>

                <?php if (level() == 12 or level() == 13): ?>
                    <div class="row">
                        <input type="hidden" name="report_title" id="report_title" class="form-control">

                        <div class="col-md-10 offset-md-1">
                            <label class="col-form-label">Примечание:</label>
                            <textarea rows="5" cols="3" name="report_description" id="report_description" class="form-control" placeholder="Описание"><?= $post['report_description'] ?></textarea>
                        </div>

                    </div>
                <?php else: ?>
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <label class="col-form-label">Наименования отчета:</label>
                            <input type="text" name="report_title" id="report_title" value="<?= $post['report_title'] ?>" class="form-control" placeholder="Названия отчета">
                        </div>

                        <div class="col-md-10 offset-md-1">
                            <label class="col-form-label">Описание:</label>
                            <textarea rows="5" cols="3" name="report_description" id="report_description" class="form-control" placeholder="Описание"><?= $post['report_description'] ?></textarea>
                        </div>

                        <div class="col-md-10 offset-md-1">
                            <label class="col-form-label">Диагноз:</label>
                            <textarea rows="3" cols="3" name="report_diagnostic" id="report_diagnostic" class="form-control" placeholder="Заключения"><?= $post['report_diagnostic'] ?></textarea>
                        </div>

                        <div class="col-md-10 offset-md-1">
                            <label class="col-form-label">Рекомендации:</label>
                            <textarea rows="3" cols="3" name="report_recommendation" id="report_recommendation" class="form-control" placeholder="Заключения"><?= $post['report_recommendation'] ?></textarea>
                        </div>

                    </div>
                <?php endif; ?>

            </div>

            <div class="modal-footer">
                <?php if (level() == 10): ?>
                    <!-- <a href="<?= up_url($_GET['user_id'], 'VisitFinish') ?>" onclick="return confirm('Вы точно хотите завершить визит пациента!')" class="btn btn-outline-danger">Завершить</a> -->
                    <input style="display:none;" id="btn_end_submit" type="submit" value="Завершить" name="end"></input>
                    <button class="btn btn-outline-danger btn-sm" type="button" onclick="Verification()">Завершить</button>
                    <script type="text/javascript">
                        function Verification() {
                            event.preventDefault();

                            if (!$('#report_description').val()) {
                                swal({
                                    position: 'top',
                                    title: 'Невозможно завершить!',
                                    text: 'Не написано описание.',
                                    type: 'error',
                                    padding: 30
                                });
                                return 0;
                            }
                            if (!$('#report_diagnostic').val()) {
                                swal({
                                    position: 'top',
                                    title: 'Невозможно завершить!',
                                    text: 'Не написан диагноз.',
                                    type: 'error',
                                    padding: 30
                                });
                                return 0;
                            }
                            if (!$('#report_recommendation').val()) {
                                swal({
                                    position: 'top',
                                    title: 'Невозможно завершить!',
                                    text: 'Не написано рекомендация.',
                                    type: 'error',
                                    padding: 30
                                });
                                return 0;
                            }

                            swal({
                                position: 'top',
                                title: 'Внимание!',
                                text: 'Вы точно хотите завершить визит пациента?',
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Да'
                            }).then(function(ivi) {
                                if (ivi.value) {
                                    $('#btn_end_submit').click();
                                }
                            });
                        }
                    </script>
                <?php endif; ?>
                <?php if (level() == 12 or level() == 13): ?>
                    <input class="btn btn-outline-danger btn-sm" type="submit" value="Завершить" name="end"></input>
                <?php else: ?>
                    <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
                <?php endif; ?>
            </div>

        </form>
        <?php
    }

    public function form($pk = null)
    {
        global $db, $patient;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        ?>
        <form method="post" id="form_<?= __CLASS__ ?>" action="<?= add_url() ?>">

            <div class="modal-header bg-info">
                <h5 class="modal-title">Заключение</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="id" value="<?= $pk ?>">

                <h1>
                    <div class="col-md-8 offset-md-2">
                        <input type="text" style="font-size:1.3rem;" name="report_title" value="<?= ($post['report_title']) ? $post['report_title'] : $post['name'] ?>" class="form-control" placeholder="Названия отчета">
                    </div>
                </h1>

                <!-- The toolbar will be rendered in this container. -->
                <div id="toolbar-container"></div>

                <!-- This container will become the editable. -->
                <div id="editor">
                    <?php if ($post['report']): ?>
                        <?= $post['report'] ?>
                    <?php else: ?>
                        <br><span class="text-big"><strong>Рекомендация:</strong></span>
                    <?php endif; ?>
                </div>

                <textarea id="tickets-editor" class="form-control" style="display: none" placeholder="[[%ticket_content]]" name="report" rows="1"></textarea>

            </div>

            <div class="modal-footer">
                <?php if (level() == 10): ?>
                    <input style="display:none;" id="btn_end_submit" type="submit" value="Завершить" name="end" id="end"></input>
                    <button class="btn btn-outline-danger btn-sm" type="button" onclick="Verification()">Завершить</button>
                    <script type="text/javascript">
                        function Verification() {
                            event.preventDefault();


                            if ($('#editor').html() == `<p><br data-cke-filler="true"></p>`) {
                                swal({
                                    position: 'top',
                                    title: 'Невозможно завершить!',
                                    text: 'Не написан отчёт.',
                                    type: 'error',
                                    padding: 30
                                });
                                return 0;
                            }

                            swal({
                                position: 'top',
                                title: 'Внимание!',
                                text: 'Вы точно хотите завершить визит пациента?',
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Да'
                            }).then(function(ivi) {
                                if (ivi.value) {
                                    $('#btn_end_submit').click();
                                }
                            });
                        }
                    </script>
                <?php endif; ?>
                <?php if (level() == 12 or level() == 13): ?>
                    <input class="btn btn-outline-danger btn-sm" type="submit" value="Завершить" name="end" id="end"></input>
                <?php else: ?>
                    <button type="submit" class="btn btn-outline-info btn-sm" id="submit">Сохранить</button>
                <?php endif; ?>
            </div>

        </form>
        <script>
            DecoupledEditor
                .create( document.querySelector( '#editor' ) )
                .then( editor => {
                    const toolbarContainer = document.querySelector( '#toolbar-container' );

                    toolbarContainer.appendChild( editor.ui.view.toolbar.element );

                    editor.model.document.on( 'change:data', ( evt, data ) => {
                        console.log( data );
                        $('textarea#tickets-editor').html( editor.getData() );
                    } );
                } )
                .catch( error => {
                    console.error( error );
                } );

              document.getElementById( 'submit' ).onclick = () => {
                  textarea.value = editor.getData();
              }
              document.getElementById( 'end' ).onclick = () => {
                  textarea.value = editor.getData();
              }
        </script>
        <?php
    }

    public function form_finish($pk = null)
    {
        global $db, $patient;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        ?>
        <form method="post" id="form_<?= __CLASS__ ?>" action="<?= add_url() ?>">

            <div class="modal-header bg-info">
                <h5 class="modal-title">Заключение</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="id" value="<?= $pk ?>">
                <input type="hidden" name="report_title" value="<?= $post['name'] ?>">


                <!-- The toolbar will be rendered in this container. -->
                <div id="toolbar-container2"></div>

                <!-- This container will become the editable. -->
                <div id="editor2">
                    <?php if ($post['report']): ?>
                        <?= $post['report'] ?>
                    <?php else: ?>
                        <span class="text-big"><strong>Клинический диагноз:</strong></span><br>
                        <span class="text-big"><strong>Сопутствующие заболевания:</strong></span><br>
                        <span class="text-big"><strong>Жалобы:</strong></span><br>
                        <span class="text-big"><strong>Anamnesis morbi:</strong></span><br>
                        <span class="text-big"><strong>Объективно:</strong></span><br>
                        <span class="text-big"><strong>Рекомендация:</strong></span>
                    <?php endif; ?>
                </div>

                <textarea id="tickets-editor2" class="form-control" style="display: none" placeholder="[[%ticket_content]]" name="report" rows="1"></textarea>

            </div>

            <div class="modal-footer">
                <?php if (level() == 10): ?>
                    <!-- <a href="<?= up_url($_GET['user_id'], 'VisitFinish') ?>" onclick="return confirm('Вы точно хотите завершить визит пациента!')" class="btn btn-outline-danger">Завершить</a> -->
                    <input class="btn btn-outline-danger btn-sm" type="submit" value="Завершить" name="end"></input>
                <?php endif; ?>
                <button type="submit" class="btn btn-outline-info btn-sm" id="submit">Сохранить</button>
            </div>

        </form>
        <script>
            DecoupledEditor
                .create( document.querySelector( '#editor2' ) )
                .then( editor2 => {
                    const toolbarContainer2 = document.querySelector( '#toolbar-container2' );

                    toolbarContainer2.appendChild( editor2.ui.view.toolbar.element );

                    editor2.model.document.on( 'change:data', ( evt, data ) => {
                        console.log( data );
                        $('textarea#tickets-editor2').html( editor2.getData() );
                    } );
                } )
                .catch( error => {
                    console.error( error );
                } );

              document.getElementById( 'submit' ).onclick = () => {
                  textarea.value = editor2.getData();
              }
              document.getElementById( 'end' ).onclick = () => {
                  textarea.value = editor2.getData();
              }
        </script>
        <?php
    }

    public function get_or_404($pk)
    {
        global $db;
        $object = $db->query("SELECT vs.*, sc.name FROM $this->table vs LEFT JOIN service sc ON(sc.id=vs.service_id) WHERE vs.id = $pk")->fetch();
        if(division_assist() == 2){
            if ($object['parent_id'] = $object['assist_id'] or $object['parent_id'] == $_SESSION['session_id']) {
                if($object){
                    $this->set_post($object);
                    return $this->form($object['id']);
                }else{
                    Mixin\error('404');
                }
            }else {
                Mixin\error('404');
            }
        }else {
            if($object){
                $this->set_post($object);
                if ($object['service_id'] == 1) {
                    return $this->form_finish($object['id']);
                }else {
                    return $this->form($object['id']);
                }
            }else{
                Mixin\error('404');
            }
        }
    }

    public function update()
    {
        global $db;
        $end = ($this->post['end']) ? true : false;
        unset($this->post['end']);
        if($this->clean()){
            $pk = $this->post['id'];
            unset($this->post['id']);
            $object = Mixin\update($this->table, $this->post, $pk);
            if ($end) {
                $row = $db->query("SELECT * FROM visit WHERE id = {$pk}")->fetch();
                if ($row['assist_id']) {
                    if ($row['grant_id'] != $row['route_id']) {
                        Mixin\update('users', array('status' => null), $row['user_id']);
                    }
                }else {
                    if ($row['grant_id'] == $row['parent_id'] and 1 == $db->query("SELECT * FROM visit WHERE user_id={$row['user_id']} AND status != 5 AND completed IS NULL AND service_id != 1")->rowCount()) {
                        Mixin\update('users', array('status' => null), $row['user_id']);
                    }
                }
                $this->clear_post();
                $this->set_post(array(
                    'status' => ($row['direction']) ? 0 : null,
                    'completed' => date('Y-m-d H:i:s')
                ));
                $object = Mixin\update($this->table, $this->post, $pk);
                if (!intval($object)){
                    $this->error($object);
                }
            }else {
                if (!intval($object)){
                    $this->error($object);
                }
            }
        }
        $this->success();
    }

    public function clean()
    {
        if (empty($this->post['report'])) {
            unset($this->post['report']);
        }else {
            $report = $this->post['report'];
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        if ($report) {
            $this->post['report'] = $report;
        }
        return True;
    }

    public function success()
    {
        render();
    }

}

class VisitUpStatus extends Model
{
    public $table = 'visit';

    public function get_or_404($pk)
    {
        if(division_assist()){
            $this->post['assist_id'] = $_SESSION['session_id'];
        }
        if (permission([12, 13])) {
            $this->post['parent_id'] = $_SESSION['session_id'];
            if (in_array(level($_GET['route_id']), [2, 32])) {
                $this->post['grant_id'] = $_SESSION['session_id'];
            }
        }
        $this->post['id'] = $pk;
        $this->post['status'] = 2;
        $this->post['accept_date'] = date('Y-m-d H:i:s');
        $this->url = "card/content_1.php?id=".$_GET['user_id'];
        $this->update();
    }

    public function success()
    {
        render();
        // header("location:/$PROJECT_NAME/views/doctor/$this->url");
        // exit;
    }

}

class VisitRoute extends Model
{
    public $table = 'visit';

    public function form_out($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group">
                <label>Отделы</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <?php
                    foreach($db->query("SELECT * from division WHERE level in (5) AND id !=". division()) as $row) {
                        ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
                    <input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
                    <div class="form-control-feedback">
                        <i class="icon-search4 font-size-base text-muted"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="text-right">
                        <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <th>Отдел</th>
                                <th>Услуга</th>
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">

                        </tbody>
                    </table>
                </div>

            </div>

        </form>
        <script type="text/javascript">

            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1,2",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change(the) {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $(the).val(),
                        selected: service,
                        types: "1,2",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }

        </script>
        <?php
    }

    public function form_sta($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="1">
            <input type="hidden" name="status" value="1">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group">
                <label>Отделы</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <?php
                    foreach($db->query("SELECT * from division WHERE level in (5) AND id !=". division()) as $row) {
                        ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
                    <input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
                    <div class="form-control-feedback">
                        <i class="icon-search4 font-size-base text-muted"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="text-right">
                        <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <th>Отдел</th>
                                <th>Услуга</th>
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">

                        </tbody>
                    </table>
                </div>

            </div>

        </form>
        <script type="text/javascript">
            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1,2",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change(the) {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $(the).val(),
                        selected: service,
                        types: "1,2",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }
        </script>
        <?php
    }

    public function form_out_labaratory($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="laboratory" value="1">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
                    <input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
                    <div class="form-control-feedback">
                        <i class="icon-search4 font-size-base text-muted"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="text-right">
                        <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <!-- <th>Отдел</th> -->
                                <th>Услуга</th>
                                <!-- <th>Тип</th> -->
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">
                            <tr>
                                <td colspan="6" class="text-center" onclick="table_change()">услуги</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </form>
        <script type="text/javascript">

            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: [
                                "<?php
                                foreach($db->query("SELECT * from division WHERE level = 6 ") as $row) {
                                    echo $row['id'];
                                }
                                ?>"
                            ],
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 2
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change() {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: [
                                "<?php
                                foreach($db->query("SELECT * from division WHERE level = 6 ") as $row) {
                                    echo $row['id'];
                                }
                                ?>"
                            ],
                        selected: service,
                        types: "1",
                        cols: 2
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }

        </script>
        <?php
    }

    public function form_sta_labaratory($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="1">
            <input type="hidden" name="status" value="1">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">
            <input type="hidden" name="laboratory" value="1">

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
                    <input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
                    <div class="form-control-feedback">
                        <i class="icon-search4 font-size-base text-muted"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="text-right">
                        <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <!-- <th>Отдел</th> -->
                                <th>Услуга</th>
                                <!-- <th>Тип</th> -->
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">
                            <tr>
                                <td colspan="6" class="text-center" onclick="table_change()">услуги</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </form>
        <script type="text/javascript">
            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: [
                            "<?php
                            foreach($db->query("SELECT * from division WHERE level = 6 ") as $row) {
                                echo $row['id'];
                            }
                            ?>"
                        ],
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 2
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change() {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: [
                                "<?php
                                foreach($db->query("SELECT * from division WHERE level = 6 ") as $row) {
                                    echo $row['id'];
                                }
                                ?>"
                            ],
                        selected: service,
                        types: "1",
                        cols: 2
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }
        </script>
        <?php
    }

    public function form_out_diagnostic($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="diagnostic" value="1">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group">
                <label>Отделы</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <?php
                    foreach($db->query("SELECT * from division WHERE level = 10 AND (assist IS NULL OR assist = 1)") as $row) {
                        ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
                    <input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
                    <div class="form-control-feedback">
                        <i class="icon-search4 font-size-base text-muted"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="text-right">
                        <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <th>Отдел</th>
                                <th>Услуга</th>
                                <!-- <th>Тип</th> -->
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">

                        </tbody>
                    </table>
                </div>

            </div>

        </form>
        <script type="text/javascript">

            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change(the) {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $(the).val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }

        </script>
        <?php
    }

    public function form_sta_diagnostic($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="1">
            <input type="hidden" name="status" value="1">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="diagnostic" value="1">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group">
                <label>Отделы</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <?php
                    foreach($db->query("SELECT * from division WHERE level = 10 AND (assist IS NULL OR assist = 1)") as $row) {
                        ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
                    <input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
                    <div class="form-control-feedback">
                        <i class="icon-search4 font-size-base text-muted"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="text-right">
                        <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <th>Отдел</th>
                                <th>Услуга</th>
                                <!-- <th>Тип</th> -->
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">

                        </tbody>
                    </table>
                </div>

            </div>

        </form>
        <script type="text/javascript">
            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change(the) {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $(the).val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }
        </script>
        <?php
    }

    public function form_out_physio_manipulation($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="physio_manipulation" value="1">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group">
                <label>Отделы</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <?php
                    foreach($db->query("SELECT * from division WHERE level IN (12, 13)") as $row) {
                        ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
                    <input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
                    <div class="form-control-feedback">
                        <i class="icon-search4 font-size-base text-muted"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="text-right">
                        <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <th>Отдел</th>
                                <th>Услуга</th>
                                <!-- <th>Тип</th> -->
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">

                        </tbody>
                    </table>
                </div>

            </div>

        </form>
        <script type="text/javascript">

            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change(the) {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $(the).val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }

        </script>
        <?php
    }

    public function form_sta_physio_manipulation($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="1">
            <input type="hidden" name="status" value="1">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="physio_manipulation" value="1">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group">
                <label>Отделы</label>
                <select data-placeholder="Выбрать отдел" multiple="multiple" id="division_selector" class="form-control select" onchange="table_change(this)" data-fouc>
                    <?php
                    foreach($db->query("SELECT * from division WHERE level IN (12, 13)") as $row) {
                        ?>
                        <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
                    <input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
                    <div class="form-control-feedback">
                        <i class="icon-search4 font-size-base text-muted"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="text-right">
                        <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <th>Отдел</th>
                                <th>Услуга</th>
                                <!-- <th>Тип</th> -->
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">

                        </tbody>
                    </table>
                </div>

            </div>

        </form>
        <script type="text/javascript">
            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: $("#division_selector").val(),
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change(the) {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: $(the).val(),
                        selected: service,
                        types: "1",
                        cols: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }
        </script>
        <?php
    }

    public function form_sta_doc($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="1">
            <input type="hidden" name="status" value="2">
            <input type="hidden" name="accept_date" value="1">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">
            <input type="hidden" name="division_grant" value="<?= division() ?>">

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
                    <input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
                    <div class="form-control-feedback">
                        <i class="icon-search4 font-size-base text-muted"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="text-right">
                        <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <th>Услуга</th>
                                <th style="width: 100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">
                            <tr>
                                <td colspan="4" class="text-center" onclick="table_change()">услуги</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </form>
        <script type="text/javascript">
            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: ["<?= division() ?>"],
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 3,
                        head: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change() {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: ["<?= division() ?>"],
                        selected: service,
                        types: "1",
                        cols: 3,
                        head: 1
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }
        </script>
        <?php
    }

    public function clean()
    {
        if (is_array($this->post['service'])) {
            $this->save_rows();
        }
        if ($this->post['accept_date']) {
            $this->post['accept_date'] = date('Y-m-d H:i:s');
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function save()
    {
        global $db;
        if($this->clean()){
            $object = Mixin\insert($this->table, $this->post);
            if (!intval($object)){
                $this->error($object);
            }
            $service = $db->query("SELECT price, name FROM service WHERE id = {$this->post['service_id']}")->fetch();
            $post['visit_id'] = $object;
            $post['user_id'] = $this->post['user_id'];
            $post['item_type'] = 1;
            $post['item_id'] = $this->post['service_id'];
            $post['item_cost'] = $service['price'];
            $post['item_name'] = $service['name'];
            $object = Mixin\insert('visit_price', $post);
            if (intval($object)){
                $this->error($object);
            }
            $this->success();
        }
    }

    public function save_rows()
    {
        global $db;
        if ($this->post['accept_date'] and $this->post['division_grant']) {
            $post_big['accept_date'] = date('Y-m-d H:i:s');
            $post_big['division_id'] = $this->post['division_grant'];
            $post_big['parent_id'] = $this->post['parent_id'];
        }
        foreach ($this->post['service'] as $key => $value) {

            $post_big['direction'] = $this->post['direction'];
            $post_big['status'] = $this->post['status'];
            $post_big['grant_id'] = $this->post['grant_id'];
            $post_big['route_id'] = $this->post['route_id'];
            $post_big['user_id'] = $this->post['user_id'];
            $post_big['service_id'] = $value;
            if (!$this->post['division_grant']) {
                $post_big['parent_id'] = $this->post['parent_id'][$key];
                $post_big['division_id'] = $this->post['division_id'][$key];
            }
            if ($this->post['diagnostic']) {
                $post_big['diagnostic'] = $this->post['diagnostic'];
            }
            if ($this->post['laboratory']) {
                $post_big['laboratory'] = $this->post['laboratory'];
            }
            if ($this->post['physio_manipulation']) {
                $level_divis = $db->query("SELECT level FROM division WHERE id = {$post_big['division_id']}")->fetchColumn();
                if ($level_divis == 12) {
                    $post_big['physio'] = 1;
                } elseif ($level_divis == 13) {
                    $post_big['manipulation'] = 1;
                }
            }
            for ($i=0; $i < $this->post['count'][$key]; $i++) {
                $post_big = Mixin\clean_form($post_big);
                $post_big = Mixin\to_null($post_big);
                $object = Mixin\insert($this->table, $post_big);
                if (!intval($object)){
                    $this->error($object);
                }

                $service = $db->query("SELECT price, name FROM service WHERE id = {$post_big['service_id']}")->fetch();
                $post['visit_id'] = $object;
                $post['user_id'] = $this->post['user_id'];
                $post['item_type'] = 1;
                $post['item_id'] = $post_big['service_id'];
                $post['item_cost'] = $service['price'];
                $post['item_name'] = $service['name'];
                $object = Mixin\insert('visit_price', $post);
                if (!intval($object)){
                    $this->error($object);
                }
            }
        }
        $this->success();
    }

    public function success()
    {
        $_SESSION['message'] = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render();
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
			<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
			<span class="font-weight-semibold"> '.$message.'</span>
	    </div>
        ';
        render();
    }
}

class VisitFinish extends Model
{
    public $table = 'visit';
    public $table1 = 'users';
    public $table2 = 'beds';

    public function get_or_404($pk)
    {
        global $db;
        $this->post['completed'] = date('Y-m-d H:i:s');
        $db->beginTransaction();
        foreach($db->query("SELECT * FROM visit WHERE user_id=$pk AND parent_id= {$_SESSION['session_id']} AND accept_date IS NOT NULL AND completed IS NULL AND (service_id = 1 OR (report_title IS NOT NULL AND report IS NOT NULL))") as $inf){
            $this->status_controller($pk, $inf);
            $this->update();
        }
        $db->commit();
        $this->success();
    }

    public function status_controller($pk, $inf)
    {
        global $db;
        $this->post['status'] = ($inf['direction']) ? 0 : null;
        if ($inf['grant_id'] == $inf['parent_id'] and ($inf['direction'] or 1 == $db->query("SELECT * FROM visit WHERE user_id=$pk AND status != 5 AND completed IS NULL AND service_id != 1")->rowCount())) {
            if (!$inf['direction']) {
                Mixin\update($this->table1, array('status' => null), $pk);
            }
            if ($inf['direction']) {
                $pk_arr = array('user_id' => $pk);
                $object = Mixin\update($this->table2, array('user_id' => null), $pk_arr);
            }
        }
        if ($inf['assist_id']) {
            if (!$inf['direction']) {
                $this->post['grant_id'] = $_SESSION['session_id'];
                Mixin\update($this->table1, array('status' => null), $pk);
            }
        }
        $this->post['id'] = $inf['id'];
    }

    public function update()
    {
        $pk = $this->post['id'];
        unset($this->post['id']);
        $object = Mixin\update($this->table, $this->post, $pk);
        if ($object != 1){
            $this->error($object);
        }
    }

    public function success()
    {
        render("doctor/index");
    }

}

class LaboratoryUpStatus extends Model
{
    public $table = 'visit';
    public $table2 = 'laboratory_analyze';

    public function get_or_404($pk)
    {
        global $db;

        foreach ($db->query("SELECT id FROM visit WHERE user_id = $pk AND laboratory IS NOT NULL AND accept_date IS NULL AND completed IS NULL") as $value) {
            $this->post['id'] = $value['id'];
            $this->post['status'] = 2;
            $this->post['accept_date'] = date('Y-m-d H:i:s');
            $this->update();
        }
        $this->success();
    }

    public function update()
    {
        if($this->clean()){
            $pk = $this->post['id'];
            unset($this->post['id']);
            $object = Mixin\update($this->table, $this->post, $pk);
            if (!intval($object)){
                $this->error($object);
            }

        }
    }

    public function success()
    {
        render();
    }

}

class VisitFailure extends Model
{
    public $table = 'visit';

    public function form($pk = null)
    {
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="modal-body">
                <div class="form-group row">

                    <input type="hidden" id="vis_id" name="id" value="">
                    <input type="hidden" name="status" value="5">

                    <div class="col-md-12">
                        <label>Причина:</label>
                        <textarea rows="4" cols="4" name="failure" class="form-control" placeholder="Введите причину ..." required></textarea>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button id="renouncement" onclick="deletPatient(this);" data-userid="" data-parentid="" type="submit" id="button_<?= __CLASS__ ?>" class="btn btn-outline-danger btn-sm">Отказаться</button>
            </div>

        </form>

        <script type="text/javascript">

            $('#<?= __CLASS__ ?>_form').submit(function (events) {
                events.preventDefault();
                $.ajax({
                    type: $(this).attr("method"),
                    url: $(this).attr("action"),
                    data: $(this).serializeArray(),
                    success: function (result) {
                        $('#modal_failure').modal('hide');
                        $(result.replace("1#", "#")).css("background-color", "rgb(244, 67, 54)");
                        $(result.replace("1#", "#")).css("color", "white");
                        $(result.replace("1#", "#")).fadeOut(900, function() {
                            $(this).remove();
                        });
                    },
                });
            });
        </script>
        <?php
    }

    public function update()
    {
        if($this->clean()){
            $pk = $this->post['id'];
            unset($this->post['id']);
            $object = Mixin\update($this->table, $this->post, $pk);
            if (!intval($object)){
                $this->error($object);
            }
            $this->success($pk);
        }
    }

    public function clean()
    {
        global $db;
        $visit = $db->query("SELECT direction FROM visit WHERE id = {$this->post['id']}")->fetch();
        if ($visit['direction']) {
            $form = new VisitModel;
            $form->delete($this->post['id']);
            $this->success($this->post['id']);
        }else {
            $this->post = Mixin\clean_form($this->post);
            $this->post = Mixin\to_null($this->post);
            return True;
        }

    }

    public function success($pk)
    {
        echo "#PatientFailure_tr_$pk";
    }

}

class BypassDateModel extends Model
{
    public $table = 'bypass_date';

    public function table_form_doc($pk = null)
    {
        global $db, $methods, $grant;
        $this_date = new \DateTime();
        $bypass = $db->query("SELECT user_id, add_date FROM bypass WHERE id = {$_GET['pk']}")->fetch();
        $add_date = date('Y-m-d', strtotime($bypass['add_date']));
        $first_date = date_diff(new \DateTime(), new \DateTime($add_date))->days;
        $col = $db->query("SELECT id, time FROM bypass_time WHERE bypass_id = {$_GET['pk']} ORDER BY time ASC")->fetchAll();
        $span = count($col);
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="text-right">
                <button onclick="AddTrDate()" type="button" class="btn btn-outline-success btn-sm" style="margin-bottom:20px"><i class="icon-plus22 mr-2"></i>Добавить день</button>
            </div>

            <div class="table-responsive">
                <table class="table table-xs table-bordered">
                    <thead>
                        <tr class="bg-info">
                            <th style="width: 50px">№</th>
                            <th style="width: 50%">Дата</th>
                            <th style="width: 30%">Время</th>
                            <th colspan="2" class="text-center">Коструктор</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $day_show = 5;
                        $max_day_show = 30;
                        $s = 0;
                        for ($i=-$first_date; $i < $max_day_show; $i++) {
                            $s++;
                            $row_stat = True;
                            foreach ($col as $value) {
                                ?>
                                <tr <?= ($s>$day_show) ? 'class="table_date_hidden" style="display:none;"' : 'class="table_date"' ?>>
                                    <?php if ($row_stat): ?>
                                        <td rowspan="<?= $span ?>"><?= $s ?></td>
                                        <td rowspan="<?= $span ?>">
                                            <?php
                                            $date = new \DateTime();
                                            $date->modify("+$i day");
                                            echo $date->format('d.m.Y');
                                            ?>
                                        </td>
                                    <?php endif; ?>
                                    <?php
                                    $dat = $date->format('Y-m-d');
                                    $post = $db->query("SELECT * FROM bypass_date WHERE bypass_id = {$_GET['pk']} AND time = '{$value['time']}' AND date = '$dat'")->fetch();
                                    ?>
                                    <td>
                                        <?= $time = date('H:i', strtotime($value['time'])) ?>
                                    </td>
                                    <td>
                                        <?php if ($dat." ".$time < $this_date->format('Y-m-d H:i')): ?>
                                            <?php if ($post['status']): ?>
                                                <i style="font-size:1.5rem;" class="icon-checkmark-circle"></i>
                                            <?php else: ?>
                                                <i style="font-size:1.5rem;" class="icon-circle"></i>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php if ($post['completed']): ?>
                                                <i style="font-size:1.5rem;" class="icon-checkmark-circle"></i>
                                            <?php else: ?>
                                                <?php if ($grant): ?>
                                                    <?php if ($post['status']): ?>
                                                        <i style="font-size:1.5rem;" class="text-success icon-checkmark-circle" onclick="SwetDate(this)" data-id="<?= $post['id'] ?>" data-date="<?= $date->format('Y-m-d') ?>" data-time="<?= $value['time'] ?>" data-val=""></i>
                                                    <?php else: ?>
                                                        <i style="font-size:1.5rem;" class="text-success icon-circle" onclick="SwetDate(this)" data-id="<?= $post['id'] ?>" data-date="<?= $date->format('Y-m-d') ?>" data-time="<?= $value['time'] ?>" data-val="1"></i>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <?php if ($post['status']): ?>
                                                        <i style="font-size:1.5rem;" class="icon-checkmark-circle"></i>
                                                    <?php else: ?>
                                                        <i style="font-size:1.5rem;" class="icon-circle"></i>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($post['completed']): ?>
                                            <i style="font-size:1.5rem;" class="icon-checkmark-circle tolltip" data-head="<?= get_full_name($post['parent_id']) ?>" data-content="<?= $post['comment'] ?>"></i>
                                        <?php else: ?>
                                            <i style="font-size:1.5rem;" class="icon-circle"></i>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php
                                $row_stat= False;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </form>
        <script type="text/javascript">
            $(".tolltip").on('mouseenter', function() {
                $(this).popover({
                    title: event.target.dataset.head,
                    content: event.target.dataset.content,
                    placement: 'top'
                })
                $(this).popover('show');
            }).on('mouseleave', function() {
                $(this).popover('hide');
            });

            function AddTrDate() {
                for (var i = 0; i < Number("<?= $span ?>"); i++) {
                    var tr = $('.table_date_hidden').first();
                    tr.removeClass("table_date_hidden");
                    tr.addClass("table_date");
                    tr.fadeIn();
                }
            }

            function SwetDate(swet_input) {
                var form = $('#<?= __CLASS__ ?>_form');
                var products = [], i = 0;
                document.querySelectorAll('.products').forEach(function(events) {
                    products[i] = $(events).val();
                    i++;
                });

                if (swet_input.dataset.id) {
                    var data = {
                        model: "<?= __CLASS__ ?>",
                        bypass_id: "<?= $_GET['pk'] ?>",
                        id: swet_input.dataset.id,
                        user_id: "<?= $bypass['user_id'] ?>",
                        time: swet_input.dataset.time,
                        date: swet_input.dataset.date,
                        status: swet_input.dataset.val,
                        products: products
                    };
                }else {
                    var data = {
                        model: "<?= __CLASS__ ?>",
                        bypass_id: "<?= $_GET['pk'] ?>",
                        user_id: "<?= $bypass['user_id'] ?>",
                        time: swet_input.dataset.time,
                        date: swet_input.dataset.date,
                        status: swet_input.dataset.val,
                        products: products
                    };
                }
                $.ajax({
                    type: form.attr("method"),
                    url: form.attr("action"),
                    data: data,
                    success: function (result) {
                        if (!Number(result) && result != "success") {
                            new Noty({
                                text: result,
                            type: 'error'
                            }).show();
                        }else if(Number(result)){
                            swet_input.dataset.id = result;
                            if (swet_input.dataset.val == 1) {
                                $(swet_input).removeClass('icon-circle');
                                $(swet_input).addClass('icon-checkmark-circle');
                                swet_input.dataset.val = "";
                            }else if(swet_input.dataset.val == ""){
                                $(swet_input).removeClass('icon-checkmark-circle');
                                $(swet_input).addClass('icon-circle');
                                swet_input.dataset.val = 1;
                            }
                        }else {
                            if (swet_input.dataset.val == 1) {
                                $(swet_input).removeClass('icon-circle');
                                $(swet_input).addClass('icon-checkmark-circle');
                                swet_input.dataset.val = "";
                            }else if(swet_input.dataset.val == ""){
                                $(swet_input).removeClass('icon-checkmark-circle');
                                $(swet_input).addClass('icon-circle');
                                swet_input.dataset.val = 1;
                            }
                        }
                    },
                });
            }
        </script>
        <?php
    }

    public function table_form_nurce($pk = null)
    {
        global $db, $methods;
        $this_date = new \DateTime();
        $bypass = $db->query("SELECT user_id, visit_id, add_date FROM bypass WHERE id = {$_GET['pk']}")->fetch();
        $add_date = date('Y-m-d', strtotime($bypass['add_date']));
        $first_date = date_diff(new \DateTime(), new \DateTime($add_date))->days;
        $col = $db->query("SELECT id, time FROM bypass_time WHERE bypass_id = {$_GET['pk']} ORDER BY time ASC")->fetchAll();
        $span = count($col);
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="table-responsive">
                <table class="table table-xs table-bordered">
                    <thead>
                        <tr class="bg-info">
                            <th style="width: 50px">№</th>
                            <th style="width: 50%">Дата</th>
                            <th style="width: 30%">Время</th>
                            <th colspan="2" class="text-center">Коструктор</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $day_show = 5;
                        $max_day_show = 30;
                        $s = 0;
                        $tr = 0;
                        for ($i=-2; $i < $max_day_show; $i++) {
                            $s++;
                            $row_stat = True;
                            foreach ($col as $value) {
                                $tr++;
                                ?>
                                <tr <?= ($s>$day_show) ? 'class="table_date_hidden" style="display:none;"' : 'class="table_date"' ?>>
                                    <?php if ($row_stat): ?>
                                        <td rowspan="<?= $span ?>"><?= $s ?></td>
                                        <td rowspan="<?= $span ?>">
                                            <?php
                                            $date = new \DateTime();
                                            $date->modify("+$i day");
                                            echo $date->format('d.m.Y');
                                            ?>
                                        </td>
                                    <?php endif; ?>
                                    <?php
                                    $dat = $date->format('Y-m-d');
                                    $post = $db->query("SELECT * FROM bypass_date WHERE bypass_id = {$_GET['pk']} AND time = '{$value['time']}' AND date = '$dat'")->fetch();
                                    ?>
                                    <td>
                                        <?= date('H:i', strtotime($value['time'])) ?>
                                    </td>
                                    <td class="text-dar text-center">
                                        <?php if ($post['status']): ?>
                                            <i style="font-size:1.5rem;" class="icon-checkmark-circle"></i>
                                        <?php else: ?>
                                            <i style="font-size:1.5rem;" class="icon-circle"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td id="tr_<?= $tr ?>">
                                        <?php if ($dat < $this_date->format('Y-m-d')): ?>
                                            <?php if ($post['completed']): ?>
                                                <i style="font-size:1.5rem;" class="text-dark icon-checkmark-circle tolltip" data-head="<?= get_full_name($post['parent_id']) ?>" data-content="<?= $post['comment'] ?>"></i>
                                            <?php elseif($post['status'] and $dat == $this_date->format('Y-m-d')): ?>
                                                <i style="font-size:1.5rem;" class="text-dark icon-circle"></i>
                                            <?php else: ?>
                                                <i style="font-size:1.5rem;" class="text-dark icon-circle"></i>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php if ($post['completed']): ?>
                                                <i style="font-size:1.5rem;" class="text-success icon-checkmark-circle tolltip" data-head="<?= get_full_name($post['parent_id']) ?>" data-content="<?= $post['comment'] ?>"></i>
                                            <?php elseif($post['status'] and $dat == $this_date->format('Y-m-d')): ?>
                                                <i style="font-size:1.5rem;" class="text-success icon-circle" onclick="SwetDate('#tr_<?= $tr ?>')" data-id="<?= $post['id'] ?>" data-value="1"></i>
                                            <?php else: ?>
                                                <i style="font-size:1.5rem;" class="text-dark icon-circle"></i>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php
                                $row_stat= False;
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </form>
        <script type="text/javascript">
            $(".tolltip").on('mouseenter', function() {
                $(this).popover({
                    title: event.target.dataset.head,
                    content: event.target.dataset.content,
                    placement: 'top'
                })
                $(this).popover('show');
            }).on('mouseleave', function() {
                $(this).popover('hide');
            });

            function SwetDate(tr) {
                var form = $('#<?= __CLASS__ ?>_form');
                var products = [], i = 0;
                document.querySelectorAll('.products').forEach(function(events) {
                    products[i] = $(events).val();
                    i++;
                });
                if (comment = prompt('Примечание', '')) {
                    var data = {
                        model: "<?= __CLASS__ ?>",
                        bypass_id: "<?= $_GET['pk'] ?>",
                        visit_id: "<?= $bypass['visit_id'] ?>",
                        id: event.target.dataset.id,
                        completed: event.target.dataset.value,
                        user_id: "<?= $bypass['user_id'] ?>",
                        parent_id: "<?= $_SESSION['session_id'] ?>",
                        comment: comment,
                        products: products
                    }
                }else {
                    var data = {
                        model: "<?= __CLASS__ ?>",
                        bypass_id: "<?= $_GET['pk'] ?>",
                        visit_id: "<?= $bypass['visit_id'] ?>",
                        id: event.target.dataset.id,
                        completed: event.target.dataset.value,
                        user_id: "<?= $bypass['user_id'] ?>",
                        parent_id: "<?= $_SESSION['session_id'] ?>",
                        products: products
                    }
                }

                $.ajax({
                    type: form.attr("method"),
                    url: form.attr("action"),
                    data: data,
                    success: function (result) {
                        if (!Number(result)) {
                            if (result != "success") {
                                new Noty({
                                    text: result,
                                type: 'error'
                                }).show();
                            }else {
                                $(tr).html('<i style="font-size:1.5rem;" class="text-success icon-checkmark-circle"></i>');
                            }
                        }
                    },
                });

            }
        </script>
        <?php
    }

    public function clean()
    {
        global $db, $patient;
        if ($this->post['products']) {
            $user_pk = $this->post['user_id'];
            if ($this->post['completed']) {
                // Медсестра
                $db->beginTransaction();
                foreach ($this->post['products'] as $value){
                    $qty = $db->query("SELECT qty FROM bypass_preparat WHERE bypass_id = {$this->post['bypass_id']} AND preparat_id = $value")->fetchColumn();
                    $post = $db->query("SELECT id, preparat_id 'item_id', price 'item_cost', name 'item_name', qty, qty_sold, category 'item_type' FROM storage_home WHERE preparat_id = $value")->fetch();
                    if(!$post){
                        $this->error("Не осталось препарата ".$value);
                        $this->stop();
                    }
                    $post['visit_id'] = $this->post['visit_id'];
                    $post['user_id'] = $user_pk;
                    if ($post['qty'] <= $qty) {
                        $object = Mixin\delete('storage_home', $post['id']);
                    }else {
                        $object = Mixin\update('storage_home', array('qty' => $post['qty']-$qty, 'qty_sold' => $post['qty_sold']+$qty), $post['id']);
                    }
                    if (!intval($object)) {
                        $this->error('storage_preparat'.$object);
                    }
                    unset($post['qty_sold']);
                    unset($post['qty']);
                    unset($post['id']);
                    for ($i=0; $i < $qty; $i++) {
                        $object1 = Mixin\insert('visit_price', $post);
                        if (!intval($object1)) {
                            $this->error('visit_price'.$object1);
                            $this->stop();
                        }
                    }
                }
                $db->commit();
            }else {
                // Доктор
                if ($this->post['status']) {

                    $db->beginTransaction();
                    foreach ($this->post['products'] as $value){
                        $qty = $db->query("SELECT qty FROM bypass_preparat WHERE bypass_id = {$this->post['bypass_id']} AND preparat_id = $value")->fetchColumn();
                        $store = $db->query("SELECT qty FROM storage WHERE id = $value")->fetchColumn();
                        $orders = $db->query("SELECT SUM(qty) FROM storage_orders WHERE preparat_id =$value")->fetchColumn();
                        if(!$store or ($store-$orders) < $qty){
                            $this->error("Не осталось препарата ".$store);
                            $this->stop();
                        }
                        $post = $db->query("SELECT * FROM storage_orders WHERE user_id = {$this->post['user_id']} AND parent_id = {$_SESSION['session_id']} AND preparat_id = $value AND date = '".$this->post['date']."'")->fetch();
                        if ($post) {
                            $post_pk = $post['id'];
                            unset($post['id']);
                            $post['qty'] += $qty;
                            $post['date'] = $this->post['date'];
                            $object = Mixin\update('storage_orders', $post, $post_pk);
                        }else {
                            $post = array(
                                'user_id' => $this->post['user_id'],
                                'parent_id' => $_SESSION['session_id'],
                                'preparat_id' => $value,
                                'qty' => $qty,
                                'date' => $this->post['date']
                            );
                            $object = Mixin\insert('storage_orders', $post);
                        }
                        if (!intval($object)) {
                            $this->error('storage_orders: '.$object);
                        }
                    }
                    $db->commit();

                } else {

                    $db->beginTransaction();
                    foreach ($this->post['products'] as $value){
                        $qty = $db->query("SELECT qty FROM bypass_preparat WHERE bypass_id = {$this->post['bypass_id']} AND preparat_id = $value")->fetchColumn();
                        $post = $db->query("SELECT * FROM storage_orders WHERE user_id = {$this->post['user_id']} AND parent_id = {$_SESSION['session_id']} AND preparat_id = $value AND date = '".$this->post['date']."'")->fetch();
                        if ($post['qty'] > $qty) {
                            $post_pk = $post['id'];
                            unset($post['id']);
                            $post['qty'] -= $qty;
                            $object = Mixin\update('storage_orders', $post, $post_pk);
                        }else {
                            $object = Mixin\delete('storage_orders', $post['id']);
                        }
                    }
                    $db->commit();

                }
            }
            unset($this->post['user_id']);
            unset($this->post['products']);
            if ($this->post['visit_id']) {
                unset($this->post['visit_id']);
            }
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function save()
    {
        if($this->clean()){
            $object = Mixin\insert($this->table, $this->post);
            if (intval($object)){
                $this->success($object);
            }else{
                $this->error($object);
            }
        }
    }

    public function success($message=null)
    {
        if ($message) {
            echo $message;
        }else {
            echo "success";
        }
    }

    public function error($message)
    {
        echo $message;
    }
}

class NotesModel extends Model
{

     public $table = "notes";

     public function form($pk=null)
     {
        global $patient;
         ?>

         <form method="POST" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-4">
                        <label>Выберите дату:</label>
                        <input type="date" class="form-control" name="date_text">
                    </div>
                    <div class="col-md-4">
                        <label>Выберите время:</label>
                        <input type="time" class="form-control" name="time_text">
                    </div>
                    <div class="col-md-4">
                        <label>Введите описание:</label>
                        <input type="text" class="form-control" name="description">
                    </div>
                </div>

            </div>

             <div class="modal-footer">

                <div class="text-right" style="margin-top: 1%;">
                    <button type="submit" class="btn btn-outline-info btn-sm legitRipple">Сохранить</button>
                </div>

            </div>

         </form>
         <?php
     }

     public function success()
     {
        $_SESSION['message'] = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';

        render();
     }

     public function error($message)
     {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> '.$message.'</span>
        </div>
        ';

        render();
     }
 }

class Storage extends Model
{
    public $table = 'storage';
    public $table_label = array(
        'id' => 'id',
        'code' => 'Код',
        'name' => 'Препарат',
        'supplier' => 'Поставщик',
        'category' => 'Категория(2,3,4)',
        'qty' => 'Кол-во',
        'qty_limit' => 'Лимит',
        'cost' => 'Цена прихода',
        'price' => 'Цена расхода',
        'faktura' => 'Счёт фактура',
        'add_date' => 'Дата поставки',
        'die_date' => 'Срок годности',
    );

    public function form_template($pk = null)
    {
        ?>
        <form method="post" action="<?= add_url() ?>" enctype="multipart/form-data">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="form-group">
                <label>Шаблон:</label>
                <input type="file" class="form-control" name="template" accept="application/vnd.ms-excel" required>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-primary">Сохранить</button>
            </div>

        </form>
        <?php
    }

    public function form($pk = null)
    {
        global $CATEGORY;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        if($_SESSION['message']){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="form-group">
               <label>Препарат:</label>
               <input type="text" class="form-control" name="name" placeholder="Введите название препарата" required value="<?= $post['name'] ?>">
            </div>

            <div class="form-group row">

                <div class="col-md-3">
                    <label>Код:</label>
                    <input type="text" class="form-control" name="code" placeholder="Введите код" required value="<?= $post['code'] ?>">
                </div>

                <div class="col-md-9">
                    <label>Поставщик:</label>
                    <input type="text" class="form-control" name="supplier" placeholder="Введите поставщик" required value="<?= $post['supplier'] ?>">
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-4">
                    <label>Кол-во:</label>
                    <input type="text" class="form-control" name="qty" placeholder="Введите колличество" required value="<?= $post['qty'] ?>">
                </div>

                <div class="col-md-4">
                    <label>Цена прихода:</label>
                    <input type="text" class="form-control" name="cost" placeholder="Введите цену" required value="<?= $post['cost'] ?>">
                </div>

                <div class="col-md-4">
                    <label>Цена расхода:</label>
                    <input type="text" class="form-control" name="price" placeholder="Введите цену" required value="<?= $post['price'] ?>">
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-3">
                    <label>Категория:</label>
                    <select data-placeholder="Выбрать этаж" name="category" class="form-control form-control-select2" required>
                        <option></option>
                        <?php
                        foreach ($CATEGORY as $key => $value) {
                            ?>
                            <option value="<?= $key ?>" <?= ($post['category'] == $key) ? 'selected': '' ?>><?= $value ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Дата прихода:</label>
                    <input type="date" class="form-control" name="add_date" placeholder="Введите дату" required value="<?= $post['add_date'] ?>">
                </div>

                <div class="col-md-3">
                    <label>Срок годности:</label>
                    <input type="date" class="form-control" name="die_date" placeholder="Введите дату" required value="<?= $post['die_date'] ?>">
                </div>

            </div>

            <div class="form-group">
               <label>Счёт фактура:</label>
               <input type="text" class="form-control" name="faktura" placeholder="Введите счёт" required value="<?= $post['faktura'] ?>">
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-success btn-sm">Добавить</button>
            </div>

        </form>
        <?php
    }

    public function clean()
    {
        if($_FILES['template']){
            // prit('temlate');
            $this->post['template'] = read_excel($_FILES['template']['tmp_name']);
            $this->save_excel();
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function clean_excel()
    {
        if ($this->table_label) {
            foreach ($this->table_label as $key => $value) {
                $post[$key] = $this->post[$value];
            }
            $this->post = $post;
        }
        $this->post['parent_id'] = $_SESSION['session_id'];
        $this->post['cost'] = preg_replace("/,+/", "", $this->post['cost']);
        $this->post['price'] = preg_replace("/,+/", "", $this->post['price']);
        return True;
    }

    public function save_excel()
    {
        global $db;
        $db->beginTransaction();
        foreach ($this->post['template'] as $key_p => $value_p) {
            if ($key_p) {
                foreach ($value_p as $key => $value) {
                    $pick = $pirst[$key];
                    $this->post[$pick] = $value;
                }
                if($this->clean_excel()){
                    $object = Mixin\insert_or_update($this->table, $this->post);
                    if (!intval($object)){
                        $this->error($object);
                        $db->rollBack();
                    }
                }
            }else {
                $pirst = $value_p;
                unset($this->post['template']);
            }
        }
        $db->commit();
        $this->success();
    }

    public function success()
    {
        $_SESSION['message'] = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render();
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> '.$message.'</span>
        </div>
        ';
        render();
    }
}

class StorageHomeForm extends Model
{
    public $table = 'storage_home';

    public function form($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="modal-body">
                <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
                <input type="hidden" name="user_id" value="<?= $patient->id ?>">

                <div class="form-group row">

                    <div class="col-md-10">
                        <label>Расходные материалы:</label>
                        <select data-placeholder="Выберите материал" name="product" class="form-control select-price" required data-fouc>
                            <option></option>
                            <?php foreach ($db->query("SELECT * FROM storage_home WHERE status = 7") as $row): ?>
                                <option value="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>"><?= $row['name'] ?> | <?= $row['supplier'] ?> (годен до <?= date("d.m.Y", strtotime($row['die_date'])) ?>) в наличии - <?= $row['qty'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group row">
                            <label>Количество:</label>
                            <input type="number" name="qty" value="1" class="form-control">
                        </div>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <?php
    }

    public function clean()
    {
        global $db;
        $order = $db->query("SELECT * FROM $this->table WHERE id={$this->post['product']}")->fetch();
        $post['visit_id'] = $this->post['visit_id'];
        $post['user_id'] = $this->post['user_id'];
        $post['item_id'] = $order['preparat_id'];
        $post['item_type'] = 3;
        $post['item_cost'] = $order['price'];
        $post['item_name'] = $order['name'];
        if ($order['qty'] > $this->post['qty']) {
            $object = Mixin\update($this->table, array('qty' => $order['qty']-$this->post['qty'], 'qty_sold' => $order['qty_sold']+$this->post['qty']), $this->post['product']);
        }elseif ($order['qty'] == $this->post['qty']) {
            $object = Mixin\delete($this->table, $this->post['product']);
        }else {
            $this->error('Нехватает препарата на складе');
        }
        if (!intval($object)) {
            $this->error('storage_preparat: '.$object);
        }
        for ($i=0; $i < $this->post['qty']; $i++) {
            $object = Mixin\insert('visit_price', $post);
            if (!intval($object)) {
                $this->error('visit_price: '.$object);
            }
        }
        $this->success();
    }

    public function success()
    {
        $_SESSION['message'] = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render();
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> '.$message.'</span>
        </div>
        ';
        render();
    }

}

class StorageHomeAnestForm extends Model
{
    public $table = 'storage_home';

    public function form($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="modal-body">
                <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
                <input type="hidden" name="user_id" value="<?= $patient->id ?>">

                <div class="form-group row">

                    <div class="col-md-10">
                        <label>Расходные материалы:</label>
                        <select data-placeholder="Выберите материал" name="product" class="form-control select-price" required data-fouc>
                            <option></option>
                            <?php foreach ($db->query("SELECT * FROM storage_home WHERE status = 11") as $row): ?>
                                <option value="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>"><?= $row['name'] ?> | <?= $row['supplier'] ?> (годен до <?= date("d.m.Y", strtotime($row['die_date'])) ?>) в наличии - <?= $row['qty'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group row">
                            <label>Количество:</label>
                            <input type="number" name="qty" value="1" class="form-control">
                        </div>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <?php
    }

    public function clean()
    {
        global $db;
        $order = $db->query("SELECT * FROM $this->table WHERE id={$this->post['product']}")->fetch();
        $post['visit_id'] = $this->post['visit_id'];
        $post['user_id'] = $this->post['user_id'];
        $post['item_id'] = $order['preparat_id'];
        $post['item_type'] = $order['category'];
        $post['item_cost'] = $order['price'];
        $post['item_name'] = $order['name'];
        if ($order['qty'] > $this->post['qty']) {
            $object = Mixin\update($this->table, array('qty' => $order['qty']-$this->post['qty'], 'qty_sold' => $order['qty_sold']+$this->post['qty']), $this->post['product']);
        }elseif ($order['qty'] == $this->post['qty']) {
            $object = Mixin\delete($this->table, $this->post['product']);
        }else {
            $this->error('Нехватает препарата на складе');
        }
        if (!intval($object)) {
            $this->error('storage_preparat: '.$object);
        }
        for ($i=0; $i < $this->post['qty']; $i++) {
            $object = Mixin\insert('visit_price', $post);
            if (!intval($object)) {
                $this->error('visit_price: '.$object);
            }
        }
        $this->success();
    }

    public function success()
    {
        $_SESSION['message'] = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render();
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> '.$message.'</span>
        </div>
        ';
        render();
    }

}

class StorageOrdersModel extends Model
{
    public $table = 'storage_orders';

    public function form($pk = null)
    {
        global $db;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        if($_SESSION['message']){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="modal-body">
                <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">
                <input type="hidden" name="id" value="<?= $pk ?>">

                <div class="form-group row">

                    <div class="col-md-10">
                        <label>Расходные материалы:</label>
                        <select data-placeholder="Выберите материал" name="preparat_id" class="form-control select-price" required <?= ($pk) ? "disabled" : "data-fouc" ?>>
                            <option></option>
                            <?php if (permission(11)): ?>
                                <?php $sql = "SELECT * FROM storage WHERE category = 4 AND qty != 0"; ?>
                            <?php else: ?>
                                <?php $sql = "SELECT * FROM storage WHERE category IN (2, 3) AND qty != 0"; ?>
                            <?php endif; ?>
                            <?php foreach ($db->query($sql) as $row): ?>
                                <option value="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>" <?= ($post['preparat_id'] == $row['id']) ? "selected" : "" ?>><?= $row['name'] ?> | <?= $row['supplier'] ?> (годен до <?= date("d.m.Y", strtotime($row['die_date'])) ?>) в наличии - <?= $row['qty'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <label>Количество:</label>
                        <input type="number" name="qty" value="<?= $post['qty'] ?>" class="form-control">
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <?php
    }

    public function clean()
    {
        global $db;
        $this->post['date'] = date('Y-m-d');
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        if (!$this->post['id']) {
            $inf = $db->query("SELECT id, qty FROM storage_orders WHERE preparat_id = {$this->post['preparat_id']} AND parent_id = {$this->post['parent_id']}")->fetch();
            if ($inf) {
                $this->post['id'] = $inf['id'];
                $this->post['qty'] = $inf['qty'] + $this->post['qty'];
                $this->update();
            }
            return True;
        }
        return true;

    }

    public function success()
    {
        $_SESSION['message'] = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render();
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> '.$message.'</span>
        </div>
        ';
        render();
    }

}

class VisitRefundModel extends Model
{
    public $table = 'visit_price';

    public function form($pk = null)
    {
        global $db;
        ?>
        <form method="post" action="<?= add_url() ?>">

            <div class="modal-body">
                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="pricer_id" value="<?= $_SESSION['session_id'] ?>">
                <input type="hidden" name="user_id" id="user_id">
                <input type="hidden" name="visit_id" id="visit_id">

                <div class="form-group row">

                    <div class="col-md-12">
                        <label class="col-form-label">Сумма к оплате:</label>
                        <input type="text" class="form-control" id="total_price" disabled>
                    </div>

                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Наличный</label>
					<div class="col-md-9">
						<div class="input-group">
							<input type="number" name="price_cash" id="input_chek_1" step="0.5" class="form-control" placeholder="расчет" disabled>
                            <span class="input-group-prepend ml-5">
								<span class="input-group-text">
									<input type="checkbox" class="form-control-switchery" data-fouc id="chek_1" onchange="Checkert(this)">
								</span>
							</span>
						</div>
					</div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Пластиковый</label>
					<div class="col-md-9">
						<div class="input-group">
							<input type="number" name="price_card" id="input_chek_2" step="0.5" class="form-control" placeholder="расчет" disabled>
                            <span class="input-group-prepend ml-5">
								<span class="input-group-text">
									<input type="checkbox" class="form-control-switchery" data-fouc id="chek_2" onchange="Checkert(this)">
								</span>
							</span>
						</div>
					</div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Перечисление</label>
					<div class="col-md-9">
						<div class="input-group">
							<input type="number" name="price_transfer" id="input_chek_3" step="0.5" class="form-control" placeholder="расчет" disabled>
                            <span class="input-group-prepend ml-5">
								<span class="input-group-text">
									<input type="checkbox" class="form-control-switchery" data-fouc id="chek_3" onchange="Checkert(this)">
								</span>
							</span>
						</div>
					</div>
                </div>

            </div>

    		<div class="modal-footer">
    			<button type="button" class="btn btn-link" data-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-outline-info btn-sm">Печать</button>
    		</div>

        </form>

        <script type="text/javascript">

            function Checkert(event) {
                var input = $('#input_'+event.id);
                if(!input.prop('disabled')){
                    input.attr("disabled", "disabled");
                    Downsum(input);
                }else {
                    input.removeAttr("disabled");
                    Upsum(input);
                }
            }

        </script>
        <?php
    }

    public function clean()
    {
        global $db;
        $object = $db->query("SELECT * FROM visit_price WHERE visit_id ={$this->post['visit_id']}")->fetch();
        $this->post['sale'] = $object['sale'];
        $this->post['item_type'] = $object['item_type'];
        $this->post['item_id'] = $object['item_id'];
        $this->post['item_cost'] = $object['item_cost'];
        $this->post['item_name'] = $object['item_name'];
        $this->post['price_date'] = date('Y-m-d H:i:s');
        if (0 == $db->query("SELECT * FROM visit WHERE user_id={$this->post['user_id']} AND status != 5 AND completed IS NULL AND service_id != 1")->rowCount()) {
            Mixin\update('users', array('status' => null), $this->post['user_id']);
        }
        Mixin\delete('visit', $this->post['visit_id']);
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        $this->post['price_cash'] = -$this->post['price_cash'];
        $this->post['price_card'] = -$this->post['price_card'];
        $this->post['price_transfer'] = -$this->post['price_transfer'];
        return True;
    }

    public function success()
    {
        $_SESSION['message'] = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render();
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> '.$message.'</span>
        </div>
        ';
        render();
    }

}

class VisitAnestForm extends Model
{
    public $table = 'visit';

    public function form($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="1">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="grant_id" value="<?= $patient->grant_id ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">

            <div class="form-group-feedback form-group-feedback-right row">

                <div class="col-md-10">
                    <input type="text" class="form-control border-info" id="search_input" placeholder="Введите ID или имя">
                    <div class="form-control-feedback">
                        <i class="icon-search4 font-size-base text-muted"></i>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="text-right">
                        <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
                    </div>
                </div>

            </div>

            <div class="form-group">

                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr class="bg-dark">
                                <th>#</th>
                                <!-- <th>Отдел</th> -->
                                <th>Услуга</th>
                                <!-- <th>Тип</th> -->
                                <th>Доктор</th>
                                <th style="width: 100px">Кол-во</th>
                                <th class="text-right">Цена</th>
                            </tr>
                        </thead>
                        <tbody id="table_form">
                            <tr>
                                <td colspan="6" class="text-center" onclick="table_change()">услуги</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </form>
        <script type="text/javascript">
            let service = {};

            $("#search_input").keyup(function() {
                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table_search') ?>",
                    data: {
                        divisions: [
                            "<?php
                            foreach($db->query("SELECT * from division WHERE level = 11") as $row) {
                                echo $row['id'];
                            }
                            ?>"
                        ],
                        search: $("#search_input").val(),
                        selected: service,
                        types: "1",
                        cols: 2
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });
            });

            function table_change() {

                $.ajax({
                    type: "GET",
                    url: "<?= ajax('service_table') ?>",
                    data: {
                        divisions: [
                                "<?php
                                foreach($db->query("SELECT * from division WHERE level = 11") as $row) {
                                    echo $row['id'];
                                }
                                ?>"
                            ],
                        selected: service,
                        types: "1",
                        cols: 2
                    },
                    success: function (result) {
                        let service = {};
                        $('#table_form').html(result);
                    },
                });

            }
        </script>
        <?php
    }

    public function clean()
    {
        if (is_array($this->post['service'])) {
            $this->save_rows();
        }
    }

    public function save_rows()
    {
        global $db;
        foreach ($this->post['service'] as $key => $value) {

            $post_big['anesthesia'] = 1;
            $post_big['direction'] = $this->post['direction'];
            $post_big['status'] = 1;
            $post_big['grant_id'] = $this->post['grant_id'];
            $post_big['route_id'] = $this->post['route_id'];
            $post_big['user_id'] = $this->post['user_id'];
            $post_big['division_id'] = $this->post['division_id'][$key];
            $post_big['service_id'] = $value;
            $post_big['add_date'] = date("Y-m-d");
            $post_big['accept_date'] = date("Y-m-d");
            $post_big['completed'] = date("Y-m-d");

            if (!$this->post['division_grant']) {
                $post_big['parent_id'] = $this->post['parent_id'][$key];
                $post_big['division_id'] = $this->post['division_id'][$key];
            }
            for ($i=0; $i < $this->post['count'][$key]; $i++) {
                $post_big = Mixin\clean_form($post_big);
                $post_big = Mixin\to_null($post_big);
                $object = Mixin\insert($this->table, $post_big);
                if (!intval($object)){
                    $this->error($object);
                }

                $service = $db->query("SELECT price, name FROM service WHERE id = {$post_big['service_id']}")->fetch();
                $post['visit_id'] = $object;
                $post['user_id'] = $this->post['user_id'];
                $post['item_type'] = 1;
                $post['item_id'] = $post_big['service_id'];
                $post['item_cost'] = $service['price'];
                $post['item_name'] = $service['name'];
                $object = Mixin\insert('visit_price', $post);
                if (!intval($object)){
                    $this->error($object);
                }
            }
        }
        $this->success();
    }

    public function success()
    {
        $_SESSION['message'] = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render();
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
			<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
			<span class="font-weight-semibold"> '.$message.'</span>
	    </div>
        ';
        render();
    }
}
