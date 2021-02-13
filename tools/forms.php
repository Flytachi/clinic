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
                            <input type="text" name="residenceAddress" class="form-control" placeholder="Введите адрес" value="<?= $post['residenceAddress']?>" required>
                        </div>

                        <div class="form-group">
                            <label>Адрес по прописке:</label>
                            <input type="text" name="registrationAddress" class="form-control" placeholder="Введите адрес" value="<?= $post['registrationAddress']?>" required>
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
                            <input type="text" name="passport" placeholder="Серия паспорта" class="form-control" value="<?= $post['passport']?>" required>
                        </div>
                        <div class="col-md-6">
                            <label>Телефон номер:</label>
                            <input type="text" name="numberPhone" class="form-control" value="<?= ($post['numberPhone']) ? $post['numberPhone'] : '+998'?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Место работы:</label>
                        <input type="text" name="placeWork" placeholder="Введите место работы" class="form-control" value="<?= $post['placeWork']?>" required>
                    </div>

                    <div class="form-group">
                        <label>Должность:</label>
                        <input type="text" name="position" placeholder="Введите должность" class="form-control" value="<?= $post['position']?>" required>
                    </div>

                    <div class="form-group">
                        <label class="d-block font-weight-semibold">Статус</label>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="resident" id="custom_checkbox_stacked_unchecked">
                            <label class="custom-control-label" for="custom_checkbox_stacked_unchecked">Резидент</label>
                        </div>
                    </div>

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
                <input type="hidden" name="id" id="repfun_id" value="<?= $pk ?>">

                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <label class="col-form-label">Клинический диагноз:</label>
                        <textarea rows="3" cols="3" name="report_diagnostic" class="form-control" placeholder="Клинический диагноз"><?= $post['report_diagnostic'] ?></textarea>
                    </div>

                    <div class="col-md-10 offset-md-1">
                        <label class="col-form-label">Сопутствующие заболевания:</label>
                        <textarea rows="3" cols="3" name="report_title" class="form-control" placeholder="Сопутствующие заболевания"><?= $post['report_title'] ?></textarea>
                    </div>

                    <div class="col-md-10 offset-md-1">
                        <label class="col-form-label">Жалоба:</label>
                        <textarea rows="5" cols="3" name="report_description" class="form-control" placeholder="Жалоба"><?= $post['report_description'] ?></textarea>
                    </div>

                    <div class="col-md-10 offset-md-1">
                        <label class="col-form-label">Анамнез Морби:</label>
                        <textarea rows="3" cols="3" name="report_recommendation" class="form-control" placeholder="Анамнез Морби"><?= $post['report_recommendation'] ?></textarea>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <?php if (level() == 10): ?>
                    <!-- <a href="<?= up_url($_GET['user_id'], 'VisitFinish') ?>" onclick="return confirm('Вы точно хотите завершить визит пациента!')" class="btn btn-outline-danger">Завершить</a> -->
                    <input class="btn btn-outline-danger btn-sm" type="submit" value="Завершить" name="end"></input>
                <?php endif; ?>
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <?php
    }

    public function get_or_404($pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch();
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
                    'status' => null,
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
                    foreach($db->query("SELECT * from division WHERE level in (5,12) AND id !=". division()) as $row) {
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
                    foreach($db->query("SELECT * from division WHERE level in (5,12) AND id !=". division()) as $row) {
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
        $this->post['status'] = null;
        $this->post['completed'] = date('Y-m-d H:i:s');
        foreach($db->query("SELECT * FROM visit WHERE user_id=$pk AND parent_id= {$_SESSION['session_id']} AND accept_date IS NOT NULL AND completed IS NULL AND (service_id = 1 OR (report_title IS NOT NULL AND report_description IS NOT NULL AND report_recommendation IS NOT NULL))") as $inf){
            if ($inf['grant_id'] == $inf['parent_id'] and ($inf['direction'] or 1 == $db->query("SELECT * FROM visit WHERE user_id=$pk AND status != 5 AND completed IS NULL AND service_id != 1")->rowCount())) {
                if (!$inf['direction']) {
                    Mixin\update($this->table1, array('status' => null), $pk);
                }
                if ($inf['direction']) {
                    $pk_arr = array('user_id' => $pk);
                    $object = Mixin\updatePro($this->table2, array('user_id' => null), $pk_arr);
                }
            }
            if ($inf['assist_id']) {
                if (!$inf['direction']) {
                    $this->post['grant_id'] = $_SESSION['session_id'];
                    Mixin\update($this->table1, array('status' => null), $pk);
                }
            }
            $this->post['id'] = $inf['id'];
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
            if ($object != 1){
                $this->error($object);
            }
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
        $col = $db->query("SELECT id, time FROM bypass_time WHERE bypass_id = {$_GET['pk']}")->fetchAll();
        $span = count($col);
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="text-right">
                <button onclick="AddTrDate()" type="button" class="btn btn-outline-success btn-sm" style="margin-bottom:20px"><i class="icon-plus22 mr-2"></i>Добавить день</button>
            </div>

            <div id="error_div"></div>

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
                                    $post = $db->query("SELECT * FROM bypass_date WHERE bypass_id = {$_GET['pk']} AND bypass_time_id = {$value['id']} AND date = '$dat'")->fetch();
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
                                                        <i style="font-size:1.5rem;" class="text-success icon-checkmark-circle" onclick="SwetDate(this)" data-id="<?= $post['id'] ?>" data-date="<?= $date->format('Y-m-d') ?>" data-time="<?= $value['id'] ?>" data-val=""></i>
                                                    <?php else: ?>
                                                        <i style="font-size:1.5rem;" class="text-success icon-circle" onclick="SwetDate(this)" data-id="<?= $post['id'] ?>" data-date="<?= $date->format('Y-m-d') ?>" data-time="<?= $value['id'] ?>" data-val="1"></i>
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
                        bypass_time_id: swet_input.dataset.time,
                        date: swet_input.dataset.date,
                        status: swet_input.dataset.val,
                        products: products
                    };
                }else {
                    var data = {
                        model: "<?= __CLASS__ ?>",
                        bypass_id: "<?= $_GET['pk'] ?>",
                        user_id: "<?= $bypass['user_id'] ?>",
                        bypass_time_id: swet_input.dataset.time,
                        date: swet_input.dataset.date,
                        status: swet_input.dataset.val,
                        products: products
                    };
                }
                if (swet_input.dataset.val == 1) {
                    $(swet_input).removeClass('icon-circle');
                    $(swet_input).addClass('icon-checkmark-circle');
                    swet_input.dataset.val = "";
                }else if(swet_input.dataset.val == ""){
                    $(swet_input).removeClass('icon-checkmark-circle');
                    $(swet_input).addClass('icon-circle');
                    swet_input.dataset.val = 1;
                }

                $.ajax({
                    type: form.attr("method"),
                    url: form.attr("action"),
                    data: data,
                    success: function (result) {
                        if (!Number(result) && result != "success") {
                            $('#error_div').html(result);
                        }else if(Number(result)){
                            swet_input.dataset.id = result;
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
        $col = $db->query("SELECT id, time FROM bypass_time WHERE bypass_id = {$_GET['pk']}")->fetchAll();
        $span = count($col);
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div id="error_div"></div>

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
                                    $post = $db->query("SELECT * FROM bypass_date WHERE bypass_id = {$_GET['pk']} AND bypass_time_id = {$value['id']} AND date = '$dat'")->fetch();
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
                $(tr).html('<i style="font-size:1.5rem;" class="text-success icon-checkmark-circle"></i>');
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
                        console.log(result);
                        if (!Number(result)) {
                            if (result != "success") {
                                $('#error_div').html(result);
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
                foreach ($this->post['products'] as $value){
                    $post = $db->query("SELECT id, preparat_id 'item_id', price 'item_cost', preparat_code 'item_name', qty FROM storage_preparat WHERE preparat_id = $value")->fetch();
                    if(!$post){
                        $this->error("Не осталось препарата ".$value);
                        $this->stop();
                    }
                    $post['visit_id'] = $this->post['visit_id'];
                    $post['user_id'] = $user_pk;
                    $post['item_type'] = $db->query("SELECT catg FROM products WHERE product_id = {$post['item_id']}")->fetch()['catg'];
                    if ($post['qty'] <= 1) {
                        $object = Mixin\delete('storage_preparat', $post['id']);
                    }else {
                        $object = Mixin\update('storage_preparat', array('qty' => $post['qty']-1), array('preparat_id' => $value));
                    }
                    if (intval($object)) {
                        unset($post['qty']);
                        unset($post['id']);
                        $object1 = Mixin\insert('visit_price', $post);
                        if (!intval($object1)) {
                            $this->error('visit_price'.$object1);
                        }
                    }else {
                        $this->error('storage_preparat'.$object);
                    }
                }
            }else {
                // ДОктор
                if ($this->post['status']) {

                    foreach ($this->post['products'] as $value){
                        $post = $db->query("SELECT * FROM storage_orders WHERE user_id = {$this->post['user_id']} AND parent_id = {$_SESSION['session_id']} AND preparat_id = $value AND date = '".$this->post['date']."'")->fetch();
                        if ($post) {
                            $post_pk = $post['id'];
                            unset($post['id']);
                            $post['qty'] ++;
                            $post['date'] = $this->post['date'];
                            $object = Mixin\update('storage_orders', $post, $post_pk);
                        }else {
                            $post = array(
                                'user_id' => $this->post['user_id'],
                                'parent_id' => $_SESSION['session_id'],
                                'preparat_id' => $value,
                                'qty' => 1,
                                'date' => $this->post['date']
                            );
                            $object = Mixin\insert('storage_orders', $post);
                        }
                        if (!intval($object)) {
                            $this->error('storage_orders: '.$object);
                        }
                    }

                } else {

                    foreach ($this->post['products'] as $value){
                        $post = $db->query("SELECT * FROM storage_orders WHERE user_id = {$this->post['user_id']} AND parent_id = {$_SESSION['session_id']} AND preparat_id = $value AND date = '".$this->post['date']."'")->fetch();
                        if ($post['qty'] > 1) {
                            $post_pk = $post['id'];
                            unset($post['id']);
                            $post['qty'] --;
                            $object = Mixin\update('storage_orders', $post, $post_pk);
                        }else {
                            $object = Mixin\delete('storage_orders', $post['id']);
                        }
                    }

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
        echo '
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            '.$message.'
        </div>
        ';
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

class StoragePreparatForm extends Model
{
    public $table = 'storage_preparat';

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

                    <div class="col-md-8">
                        <label>Расходные материалы:</label>
                        <select data-placeholder="Выберите материал" name="product" class="form-control select-price" required data-fouc>
                            <option></option>
                            <?php foreach ($db->query("SELECT st.id, st.preparat_code, st.qty FROM storage_preparat st LEFT JOIN users us ON(us.id=st.parent_id) WHERE us.user_level = 7") as $row): ?>
                                <option value="<?= $row['id'] ?>" data-price="<?= $row['qty'] ?>"><?= $row['preparat_code'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
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
        $post['item_type'] = $db->query("SELECT catg FROM products WHERE product_id = {$order['preparat_id']}")->fetch()['catg'];
        $post['item_cost'] = $order['price'];
        $post['item_name'] = $order['preparat_code'];
        for ($i=0; $i < $this->post['qty']; $i++) {
            $object = Mixin\insert('visit_price', $post);
        }
        if (!intval($object)) {
            $this->error('visit_price: '.$object);
        }
        if ($order['qty'] > $this->post['qty']) {
            $object = Mixin\update('storage_preparat', array('qty' => $order['qty']-$this->post['qty']), $this->post['product']);
        } else {
            $object = Mixin\delete('storage_preparat', $this->post['product']);
        }
        if (!intval($object)) {
            $this->error('storage_preparat: '.$object);
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

class StoragePreparatAnestForm extends Model
{
    public $table = 'storage_preparat';

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

                    <div class="col-md-8">
                        <label>Расходные материалы:</label>
                        <select data-placeholder="Выберите материал" name="product" class="form-control select-price" required data-fouc>
                            <option></option>
                            <?php foreach ($db->query("SELECT st.id, st.preparat_code, st.qty FROM storage_preparat st LEFT JOIN users us ON(us.id=st.parent_id) WHERE us.user_level = 11") as $row): ?>
                                <option value="<?= $row['id'] ?>" data-price="<?= $row['qty'] ?>"><?= $row['preparat_code'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
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
        $post['item_type'] = $db->query("SELECT catg FROM products WHERE product_id = {$order['preparat_id']}")->fetch()['catg'];
        $post['item_cost'] = $order['price'];
        $post['item_name'] = $order['preparat_code'];
        for ($i=0; $i < $this->post['qty']; $i++) {
            $object = Mixin\insert('visit_price', $post);
        }
        if (!intval($object)) {
            $this->error('visit_price: '.$object);
        }
        if ($order['qty'] > $this->post['qty']) {
            $object = Mixin\update('storage_preparat', array('qty' => $order['qty']-$this->post['qty']), $this->post['product']);
        } else {
            $object = Mixin\delete('storage_preparat', $this->post['product']);
        }
        if (!intval($object)) {
            $this->error('storage_preparat: '.$object);
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
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="modal-body">
                <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">

                <div class="form-group row">

                    <div class="col-md-8">
                        <label>Расходные материалы:</label>
                        <select data-placeholder="Выберите материал" name="preparat_id" class="form-control select-price" required data-fouc>
                            <option></option>
                            <?php foreach ($db->query("SELECT product_id, product_code, qty FROM products") as $row): ?>
                                <option value="<?= $row['product_id'] ?>" data-price="<?= $row['qty'] ?>"><?= $row['product_code'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label>Количество:</label>
                        <input type="number" name="qty" value="1" class="form-control">
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

class VisitLaboratory extends Model
{
    public $table = 'visit';

    public function update()
    {
        global $db;
        foreach (json_decode($this->post['id']) as $id) {
            $post['laboratory_num'] = $this->post['laboratory_num'];
            $post = Mixin\clean_form($post);
            $post = Mixin\to_null($post);

            $pk = $id;
            $object = Mixin\update($this->table, $post, $pk);
            if (!intval($object)){
                $this->error($object);
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

class AparatLaboratory extends Model
{
    public $table = 'visit';

    public function clean()
    {
        global $db;
        $this->post['template'] = read_labaratory($_FILES['template']['tmp_name']);
        foreach ($this->post['template'] as $item) {
            if ($item['type'] == "label") {
                $dt = [];
                $dt['laboratory_num'] = $item['label_lab'];
                continue;
            }
            $dt['code'] = $item['code'];
            $dt['result'] = $item['result'];
            $this->post['data'][] = $dt;
        }
        unset($this->post['template']);
        // prit($data);
        foreach ($this->post['data'] as $arr) {
            // prit($arr);
            $visits = $db->query("SELECT lat.id 'analyze_id', vs.id 'visit_id', vs.user_id 'user_id', vs.service_id 'service_id', lat.code FROM visit vs LEFT JOIN laboratory_analyze_type lat ON(lat.service_id=vs.service_id) WHERE vs.accept_date IS NOT NULL AND vs.completed IS NULL AND vs.laboratory_num = {$arr['laboratory_num']}")->fetchAll();
            foreach ($visits as $post) {
                if ($post['code'] == $arr['code']) {
                    $post['result'] = $arr['result'];
                    unset($post['code']);
                    $object = Mixin\insert('laboratory_analyze', $post);
                    if (!intval($object)){
                        $this->error($object);
                    }
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
