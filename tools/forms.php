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
                            <label>Имя пациента:</label>
                            <input type="text" name="first_name" class="form-control" placeholder="Введите имя" value="<?= $post['first_name']?>" required>
                        </div>

                        <div class="form-group">
                            <label>Фамилия пациента:</label>
                            <input type="text" name="last_name" class="form-control" placeholder="Введите Фамилия" value="<?= $post['last_name']?>" required>
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
                                    <option><?= $post['region']?></option>
                                    <optgroup label="Бухоро вилояти">
                                        <option value="Ромитан">Ромитан</option>
                                    </optgroup>
                                    <optgroup label="Тошкент вилояти">
                                        <option value="Чилонзор">Чилонзор</option>
                                        <option value="Миробод">Миробод</option>
                                        <option value="Олмазор">Олмазор</option>
                                        <option value="Юнусобод">Юнусобод</option>
                                    </optgroup>

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
                            <input type="number" name="numberPhone" placeholder="+9989" class="form-control" value="<?= $post['numberPhone']?>" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Место работы:</label>
                        <input type="text" name="placeWork" placeholder="Введите место работ" class="form-control" value="<?= $post['placeWork']?>" required>
                    </div>

                    <div class="form-group">
                        <label>Должность:</label>
                        <input type="text" name="position" placeholder="Введите должность" class="form-control" value="<?= $post['position']?>" required>
                    </div>

                    <!-- <div class="form-group row">
                        <div class="col-md-6">
                            <label>Аллергия:</label>
                            <textarea rows="4" cols="4" name="allergy" class="form-control" placeholder="Введите аллергия ..."><?= $post['allergy']?></textarea>
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

                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <label class="col-form-label">Наименования отчета:</label>
                        <input type="text" name="report_title" id="report_title" value="<?= $post['report_title'] ?>" class="form-control" placeholder="Названия отчета">
                    </div>

                    <div class="col-md-10 offset-md-1">
                        <label class="col-form-label">Описание:</label>
                        <textarea rows="5" cols="3" name="report_description" class="form-control" placeholder="Описание"><?= $post['report_description'] ?></textarea>
                    </div>

                    <div class="col-md-10 offset-md-1">
                        <label class="col-form-label">Диагноз:</label>
                        <textarea rows="3" cols="3" name="report_diagnostic" class="form-control" placeholder="Заключения"><?= $post['report_diagnostic'] ?></textarea>
                    </div>

                    <div class="col-md-10 offset-md-1">
                        <label class="col-form-label">Рекомендации:</label>
                        <textarea rows="3" cols="3" name="report_recommendation" class="form-control" placeholder="Заключения"><?= $post['report_recommendation'] ?></textarea>
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
                <input type="hidden" name="id" id="rep_id" value="<?= $pk ?>">
                <?php if (division_assist() == 2): ?>
                    <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <label class="col-form-label">Наименования отчета:</label>
                        <input type="text" name="report_title" id="report_title" value="<?= $post['report_title'] ?>" class="form-control" placeholder="Названия отчета">
                    </div>

                    <div class="col-md-10 offset-md-1">
                        <label class="col-form-label">Описание:</label>
                        <textarea rows="5" cols="3" name="report_description" class="form-control" placeholder="Описание"><?= $post['report_description'] ?></textarea>
                    </div>

                    <div class="col-md-10 offset-md-1">
                        <label class="col-form-label">Диагноз:</label>
                        <textarea rows="3" cols="3" name="report_diagnostic" class="form-control" placeholder="Заключения"><?= $post['report_diagnostic'] ?></textarea>
                    </div>

                    <div class="col-md-10 offset-md-1">
                        <label class="col-form-label">Рекомендации:</label>
                        <textarea rows="3" cols="3" name="report_recommendation" class="form-control" placeholder="Заключения"><?= $post['report_recommendation'] ?></textarea>
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
                return $this->form($object['id']);
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
                    if ($row['grant_id'] == $row['parent_id']) {
                        Mixin\update('users', array('status' => null), $row['user_id']);
                    }
                }
                $this->clear_post();
                $this->set_post(array(
                    'status' => 0,
                    'completed' => date('Y-m-d H:i:s')
                ));
                $object = Mixin\update($this->table, $this->post, $pk);
                if (intval($object)){
                    $this->success();
                }else{
                    $this->error($object);
                }
            }else {
                if (intval($object)){
                    $this->success();
                }else{
                    $this->error($object);
                }
            }
        }
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

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Пациент:</label>
                    <input type="hidden" class="form-control" name="user_id" value="<?= $patient->id ?>">
                    <input type="text" class="form-control" value="<?= get_full_name($patient->id) ?>" disabled>
                </div>

                <div class="col-md-6">
                    <label>Отдел:</label>
                    <select data-placeholder="Выберите отдел" name="division_id" id="division2" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query("SELECT * from division WHERE level = 5") as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Выберите специалиста:</label>
                    <select data-placeholder="Выберите специалиста" name="parent_id" id="parent_id2" class="form-control form-control-select2" data-fouc required>
                        <?php
                        foreach($db->query("SELECT * from users WHERE user_level = 5 AND id != {$_SESSION['session_id']}") as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>"><?= get_full_name($row['id']) ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Услуга:</label>
                    <select data-placeholder="Выберите услугу" name="service_id" id="service" class="form-control select-price" required>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from service WHERE user_level = 5') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>" data-price="<?= $row['price'] ?>"><?= $row['name'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <script type="text/javascript">
            $(function(){
                $("#parent_id2").chained("#division2");
                $("#service").chained("#division2");
            });
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

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Пациент:</label>
                    <input type="hidden" class="form-control" name="user_id" value="<?= $patient->id ?>">
                    <input type="text" class="form-control" value="<?= get_full_name($patient->id) ?>" disabled>
                </div>

                <div class="col-md-6">
                    <label>Отдел:</label>
                    <select data-placeholder="Выберите отдел" name="division_id" id="division2" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query("SELECT * from division WHERE level = 5 AND id != ".division()) as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Выберите специалиста:</label>
                    <select data-placeholder="Выберите специалиста" name="parent_id" id="parent_id2" class="form-control form-control-select2" data-fouc required>
                        <?php
                        foreach($db->query("SELECT * from users WHERE user_level = 5 AND id != {$_SESSION['session_id']}") as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>"><?= get_full_name($row['id']) ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Услуга:</label>
                    <select data-placeholder="Выберите услугу" name="service_id" id="service" class="form-control select-price" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from service WHERE user_level = 5') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>" data-price="<?= $row['price'] ?>"><?= $row['name'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <script type="text/javascript">
            $(function(){
                $("#parent_id2").chained("#division2");
                $("#service").chained("#division2");
            });
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

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Пациент:</label>
                    <input type="hidden" class="form-control" name="user_id" value="<?= $patient->id ?>">
                    <input type="text" class="form-control" value="<?= get_full_name($patient->id) ?>" disabled>
                </div>

                <div class="col-md-6">
                    <label>Отдел:</label>
                    <select data-placeholder="Выберите отдел" name="division_id" id="division2" class="form-control form-control-select2" required data-fouc>
                        <?php
                        foreach($db->query("SELECT * from division WHERE level = 6") as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Выберите специалиста:</label>
                    <select data-placeholder="Выберите специалиста" name="parent_id" id="parent_id2" class="form-control form-control-select2" data-fouc required>
                        <?php
                        foreach($db->query("SELECT * from users WHERE user_level = 6") as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>"><?= get_full_name($row['id']) ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Услуга:</label>
                    <select data-placeholder="Выберите услугу" name="service_id" id="service" class="form-control select-price" required>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from service WHERE user_level = 6') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>" data-price="<?= $row['price'] ?>"><?= $row['name'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <script type="text/javascript">
            $(function(){
                $("#parent_id2").chained("#division2");
                $("#service").chained("#division2");
            });
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
            <input type="hidden" name="laboratory" value="1">

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Пациент:</label>
                    <input type="hidden" class="form-control" name="user_id" value="<?= $patient->id ?>">
                    <input type="text" class="form-control" value="<?= get_full_name($patient->id) ?>" disabled>
                </div>

                <div class="col-md-6">
                    <label>Отдел:</label>
                    <select data-placeholder="Выберите отдел" name="division_id" id="division2" class="form-control form-control-select2" required data-fouc>
                        <?php
                        foreach($db->query("SELECT * from division WHERE level = 6") as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Выберите специалиста:</label>
                    <select data-placeholder="Выберите специалиста" name="parent_id" id="parent_id2" class="form-control form-control-select2" data-fouc required>
                        <?php
                        foreach($db->query('SELECT * from users WHERE user_level = 6') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>"><?= get_full_name($row['id']) ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Услуга:</label>
                    <select data-placeholder="Выберите услугу" name="service_id" id="service" class="form-control select-price" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from service WHERE user_level = 6') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>" data-price="<?= $row['price'] ?>"><?= $row['name'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <script type="text/javascript">
            $(function(){
                $("#parent_id2").chained("#division2");
                $("#service").chained("#division2");
            });
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

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Пациент:</label>
                    <input type="hidden" class="form-control" name="user_id" value="<?= $patient->id ?>">
                    <input type="text" class="form-control" value="<?= get_full_name($patient->id) ?>" disabled>
                </div>

                <div class="col-md-6">
                    <label>Отдел:</label>
                    <select data-placeholder="Выберите отдел" name="division_id" id="division2" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query("SELECT * from division WHERE level = 10 AND (assist IS NULL OR assist = 1)") as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Выберите специалиста:</label>
                    <select data-placeholder="Выберите специалиста" name="parent_id" id="parent_id2" class="form-control form-control-select2" data-fouc required>
                        <?php
                        foreach($db->query("SELECT * from users WHERE (user_level = 10) AND id != {$_SESSION['session_id']}") as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>"><?= get_full_name($row['id']) ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Услуга:</label>
                    <select data-placeholder="Выберите услугу" name="service_id" id="service" class="form-control select-price" required>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from service WHERE user_level = 10') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>" data-price="<?= $row['price'] ?>"><?= $row['name'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <script type="text/javascript">
            $(function(){
                $("#parent_id2").chained("#division2");
                $("#service").chained("#division2");
            });
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

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Пациент:</label>
                    <input type="hidden" class="form-control" name="user_id" value="<?= $patient->id ?>">
                    <input type="text" class="form-control" value="<?= get_full_name($patient->id) ?>" disabled>
                </div>

                <div class="col-md-6">
                    <label>Отдел:</label>
                    <select data-placeholder="Выберите отдел" name="division_id" id="division2" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query("SELECT * from division WHERE level = 10 AND (assist IS NULL OR assist = 1)") as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Выберите специалиста:</label>
                    <select data-placeholder="Выберите специалиста" name="parent_id" id="parent_id2" class="form-control form-control-select2" data-fouc required>
                        <?php
                        foreach($db->query('SELECT * from users WHERE user_level = 10') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>"><?= get_full_name($row['id']) ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Услуга:</label>
                    <select data-placeholder="Выберите услугу" name="service_id" id="service" class="form-control select-price" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from service WHERE user_level = 10') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>" data-price="<?= $row['price'] ?>"><?= $row['name'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <script type="text/javascript">
            $(function(){
                $("#parent_id2").chained("#division2");
                $("#service").chained("#division2");
            });
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
            <input type="hidden" name="division_id" value="<?= division() ?>">
            <input type="hidden" name="division_id" value="<?= division() ?>">

            <div class="form-group row">

                <div class="col-md-12">
                    <label>Услуга:</label>
                    <select data-placeholder="Выберите услугу" name="service_id" id="service" class="form-control select-price" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query("SELECT * from service WHERE user_level = ".level()." AND division_id =".division()) as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>"><?= $row['name'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <?php
    }

    public function clean()
    {
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
            if (intval($object)){
                $service = $db->query("SELECT price, name FROM service WHERE id = {$this->post['service_id']}")->fetch();
                $post['visit_id'] = $object;
                $post['item_type'] = 1;
                $post['item_id'] = $this->post['service_id'];
                $post['item_cost'] = $service['price'];
                $post['item_name'] = $service['name'];
                $object = Mixin\insert('visit_price', $post);
                if (intval($object)){
                    $this->success();
                }else{
                    $this->error($object);
                }
            }else{
                $this->error($object);
            }
        }
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

        $this->mod('test');

        $this->post['status'] = 0;
        $this->post['completed'] = date('Y-m-d H:i:s');
        foreach($db->query("SELECT * FROM visit WHERE user_id=$pk AND parent_id= {$_SESSION['session_id']} AND (report_title IS NOT NULL AND report_description IS NOT NULL AND report_recommendation IS NOT NULL)") as $inf){
            if ($inf['grant_id'] == $inf['parent_id'] and $inf['parent_id'] != $inf['route_id']) {
                Mixin\update($this->table1, array('status' => null), $inf['user_id']);
                if ($inf['direction']) {
                    $pk_arr = array('user_id' => $inf['user_id']);
                    $object = Mixin\updatePro($this->table2, array('user_id' => null), $pk_arr);
                }
            }
            if ($inf['assist_id']) {
                if (!$inf['direction']) {
                    $this->post['grant_id'] = $_SESSION['session_id'];
                    Mixin\update($this->table1, array('status' => null), $inf['user_id']);
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
        $this->post['id'] = $pk;
        $this->post['status'] = 2;
        $this->post['accept_date'] = date('Y-m-d H:i:s');
        $this->update();
    }

    public function success()
    {
        render();
    }

}

class PatientFailure extends Model
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
                    <input type="hidden" name="parent_id" value="">

                    <div class="col-md-12">
                        <label>Причина:</label>
                        <textarea rows="4" cols="4" name="failure" class="form-control" placeholder="Введите причину ..." required></textarea>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" id="button_<?= __CLASS__ ?>" class="btn btn-outline-danger btn-sm">Отказаться</button>
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
                        $(result).css("background-color", "rgb(244, 67, 54)");
                        $(result).css("color", "white");
                        $(result).fadeOut(900, function() {
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
        // if($this->clean()){
        //     $pk = $this->post['id'];
        //     unset($this->post['id']);
        //     $object = Mixin\update($this->table, $this->post, $pk);
        //     if (intval($object)){
        //         $this->success($pk);
        //     }else{
        //         $this->error($object);
        //     }
        // }
        $this->success($this->post['id']);
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
