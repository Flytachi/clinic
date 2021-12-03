<?php

use Warframe\Model;

class UserModel extends Model
{
    public $table = 'users';

    public function SForm($pk = null) 
    {
        global $db, $classes;
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <div class="form-group">
            <label>Филиал:</label>
            <select data-placeholder="Выбрать филиал" name="branch_id" id="branch_id" class="<?= $classes['form-select'] ?>" required>
                <option></option>
                <?php foreach ($db->query("SELECT * FROM corp_branchs WHERE is_active IS NOT NULL") as $row): ?>
                    <option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <script type="text/javascript">

            $('#branch_id').on("change",function(){
                Update('<?= up_url(null, 'UserModel') ?>&branch_id='+this.value);
            });

        </script>
        <?php
    }

    public function form($pk = null) 
    {
        global $db, $PERSONAL, $classes, $session;
        
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            if( isset($_SESSION['message_post']) ){
                $this->post = $_SESSION['message_post'];
                unset($_SESSION['message_post']);
            }
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <?php if(!$pk): ?>
                <input type="hidden" name="is_active" value="1">
            <?php endif; ?>

            <?php if( permission(1) ): ?>
                <?php $branch = (isset($_GET['branch_id']) and $_GET['branch_id']) ? $_GET['branch_id'] : $this->value('branch_id'); ?>
                <div class="form-group">
                    <label>Филиал:</label>
                    <select data-placeholder="Выбрать филиал" name="branch_id" id="branch_id" class="<?= $classes['form-select'] ?>" required>
                        <option></option>
                        <?php foreach ($db->query("SELECT * FROM corp_branchs WHERE is_active IS NOT NULL") as $row): ?>
                            <option value="<?= $row['id'] ?>" <?= ($branch == $row['id']) ? 'selected': '' ?>><?= $row['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <script type="text/javascript">

                    $('#branch_id').on("change",function(){
                        Update('<?= up_url($pk, 'UserModel') ?>&branch_id='+this.value);
                    });

                </script>
            <?php else: ?>
                <?php $branch = (isset($_GET['branch_id']) and $_GET['branch_id']) ? $_GET['branch_id'] : $session->branch; ?>
                <input type="hidden" name="branch_id" value="<?= $branch ?>">
            <?php endif; ?>

            <div class="row">

                <div class="col-md-6">
                    <fieldset>

                        <legend class="font-weight-semibold"><i class="icon-user mr-2"></i> Персональные данные</legend>

                        <?php if( $this->value('user_level') == $session->session_level): ?>

                            <div class="form-group">
                                <label>Выбирите роль:</label>
                                <input type="text" class="form-control" value="<?= $PERSONAL[$this->value('user_level')] ?>" readonly>
                            </div>

                        <?php else: ?>

                            <div class="form-group">
                                <label>Выбирите роль:</label>
                                <select data-placeholder="Выбрать роль" onchange="TableChange(this)" name="user_level" id="user_level" class="<?= $classes['form-select'] ?>" required>
                                    <option></option>
                                    <optgroup label="Обслуживание">
                                        <?php foreach ($PERSONAL as $key => $value): ?>
                                            <?php if(20 < $key && $key < 30): ?>
                                                <option value="<?= $key ?>"<?= ($this->value('user_level') == $key) ? 'selected': '' ?>><?= $value ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </optgroup>
                                    <optgroup label="Специалисты">
                                        <?php foreach ($PERSONAL as $key => $value): ?>
                                            <?php if(10 < $key && $key < 20): ?>
                                                <option value="<?= $key ?>"<?= ($this->value('user_level') == $key) ? 'selected': '' ?>><?= $value ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </optgroup>
                                    <optgroup label="Администрация">
                                        <?php foreach ($PERSONAL as $key => $value): ?>
                                            <?php if(level() < $key && $key < 10): ?>
                                                <option value="<?= $key ?>"<?= ($this->value('user_level') == $key) ? 'selected': '' ?>><?= $value ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </optgroup>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Отдел:</label>
                                <select data-placeholder="Выбрать отдел" name="division_id" id="division_id" class="<?= $classes['form-select'] ?>" required>
                                    <option></option>
                                    <?php foreach ($db->query("SELECT * FROM divisions WHERE branch_id = $branch") as $row): ?>
                                        <?php if($row['level'] == 11): ?>
                                            <option value="<?= $row['id'] ?>" data-chained="7" <?= ($this->value('division_id') == $row['id']) ? 'selected': '' ?>><?= $row['title'] ?></option>
                                        <?php endif; ?>
                                        <option value="<?= $row['id'] ?>" data-chained="<?= $row['level'] ?>" <?= ($this->value('division_id') == $row['id']) ? 'selected': '' ?>><?= $row['title'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        <?php endif; ?>

                        <div class="form-group">
                            <label>Фамилия пользователя:</label>
                            <input type="text" class="form-control text-capitalize" name="last_name" placeholder="Введите Фамилия" required value="<?= $this->value('last_name') ?>">
                        </div>

                        <div class="form-group">
                            <label>Имя пользователя:</label>
                            <input type="text" class="form-control text-capitalize" name="first_name" placeholder="Введите имя" required value="<?= $this->value('first_name') ?>">
                        </div>

                        <div class="form-group">
                            <label>Отчество пользователя:</label>
                            <input type="text" class="form-control text-capitalize" name="father_name" placeholder="Введите Отчество" required value="<?= $this->value('father_name') ?>">
                        </div>

                    </fieldset>
                </div>

                <div class="col-md-6">
                    <fieldset>
                        <legend class="font-weight-semibold"><i class="icon-user"></i> Person</legend>

                        <div class="row">

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

                        <div class="row" id="change_div_User"></div>

                    </fieldset>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>

        <script type="text/javascript">

            $(function(){
                $("#division_id").chained("#user_level");
            });

            function TableChange(the) {
                if (the.value == 11) {
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
                    document.querySelector('#change_div_User').innerHTML = div;
                }else if (the.value == 13 || the.value == 14) {
                    document.querySelector('#division_id').required = false;
                    $("#division_id").prepend(`<option value="0">Выбрать весь отдел</option>`);
                }else{
                    if (!document.querySelector('#division_id').required) {
                        document.querySelector('#division_id').required = true;
                    }
                    document.querySelector('#change_div_User').innerHTML = ``;
                }
            }

        </script>
        <?php
        $this->jquery_init();
    }

    public function clean()
    {
        global $db;
        $qty = $db->query("SELECT id FROM $this->table")->rowCount();
        $ti = module("personal_qty");
        if ( isset($this->post['id']) or (($ti and $ti > $qty) or (!$ti and 5 > $qty)) ) {
            $this->post = Mixin\clean_form($this->post);
            $this->post = Mixin\to_null($this->post);
            if ($this->post['password'] and $this->post['password2']){
                if ($this->post['password'] == $this->post['password2']){
                    unset($this->post['password2']);
                }else{
                    $_SESSION['message_post']= $this->post;
                    $this->error("Пароли не совпадают!");
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
        } else {
            $this->error("Достигнут предел создания пользователей!");
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

?>
