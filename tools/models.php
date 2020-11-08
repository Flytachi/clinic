<?php

include 'functions/model.php';


class UserModel extends Model
{
    public $table = 'users';

    public function form($pk = null)
    {
        global $db, $PERSONAL;
        if(intval($pk)){
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
                                if(!intval($pk)){
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
                                    <!-- <div class="col-md-6">
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
                                    </div> -->
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
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                    Пароли не совпадают!
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
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            '.$message.'
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
        if(intval($pk)){
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
        if(intval($pk)){
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
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            '.$message.'
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
        if(intval($pk)){
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
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            '.$message.'
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
        if(intval($pk)){
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
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            '.$message.'
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
        if(intval($pk)){
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
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            '.$message.'
        </div>
        ';
        render('admin/storage');
    }
}

?>
