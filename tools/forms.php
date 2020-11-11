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
                            <label>Жалоба:</label>
                            <textarea rows="4" cols="4" name="complaint" class="form-control" placeholder="Введите жалобу ..."><?= $post['complaint']?></textarea>
                        </div>
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
    public $table = 'users';
    public $table2 = 'beds';

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
            <input type="hidden" name="id" value="<?= $post['id'] ?>">

            <div class="row">

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Пациет:</label>
                        <select data-placeholder="Выбрать пациета" name="id" class="form-control form-control-select2" required data-fouc>
                            <option></option>
                            <?php
                                foreach ($db->query('SELECT * FROM users WHERE user_level = 15 AND status IS NULL AND parent_id IS NULL') as $row) {
                                    ?>
                                    <option value="<?= $row['id'] ?>"><?= addZero($row['id']) ?> - <?= get_full_name($row['id']) ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
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
                </div>

                <div class="col-md-3">
                    <div class="form-group">
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
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label>Койка:</label>
                        <select data-placeholder="Выбрать койку" name="bed_id" id="bed_id" class="form-control form-control-select2" required data-fouc>
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

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
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
                </div>

                <div class="col-md-6">
                    <div class="form-group">
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

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
            </div>

        </form>
        <script type="text/javascript">
            $(function(){
                $("#ward").chained("#floor");
                $("#bed_id").chained("#ward");
                $("#parent_id").chained("#division");
            });
        </script>
        <?php
    }

    public function update()
    {
        if($this->clean()){
            $pk = $this->post['id'];
            $post1 = array('parent_id' => $_POST['parent_id'], 'status_bed' => True, 'status' => True); // id => pk  // table => users
            $post2 = array('user_id' => $pk); // id => bed_id   // table => beds

            $object1 = Mixin\update($this->table, $post1, $pk);
            $object2 = Mixin\update($this->table2, $post2, $_POST['bed_id']);
            if ($object1 == 1 and $object2 == 1){
                $this->success();
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
    public $table = 'users';
    public $table2 = 'user_service';

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
            <input type="hidden" name="id" value="<?= $post['id'] ?>">

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Выберите пациета:</label>
                        <select data-placeholder="Выбрать пациета" name="id" class="form-control form-control-select2" required data-fouc>
                            <option></option>
                            <?php
                                foreach ($db->query('SELECT * FROM users WHERE user_level = 15 AND status IS NULL AND parent_id IS NULL') as $row) {
                                    ?>
                                    <option value="<?= $row['id'] ?>"><?= addZero($row['id']) ?> - <?= get_full_name($row['id']) ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
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

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Выберите специалиста:</label>
                        <select data-placeholder="Выберите специалиста" name="parent_id" id="parent_id2" class="form-control form-control-select2" data-fouc required>
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

                <div class="col-md-6">
                    <div class="form-group">
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

    public function update()
    {
        if($this->clean()){
            $pk = $this->post['id'];
            $servise_pk = $this->post['service'];
            unset($this->post['id']);
            unset($this->post['service']);
            $post2 = array('user_id' => $pk, 'service_id' => $servise_pk);
            $object1 = Mixin\update($this->table, $this->post, $pk);
            $object2 = Mixin\insert($this->table2, $post2);
            if ($object1 == 1 and $object2 == 1){
                $this->success();
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
    public $table = 'user_service';
    public $table2 = 'users';

    public function get_or_404($pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(PDO::FETCH_OBJ);
        $user_pk = $object->user_id;
        $del = Mixin\delete($this->table, $pk);
        if($del){
            $status = $db->query("SELECT * FROM $this->table WHERE user_id = $object->user_id")->rowCount();
            if(!$status){
                $post101 = array('parent_id' => null);
                $object1 = Mixin\update($this->table2, $post101, $user_pk);
                if($object1){
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

?>
