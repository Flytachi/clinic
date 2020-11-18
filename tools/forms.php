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

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Аллергия:</label>
                            <textarea rows="4" cols="4" name="allergy" class="form-control" placeholder="Введите аллергия ..."><?= $post['allergy']?></textarea>
                        </div>
                    </div>

                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
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
        render('registry/index');
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
			<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
			<span class="font-weight-semibold"> '.$message.'</span>
	    </div>
        ';
        render('registry/index');
    }
}

class StationaryTreatmentForm extends Model
{
    public $table = 'visit';
    public $table1 = 'beds';
    public $table2 = 'users';

    public function form($pk = null)
    {
        global $db, $FLOOR;
        if($_SESSION['message']){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="1">
            <input type="hidden" name="status" value="1">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="form-group row">

                <div class="col-md-3">
                    <label>Пациет:</label>
                    <select data-placeholder="Выбрать пациета" name="user_id" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                            foreach ($db->query('SELECT * FROM users WHERE user_level = 15 AND status IS NULL') as $row) {
                                ?>
                                <option value="<?= $row['id'] ?>"><?= addZero($row['id']) ?> - <?= get_full_name($row['id']) ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Этаж:</label>
                    <select data-placeholder="Выбрать этаж" name="" id="floor" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach($FLOOR as $key => $value) {
                            ?>
                            <option value="<?= $key ?>"><?= $value ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Палата:</label>
                    <select data-placeholder="Выбрать палату" name="" id="ward" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT DISTINCT ward, floor from beds ') as $row) {
                            ?>
                            <option value="<?= $row['ward'] ?>" data-chained="<?= $row['floor'] ?>"><?= $row['ward'] ?> палата</option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Койка:</label>
                    <select data-placeholder="Выбрать койку" name="bed" id="bed" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from beds') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['ward'] ?>" <?= ($row['user_id']) ? 'disabled' : '' ?>><?= $row['num'] ?> койка</option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Отдел:</label>
                    <select data-placeholder="Выберите отдел" name="" id="division" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from division WHERE level = 5') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Специалиста:</label>
                    <select data-placeholder="Выберите специалиста" name="parent_id" id="parent_id" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from users WHERE user_level = 5') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>"><?= get_full_name($row['id']) ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-12">
                    <label>Жалоба:</label>
                    <textarea rows="4" cols="4" name="complaint" class="form-control" placeholder="Введите жалобу ..."></textarea>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
            </div>

        </form>
        <script type="text/javascript">
            $(function(){
                $("#ward").chained("#floor");
                $("#bed").chained("#ward");
                $("#parent_id").chained("#division");
            });
        </script>
        <?php
    }

    public function save()
    {
        global $db;
        if($this->clean()){
            $bed_pk = $this->post['bed'];
            unset($this->post['bed']);
            $object = Mixin\insert($this->table, $this->post);
            if ($object == 1){
                // Создание списка Услуг
                $post0 = array('visit_id' => $db->lastInsertId(), 'service_id' => 1);
                $object0 = Mixin\insert('visit_service', $post0);
                // Бронь койки
                $post1 = array('visit_id' => $db->lastInsertId(), 'service_id' => $servise_pk);
                $object1 = Mixin\update($this->table1, array('user_id' => $this->post['user_id']), $bed_pk);
                if ($object1 == 1){
                    // Обновление статуса у пациента
                    $object2 = Mixin\update($this->table2, array('status' => True), $this->post['user_id']);
                    if ($object2 == 1){
                        $this->success();
                    }else {
                        $this->error($object2);
                    }
                }else{
                    $this->error($object1);
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
        render('registry/index');
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
			<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
			<span class="font-weight-semibold"> '.$message.'</span>
	    </div>
        ';
        render('registry/index');
    }
}

class OutpatientTreatmentForm extends Model
{
    public $table = 'visit';
    public $table1 = 'visit_service';
    public $table2 = 'users';

    public function form($pk = null)
    {
        global $db;
        if($_SESSION['message']){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="0">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Пациент:</label>
                    <select data-placeholder="Выбрать пациента" name="user_id" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                            foreach ($db->query('SELECT * FROM users WHERE user_level = 15 AND status IS NULL') as $row) {
                                ?>
                                <option value="<?= $row['id'] ?>"><?= addZero($row['id']) ?> - <?= get_full_name($row['id']) ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Отдел:</label>
                    <select data-placeholder="Выберите отдел" name="" id="division2" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from division WHERE level = 5 OR level = 6') as $row) {
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
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from users WHERE user_level = 5 OR user_level = 6') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>"><?= get_full_name($row['id']) ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Услуга:</label>
                    <select data-placeholder="Выберите услугу" name="service" id="service" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from service WHERE user_level = 5 OR user_level = 6') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>"><?= $row['name'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <!-- <div class="col-md-6">
                    <select data-placeholder="Выберите услуги"  id="service" class="form-control multiselect" multiple="multiple" required data-fouc>
                        <?php
                        foreach($db->query('SELECT * from service WHERE user_level = 5') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>"><?= $row['name'] ?></option>
                            <?php
                        }
                        ?>
    				</select>
                </div> -->

            </div>

            <div class="form-group row">

                <div class="col-md-12">
                    <label>Жалоба:</label>
                    <textarea rows="4" cols="4" name="complaint" class="form-control" placeholder="Введите жалобу ..."></textarea>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
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

    public function save()
    {
        global $db;
        if($this->clean()){
            $servise_pk = $this->post['service'];
            unset($this->post['service']);
            $object = Mixin\insert($this->table, $this->post);
            if ($object == 1){
                // Создание списка Услуг
                $post1 = array('visit_id' => $db->lastInsertId(), 'service_id' => $servise_pk);
                $object1 = Mixin\insert($this->table1, $post1);
                // Обновление статуса у пациента
                $object2 = Mixin\update($this->table2, array('status' => True), $this->post['user_id']);
                if ($object1 == 1 and $object2 == 1){
                    $this->success();
                }else {
                    if ($object1 != 1) {
                        $this->error($object1);
                    }else {
                        $this->error($object2);
                    }
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
        render('registry/index');
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
			<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
			<span class="font-weight-semibold"> '.$message.'</span>
	    </div>
        ';
        render('registry/index');
    }
}

class UserServiceForm extends Model
{
    public $table = 'visit_service';
    public $table1 = 'visit';
    public $table2 = 'users';

    public function get_or_404($pk)
    {
        global $db;
        // Нахождение id визита
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(PDO::FETCH_OBJ);
        // Удаление услуги
        $del = Mixin\delete($this->table, $pk);
        if($del){
            // Проверка услуг
            $status = $db->query("SELECT * FROM $this->table WHERE visit_id = $object->visit_id")->rowCount();
            if(!$status){
                $object2 = $db->query("SELECT * FROM $this->table1 WHERE id = $object->visit_id")->fetch(PDO::FETCH_OBJ);
                $del1 = Mixin\delete($this->table1, $object->visit_id);
                if($del1){
                    Mixin\update($this->table2, array('status' => null), $object2->user_id);
                    $this->success(1);
                }
            }else {
                $this->success();
            }
        }else {
            $this->error('Ошибка при удаление услуги!');
        }
    }

    public function success($stat = null)
    {
        $mess = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        if ($stat) {
            $sth = array('message' => $mess, 'stat'=>1);
        }else {
            $sth = array('message' => $mess);
        }
        echo json_encode($sth);
    }

    public function error($message)
    {
        $mess = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
			<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
			<span class="font-weight-semibold"> '.$message.'</span>
	    </div>
        ';
        $sth = array('message' => $mess);
        echo json_encode($sth);

    }
}

class PatientUpStatus extends Model
{
    public $table = 'visit';

    public function get_or_404($pk)
    {
        $this->post['id'] = $pk;
        $this->post['status'] = 2;
        $this->post['accept_date'] = date('Y-m-d H:i:s');
        $this->url = "card/content_1.php?id=".$this->post['id'];
        $this->update();
    }

    public function success()
    {
        global $PROJECT_NAME;
        header("location:/$PROJECT_NAME/views/doctor/$this->url");
        exit;
    }

}

class LaboratoryUpStatus extends Model
{
    public $table = 'visit';

    public function get_or_404($pk)
    {
        $this->post['id'] = $pk;
        $this->post['status'] = 2;
        $this->post['accept_date'] = date('Y-m-d H:i:s');
        $this->url = "index.php";
        $this->update();
    }

    public function success()
    {
        global $PROJECT_NAME;
        header("location:/$PROJECT_NAME/views/laboratory/$this->url");
        exit;
    }

}

class PatientFailure extends Model
{
    public $table = 'visit';

    public function form($pk = null)
    {
        ?>
        <form method="post" action="<?= add_url() ?>" id="form_<?= __CLASS__ ?>">
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
                <button type="submit" id="button_<?= __CLASS__ ?>" class="btn bg-danger">Отказаться</button>
            </div>

        </form>
        <?php
    }

    public function update()
    {
        if($this->clean()){
            $pk = $this->post['id'];
            unset($this->post['id']);
            $object = Mixin\update($this->table, $this->post, $pk);
            if ($object == 1){
                $this->success($pk);
            }else{
                $this->error($object);
            }
        }
    }

    public function success($pk)
    {
        echo "PatientFailure_tr_$pk";
    }

}

class PatientFinish extends Model
{
    public $table = 'visit';
    public $table1 = 'users';
    public $table2 = 'beds';

    public function get_or_404($pk)
    {
        global $db;
        if ($db->query("SELECT * FROM visit WHERE id=$pk")->rowCount()) {
            $pk_arr = array('user_id' => $db->query("SELECT * FROM visit WHERE id=$pk")->fetch(PDO::FETCH_OBJ)->user_id);
            $object = Mixin\updatePro($this->table2, array('user_id' => null), $pk_arr);
        }
        $this->post['id'] = $pk;
        $this->post['status'] = 0;
        $this->post['completed'] = date('Y-m-d H:i:s');
        $this->url = "index";
        $this->pk = $db->query("SELECT us.id FROM visit vs LEFT JOIN users us ON (vs.user_id=us.id) WHERE vs.id=$pk")->fetch(PDO::FETCH_OBJ)->id;
        $this->update();
    }

    public function success()
    {
        global $PROJECT_NAME;
        Mixin\update($this->table1, array('status' => null), $this->pk);
        header("location:/$PROJECT_NAME/views/doctor/$this->url.php");
        exit;
    }

}

class PatientReport extends Model
{
    public $table = 'visit_service';

    public function form($pk = null)
    {
        global $db;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        ?>
        <form method="post" id="form_<?= __CLASS__ ?>" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" id="rep_id" value="<?= $pk ?>">

            <textarea name="report" id="report" rows="10" cols="80">
                <?= $post['report'] ?>

            </textarea>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
            </div>
            <script>
                CKEDITOR.replace( 'report' );
            </script>

        </form>
        <?php
    }

    public function clean()
    {
        $this->post['completed'] = True;
        return True;
    }

    public function success()
    {
        header('location:'.$_SERVER['HTTP_REFERER']);
    }

}

class PatientRoute extends Model
{
    public $table = 'visit';
    public $table1 = 'visit_service';
    public $table2 = 'users';

    public function form($pk = null)
    {
        global $db;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="0">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Пациент:</label>
                    <input type="hidden" class="form-control" name="user_id" id="<?= __CLASS__ ?>_user_id">
                    <input type="text" class="form-control" id="<?= __CLASS__ ?>_user_id_get" disabled>
                </div>

                <div class="col-md-6">
                    <label>Отдел:</label>
                    <select data-placeholder="Выберите отдел" name="" id="division2" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from division WHERE level = 5') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                            <?php
                        }division
                        ?>
                    </select>
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Выберите специалиста:</label>
                    <select data-placeholder="Выберите специалиста" name="parent_id" id="parent_id2" class="form-control form-control-select2" data-fouc required>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from users WHERE user_level = 5') as $row) {
                            if ($row['id'] != $_SESSION['session_id']) {
                                ?>
                                <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>"><?= get_full_name($row['id']) ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Услуга:</label>
                    <select data-placeholder="Выберите услугу" name="service" id="service" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from service WHERE user_level = 5') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>"><?= $row['name'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="form-group row" style="display: none;">

                <div class="col-md-12">
                    <label>Жалоба:</label>
                    <textarea rows="4" cols="4" name="complaint" id="<?= __CLASS__ ?>_complaint" class="form-control" placeholder="Введите жалобу ..."></textarea>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
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

    public function save()
    {
        global $db;
        if($this->clean()){
            $servise_pk = $this->post['service'];
            unset($this->post['service']);
            $object = Mixin\insert($this->table, $this->post);
            if ($object == 1){
                // Создание списка Услуг
                $post1 = array('visit_id' => $db->lastInsertId(), 'service_id' => $servise_pk);
                $object1 = Mixin\insert($this->table1, $post1);
                // Обновление статуса у пациента
                $object2 = Mixin\update($this->table2, array('status' => True), $this->post['user_id']);
                if ($object1 == 1 and $object2 == 1){
                    $this->success();
                }else {
                    if ($object1 != 1) {
                        $this->error($object1);
                    }else {
                        $this->error($object2);
                    }
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
        header('location:'.$_SERVER['HTTP_REFERER']);
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
			<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
			<span class="font-weight-semibold"> '.$message.'</span>
	    </div>
        ';
        header('location:'.$_SERVER['HTTP_REFERER']);
    }
}
