<?php

include 'functions/model.php';


class UserModel extends Model
{
    public $table = 'users';

    public function form(int $pk = null)
    {
        global $PROJECT_NAME, $PERSONAL, $db;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">

            <div class="row">

                <div class="col-md-6">
                    <fieldset>

                        <legend class="font-weight-semibold"><i class="icon-user mr-2"></i> Персональные данные</legend>

                        <div class="form-group">
                            <label>Имя пользователя:</label>
                            <input type="text" class="form-control" name="first_name" placeholder="Введите имя" required value="<?= ($pk) ? $this->post->first_name : '' ?>">
                        </div>

                        <div class="form-group">
                            <label>Фамилия пользователя:</label>
                            <input type="text" class="form-control" name="last_name" placeholder="Введите Фамилия" required value="<?= ($pk) ? $this->post->last_name : '' ?>">
                        </div>
                        <div class="form-group">
                            <label>Отчество пользователя:</label>
                            <input type="text" class="form-control" name="father_name" placeholder="Введите Отчество" required value="<?= ($pk) ? $this->post->father_name : '' ?>">
                        </div>

                        <?php
                        if ($pk){
                            $division_id = $this->post->division_id;
                            $user_level = $this->post->user_level;
                        }else {
                            $division_id = '';
                            $user_level = '';
                        }
                        ?>

                        <div class="form-group">
                            <label>Выбирите роль:</label>
                            <select data-placeholder="Выбрать роль" name="user_level" id="user_level" class="form-control form-control-select2" required data-fouc>
                                <option></option>
                                <?php
                                foreach ($PERSONAL as $key => $value) {
                                    ?>
                                    <option value="<?= $key ?>"<?= ($user_level  == $key) ? 'selected': '' ?>><?= $value ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Отдел:</label>
                            <select data-placeholder="Выбрать отдел" name="division_id" id="division_id" class="form-control form-control-select2" required data-fouc>
                                <option></option>
                                <?php
                                foreach($db->query('SELECT * from division') as $row) {
                                    ?>
                                    <option value="<?= $row['id'] ?>" data-chained="<?= $row['level'] ?>" <?= ($division_id  == $row['id']) ? 'selected': '' ?>><?= $row['title'] ?></option>

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
                                    <input type="number" class="form-control" step="0.1" name="share" placeholder="Введите Долю" required value="<?= ($pk) ? $this->post->share : '' ?>">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Логин:</label>
                                    <input type="text" class="form-control" name="username" placeholder="Введите Логин" required value="<?= ($pk) ? $this->post->username : '' ?>">
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

                                    <!-- <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Повторите пароль:</label>
                                            <input type="password" class="form-control" name="password2" placeholder="Введите Пароль" required>
                                        </div>
                                    </div> -->
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

                                    <!-- <div class="col-md-6">
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
}

?>
