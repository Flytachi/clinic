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
                <button type="submit" class="btn btn-outline-info">Сохранить <i class="icon-paperplane ml-2"></i></button>
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

class VisitReport extends Model
{
    public $table = 'visit';

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

            <div class="modal-header bg-info">
                <h5 class="modal-title">Заключение</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">

                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="id" id="rep_id" value="<?= $pk ?>">

                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <label class="col-form-label">Наименования отчета:</label>
                        <input type="text" name="report_title" value="<?= $post['report_title'] ?>" class="form-control" placeholder="Названия отчета">
                    </div>

                    <div class="col-md-10 offset-md-1">
                        <label class="col-form-label">Описание:</label>
                        <textarea rows="8" cols="3" name="report_description" class="form-control" placeholder="Описание"><?= $post['report_description'] ?></textarea>
                    </div>

                    <div class="col-md-10 offset-md-1">
                        <label class="col-form-label">Заключение:</label>
                        <textarea rows="3" cols="3" name="report_conclusion" class="form-control" placeholder="Заключения"><?= $post['report_conclusion'] ?></textarea>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-info">Сохранить</button>
            </div>

        </form>
        <?php
    }

    public function success()
    {
        header('location:'.$_SERVER['HTTP_REFERER']);
    }

}

class VisitUpStatus extends Model
{
    public $table = 'visit';

    public function get_or_404($pk)
    {
        $this->post['id'] = $pk;
        $this->post['status'] = 2;
        $this->post['accept_date'] = date('Y-m-d H:i:s');
        $this->url = "card/content_1.php?id=".$_GET['user_id'];
        $this->update();
    }

    public function success()
    {
        global $PROJECT_NAME;
        header("location:/$PROJECT_NAME/views/doctor/$this->url");
        exit;
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
                        foreach($db->query("SELECT * from users WHERE (user_level = 5 OR user_level = 6) AND id != {$_SESSION['session_id']}") as $row) {
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
                        foreach($db->query('SELECT * from service WHERE user_level = 5 OR user_level = 6') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>" ><?= $row['name'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="form-group row" style="display: none;">

                <div class="col-md-12">
                    <label>Жалоба:</label>
                    <textarea rows="4" cols="4" name="complaint" class="form-control" placeholder="Введите жалобу ..."><?= $patient->complaint ?></textarea>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-info">Сохранить</button>
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
                    <input type="text" class="form-control" value="<?= get_full_name($patient->user_id) ?>" disabled>
                </div>

                <div class="col-md-6">
                    <label>Отдел:</label>
                    <select data-placeholder="Выберите отдел" name="division_id" id="division2" class="form-control form-control-select2" required data-fouc>
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
                    <select data-placeholder="Выберите услугу" name="service_id" id="service" class="form-control select-price" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from service WHERE user_level = 5 OR user_level = 6') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>" data-price="<?= $row['price'] ?>"><?= $row['name'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="form-group row" style="display: none;">

                <div class="col-md-12">
                    <label>Жалоба:</label>
                    <textarea rows="4" cols="4" name="complaint" class="form-control" placeholder="Введите жалобу ..."><?= $patient->complaint ?></textarea>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-info">Сохранить</button>
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

    public function clean()
    {
        global $db;
        $stat = $db->query("SELECT * FROM division WHERE id={$this->post['division_id']} AND level=6")->fetch();
        if ($stat) {
            $this->post['laboratory'] = True;
        }
        unset($this->post['division_id']);
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
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

class VisitFinish extends Model
{
    public $table = 'visit';
    public $table1 = 'users';
    public $table2 = 'beds';

    public function get_or_404($pk)
    {
        global $db;
        $this->post['status'] = 0;
        $this->post['completed'] = date('Y-m-d H:i:s');
        foreach($db->query("SELECT * FROM visit WHERE user_id=$pk AND parent_id= {$_SESSION['session_id']} AND (report_title IS NOT NULL AND report_description IS NOT NULL AND report_conclusion IS NOT NULL)") as $inf){
            if ($inf['grant_id'] == $inf['parent_id']) {
                Mixin\update($this->table1, array('status' => null), $inf['user_id']);
                if ($inf['direction']) {
                    $pk_arr = array('user_id' => $inf['user_id']);
                    $object = Mixin\updatePro($this->table2, array('user_id' => null), $pk_arr);
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
        global $PROJECT_NAME;
        header("location:/$PROJECT_NAME/views/doctor/index.php");
        exit;
    }

}

class LaboratoryUpStatus extends Model
{
    public $table = 'visit';
    public $table2 = 'laboratory_analyze';

    public function get_or_404($pk)
    {
        global $db;
        $tip = $db->query("SELECT user_id, service_id FROM visit WHERE id=$pk")->fetch();
        foreach ($db->query("SELECT * FROM laboratory_analyze_type WHERE service_id = {$tip['service_id']}") as $row) {
            Mixin\insert( $this->table2, array('user_id' => $tip['user_id'], 'visit_id' => $pk, 'analyze_id' => $row['id']) );
        }
        $this->post['id'] = $pk;
        $this->post['status'] = 2;
        $this->post['accept_date'] = date('Y-m-d H:i:s');
        $this->update();
    }

    public function success()
    {
        global $PROJECT_NAME;
        header("location:/$PROJECT_NAME/views/laboratory/list_outpatient.php");
        exit;
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
        //     if ($object == 1){
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

class NotesModel extends Model
{

     public $table = "notes";

     public function form($pk=null)
     {
        global $patient;
         ?>

         <form method="POST" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="user_id" value="<?= $patient->user_id ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">

             <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label>Выберите дату:</label>
                        <input type="text" class="form-control" name="date_text" id="anytime-both" value="June 4th 08:47" readonly="">
                    </div>
                    <div class="col-md-6">
                        <label>Введите описание:</label>
                        <input type="text" class="form-control" name="description">
                    </div>
                </div>
                <div class="text-right" style="margin-top: 1%;">
                    <button type="submit" class="btn btn-primary legitRipple">Сохранить <i class="icon-paperplane ml-2"></i></button>
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
