<?php

include 'functions/model.php';


class UserModel extends Model
{
    public $table = 'users';

    public function form($pk = null)
    {
        global $db, $PERSONAL;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        if($_SESSION['message']){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            if($_SESSION['message_post']){
                $post = $_SESSION['message_post'];
                unset($_SESSION['message_post']);
            }
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">

            <div class="row">

                <div class="col-md-6">
                    <fieldset>

                        <legend class="font-weight-semibold"><i class="icon-user mr-2"></i> Персональные данные</legend>

                        <div class="form-group">
                            <label>Имя пользователя:</label>
                            <input type="text" class="form-control" name="first_name" placeholder="Введите имя" required value="<?= $post['first_name'] ?>">
                        </div>

                        <div class="form-group">
                            <label>Фамилия пользователя:</label>
                            <input type="text" class="form-control" name="last_name" placeholder="Введите Фамилия" required value="<?= $post['last_name'] ?>">
                        </div>
                        <div class="form-group">
                            <label>Отчество пользователя:</label>
                            <input type="text" class="form-control" name="father_name" placeholder="Введите Отчество" required value="<?=  $post['father_name'] ?>">
                        </div>

                        <div class="form-group">
                            <label>Выбирите роль:</label>
                            <select data-placeholder="Выбрать роль" name="user_level" id="user_level" class="form-control form-control-select2" required>
                                <option></option>
                                <?php
                                foreach ($PERSONAL as $key => $value) {
                                    ?>
                                    <option value="<?= $key ?>"<?= ($post['user_level']  == $key) ? 'selected': '' ?>><?= $value ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Отдел:</label>
                            <select data-placeholder="Выбрать отдел" name="division_id" id="division_id" class="form-control form-control-select2" required >
                                <option></option>
                                <?php
                                foreach($db->query('SELECT * from division') as $row) {
                                    ?>
                                    <option value="<?= $row['id'] ?>" data-chained="<?= $row['level'] ?>" <?= ($post['division_id']  == $row['id']) ? 'selected': '' ?>><?= $row['title'] ?></option>

                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                    </fieldset>
                </div>

                <div class="col-md-6">
                    <fieldset>
                        <legend class="font-weight-semibold"><i class="icon-user"></i> Person</legend>

                        <div class="row">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Доля:</label>
                                    <input type="number" class="form-control" step="0.1" name="share" placeholder="Введите Долю" required value="<?= $post['share'] ?>">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Логин:</label>
                                    <input type="text" class="form-control" name="username" placeholder="Введите Логин" required value="<?= $post['username'] ?>">
                                </div>
                            </div>

                            <?php
                                if(!$pk){
                                    ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Пароль:</label>
                                            <input type="password" class="form-control" name="password" placeholder="Введите Пароль" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Повторите пароль:</label>
                                            <input type="password" class="form-control" name="password2" placeholder="Введите Пароль" required>
                                        </div>
                                    </div>
                                    <?php
                                }
                                else {
                                    ?>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Пароль:</label>
                                            <input type="password" class="form-control" name="password" placeholder="Введите Пароль">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Повторите пароль:</label>
                                            <input type="password" class="form-control" name="password2" placeholder="Введите Пароль">
                                        </div>
                                    </div>
                                    <?php
                                }
                            ?>
                        </div>


                    </fieldset>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
            </div>

            <script type="text/javascript">
                $(function(){
                    $("#division_id").chained("#user_level");
                });
            </script>
        </form>
        <?php
    }

    public function clean()
    {
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        if ($this->post['password'] and $this->post['password2']){
            if ($this->post['password'] == $this->post['password2']){
                unset($this->post['password2']);
            }else{
                $_SESSION['message'] = '
                <div class="alert bg-danger alert-styled-left alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                    <span class="font-weight-semibold"> Пароли не совпадают!</span>
                </div>
                ';
                $_SESSION['message_post']= $this->post;
                render('admin/index');
            }
            $this->post['password'] = sha1($this->post['password']);
        }else{
            unset($this->post['password']);
            unset($this->post['password2']);
        }
        if($this->post['user_level'] and !$this->post['division_id']){
            $this->post['division_id'] = null;
        }
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
        render('admin/index');
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
			<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
			<span class="font-weight-semibold"> '.$message.'</span>
	    </div>
        ';
        render('admin/index');
    }
}

class DivisionModel extends Model
{
    public $table = 'division';

    public function form($pk = null)
    {
        global $db, $PERSONAL;
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
            <input type="hidden" name="id" value="<?= $pk ?>">

            <div class="form-group">
                <label>Выбирите Роль:</label>
                <select data-placeholder="Выбрать роль" name="level" class="form-control form-control-select2" required>
                    <option></option>
                    <?php
                    foreach ($PERSONAL as $key => $value) {
                        ?>
                        <option value="<?= $key ?>"<?= ($post['level']  == $key) ? 'selected': '' ?>><?= $value ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Название отдела:</label>
                <input type="text" class="form-control" name="title" placeholder="Введите название отдела" required value="<?= $post['title']?>">
            </div>

            <div class="form-group">
                <label>Название специолиста:</label>
                <input type="text" class="form-control" name="name" placeholder="Введите название специолиста" required value="<?= $post['name']?>">
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
        render('admin/division');
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            '.$message.'
        </div>
        ';
        render('admin/division');
    }
}

class BedModel extends Model
{
    public $table = 'beds';

    public function form($pk = null)
    {
        global $db, $FLOOR;
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

            <div class="form-group">
                <label>Выбирите этаж:</label>
                <select data-placeholder="Выбрать этаж" name="floor" id="floor" class="form-control form-control-select2" required>
                    <option></option>
                    <?php
                    foreach ($FLOOR as $key => $value) {
                        ?>
                        <option value="<?= $key ?>"<?= ($post['floor']  == $key) ? 'selected': '' ?>><?= $value ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
               <label>Палата:</label>
               <input type="text" class="form-control" name="ward" placeholder="Введите кабинет" required value="<?= $post['ward'] ?>">
            </div>

            <div class="form-group">
                <label>Номер:</label>
                <input type="text" class="form-control" name="num" placeholder="Введите номер" required value="<?= $post['num']?>">
            </div>

            <div class="form-group">
                <label>Тип:</label>
                <select data-placeholder="Выбрать тип" name="types" class="form-control form-control-select2" required>
                    <option></option>
                    <?php
                    foreach($db->query('SELECT * from bed_type') as $row) {
                        ?>
                        <option value="<?= $row['id'] ?>"<?php if($row['id'] == $post['types']){echo'selected';} ?>><?= $row['name'] ?></option>
                        <?php
                    }
                    ?>
                </select>
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
        render('admin/bed');
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
			<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
			<span class="font-weight-semibold"> '.$message.'</span>
	    </div>
        ';
        render('admin/bed');
    }
}

class BedTypeModel extends Model
{
    public $table = 'bed_type';

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

            <div class="form-group">
                <label>Название:</label>
                <input type="text" class="form-control" name="name" placeholder="Введите название" required value="<?= $post['name']?>">
            </div>

            <div class="form-group">
                <label>Цена:</label>
                <input type="text" class="form-control" name="price" placeholder="Введите цену" required value="<?= $post['price']?>">
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
        render('admin/bed');
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
			<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
			<span class="font-weight-semibold"> '.$message.'</span>
	    </div>
        ';
        render('admin/bed');
    }
}

class ServiceModel extends Model
{
    public $table = 'service';

    public function form($pk = null)
    {
        global $db, $PERSONAL;
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

            <div class="form-group">
                <label>Выбирите Роль:</label>
                <select data-placeholder="Выбрать роль" name="user_level" id="user_level" class="form-control form-control-select2" required>
                    <option></option>
                    <?php
                    foreach ($PERSONAL as $key => $value) {
                        ?>
                        <option value="<?= $key ?>"<?= ($post['user_level']  == $key) ? 'selected': '' ?>><?= $value ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Отдел:</label>
                <select data-placeholder="Выбрать отдел" name="division_id" id="division_id" class="form-control form-control-select2" required >
                    <option></option>
                    <?php
                    foreach($db->query('SELECT * from division') as $row) {
                        ?>
                        <option value="<?= $row['id'] ?>" data-chained="<?= $row['level'] ?>" <?= ($post['division_id']  == $row['id']) ? 'selected': '' ?>><?= $row['title'] ?></option>

                        <?php
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label>Название:</label>
                <input type="text" class="form-control" name="name" placeholder="Введите название" required value="<?= $post['name']?>">
            </div>

            <div class="form-group">
                <label>Цена:</label>
                <input type="number" class="form-control" step="0.1" name="price" placeholder="Введите цену" required value="<?= $post['price']?>">
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
            </div>

        </form>
        <script type="text/javascript">
            $(function(){
                $("#division_id").chained("#user_level");
            });
        </script>
        <?php
    }

    public function clean()
    {
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        if($this->post['user_level'] and !$this->post['division_id']){
            $this->post['division_id'] = null;
        }
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
        render('admin/service');
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
			<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
			<span class="font-weight-semibold"> '.$message.'</span>
	    </div>
        ';
        render('admin/service');
    }
}

class StorageTypeModel extends Model
{
    public $table = 'storage_type';

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

            <div class="form-group">
                <label>Название:</label>
                <input type="text" class="form-control" name="name" placeholder="Введите название" required value="<?= $post['name']?>">
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
        render('admin/storage');
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
			<button type="button" class="close" data-dismiss="alert"><span>×</span></button>
			<span class="font-weight-semibold"> '.$message.'</span>
	    </div>
        ';
        render('admin/storage');
    }
}

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
            $post1 = array('parent_id' => $_POST['parent_id'], 'status_bed' => True); // id => pk  // table => users
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

class UserCheckOutpatientModel extends Model
{
    public $table = 'user_check';
    public $table2 = 'users';
    public $table3 = 'user_service';

    public function form($pk = null)
    {
        global $db;
        ?>
        <div class="modal-body">
            <form method="post" action="<?= add_url() ?>">
                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="user_id" id="user_amb_id">

                <div class="form-group row">

                    <div class="col-md-9">
                        <label class="col-form-label">Сумма к оплате:</label>
                        <input type="text" class="form-control" id="total_price" value="-" disabled>
                    </div>
                    <div class="col-md-3">
                        <label class="col-form-label">Скидка:</label>
                        <div class="form-group-feedback form-group-feedback-right">
                            <input type="text" class="form-control" name="sale" placeholder="">
                            <div class="form-control-feedback text-success">
                                <span style="font-size: 20px;">%</span>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="form-group">

                    <label class="col-form-label">Наличный расчет:</label>
                    <div class="form-group-feedback form-group-feedback-right">
                        <input type="text" class="form-control border-success" name="price_cash" placeholder="" >
                        <div class="form-control-feedback text-success">
                            <i class="icon-checkmark-circle2"></i>
                        </div>
                    </div>

                </div>

            </form>
        </div>

		<div class="modal-footer">
			<button type="button" class="btn btn-link" data-dismiss="modal">Отмена</button>
			<button type="submit" class="btn bg-info">Печать</button>
		</div>
        <?php
    }

    public function save()
    {
        if($this->clean()){
            // $this->dd();
            $user_pk = $this->post['user_id'];
            $pk_us = array('user_id' => $user_pk);
            $post1 = array('parent_id' => null, 'status' => 1);
            $object1 = Mixin\update($this->table2, $post1, $user_pk);

            if($object1 == 1){
                $post2 = array('priced' => date('Y-m-d H:i:s'));
                $object2 = Mixin\updatePro($this->table3, $post2, $pk_us);
                if(intval($object2)){
                    $object = Mixin\insert($this->table, $this->post);
                    if ($object == 1){
                        $this->success();
                    }else{
                        $this->error($object);
                    }
                }else{
                    $this->error($object2);
                }
            }else{
                $this->error($object1);
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
        render('cashbox/index');
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> '.$message.'</span>
        </div>
        ';
        render('cashbox/index');
    }
}

class UserCheckStationaryModel extends Model
{
    public $table = 'user_check';

    public function form($pk = null)
    {
        global $db;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="user_id" id="user_st_id">

            <div class="form-group form-group-float row">

                <div class="col-md-6">
                    <div class="form-group-feedback form-group-feedback-right">
                        <input type="text" class="form-control border-success" name="price_payment" placeholder="Предоплата" >
                        <div class="form-control-feedback text-success">
                            <button type="submit" class="btn btn-outline-success border-transparent legitRipple">
                                <i style="font-size: 23px;" class="icon-checkmark-circle2"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group-feedback form-group-feedback-right">
                        <input type="text" class="form-control border-danger" placeholder="Возврат">
                        <div class="form-control-feedback text-danger">
                            <i style="font-size: 23px;" class="icon-history" data-toggle="modal" data-target="#modal_default2"></i>
                        </div>
                    </div>
                </div>

            </div>

            <div class="text-right">
                <button type="button" class="btn alpha-blue text-blue-800 border-blue-600 legitRipple ">Экспорт в PDF</button>
            </div>
        </form>
        <?php
    }

    // public function save()
    // {
    //     if($this->clean()){
    //         // $this->dd();
    //         $user_pk = $this->post['user_id'];
    //         $pk_us = array('user_id' => $user_pk);
    //         $post1 = array('parent_id' => null, 'status' => 1);
    //         $object1 = Mixin\update($this->table2, $post1, $user_pk);
    //
    //         if($object1 == 1){
    //             $post2 = array('priced' => date('Y-m-d H:i:s'));
    //             $object2 = Mixin\updatePro($this->table3, $post2, $pk_us);
    //             if(intval($object2)){
    //                 $object = Mixin\insert($this->table, $this->post);
    //                 if ($object == 1){
    //                     $this->success();
    //                 }else{
    //                     $this->error($object);
    //                 }
    //             }else{
    //                 $this->error($object2);
    //             }
    //         }else{
    //             $this->error($object1);
    //         }
    //     }
    // }

    public function success()
    {
        $_SESSION['message'] = '
        <div class="alert alert-primary" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            Успешно
        </div>
        ';
        render('cashbox/index');
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> '.$message.'</span>
        </div>
        ';
        render('cashbox/index');
    }
}

?>
