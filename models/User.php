<?php

class UserModel extends Model
{
    public $table = 'users';

    public function form($pk = null) 
    {
        global $db, $PERSONAL, $classes;
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            if( isset($_SESSION['message_post']) ){
                $post = $_SESSION['message_post'];
                unset($_SESSION['message_post']);
            }
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">

            <div class="row">

                <div class="col-md-6">
                    <fieldset>

                        <legend class="font-weight-semibold"><i class="icon-user mr-2"></i> Персональные данные</legend>

                        <div class="form-group">
                            <label>Фамилия пользователя:</label>
                            <input type="text" class="form-control" name="last_name" placeholder="Введите Фамилия" required value="<?= $this->value('last_name') ?>">
                        </div>

                        <div class="form-group">
                            <label>Имя пользователя:</label>
                            <input type="text" class="form-control" name="first_name" placeholder="Введите имя" required value="<?= $this->value('first_name') ?>">
                        </div>

                        <div class="form-group">
                            <label>Отчество пользователя:</label>
                            <input type="text" class="form-control" name="father_name" placeholder="Введите Отчество" required value="<?= $this->value('father_name') ?>">
                        </div>

                        <div class="form-group">
                            <label>Выбирите роль:</label>
                            <select data-placeholder="Выбрать роль" onchange="TableChange(this)" name="user_level" id="user_level" class="<?= $classes['form-select'] ?>" required>
                                <option></option>
                                <?php foreach ($PERSONAL as $key => $value): ?>
                                    <?php if(!in_array($key, [1])): ?>
                                        <option value="<?= $key ?>"<?= ($this->value('user_level') == $key) ? 'selected': '' ?>><?= $value ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Отдел:</label>
                            <select data-placeholder="Выбрать отдел" name="division_id" id="division_id" class="<?= $classes['form-select'] ?>" required>
                                <option></option>
                                <?php foreach ($db->query("SELECT * FROM division") as $row): ?>
                                    <option value="<?= $row['id'] ?>" data-chained="<?= $row['level'] ?>" <?= ($this->value('division_id') == $row['id']) ? 'selected': '' ?>><?= $row['title'] ?></option>
                                <?php endforeach; ?>
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
                                    <label>Кабинет:</label>
                                    <input type="number" class="form-control" step="1" name="room" placeholder="Введите кабинет" value="<?= $this->value('room') ?>">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Доля:</label>
                                    <input type="number" class="form-control" step="0.1" name="share" placeholder="Введите Долю" value="<?= $this->value('share') ?>">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Логин:</label>
                                    <input type="text" class="form-control" name="username" placeholder="Введите Логин" required value="<?= $this->value('username') ?>">
                                </div>
                            </div>

                            <?php if (!$pk): ?>
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
                            <?php else: ?>
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
                            <?php endif; ?>

                        </div>

                        <div class="row" id="change_table_div"></div>

                    </fieldset>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

            <script type="text/javascript">
                $(function(){
                    $("#division_id").chained("#user_level");
                });
            </script>
        </form>

        <script>
            function TableChange(the) {
                if (the.value == 5) {
                    var div = `
                    <?php if (module('module_zetta_pacs')): ?>
                        <legend><b>ZeTTa PACS</b></legend>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>PACS Логин:</label>
                                <input type="text" class="form-control" name="pacs_login" placeholder="Введите логин" value="<?= $this->value('pacs_login') ?>">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>PACS пароль:</label>
                                <input type="text" class="form-control" name="pacs_password" placeholder="Введите пароль" value="<?= $this->value('pacs_password') ?>">
                            </div>
                        </div>
                    <?php endif; ?>
                    `;
                    
                }else{
                    var div = ``;
                }

                document.querySelector('#change_table_div').innerHTML = div;
                Swit.init();
            }
        </script>
        <?php
        if ($pk) {
            $this->jquery_init();
        }
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

?>
