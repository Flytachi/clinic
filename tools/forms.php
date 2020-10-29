<?php


function UserForm(){
    global $db, $PERSONAL;
    if ($_POST) {
        // echo "<pre>";
        // var_dump($_POST);
        // echo "</pre>";
        $use = $_POST['username'];
        $stmt = $db->query("SELECT * from users where username = '$use'")->fetch(PDO::FETCH_OBJ);
        if ($stmt) {
            $_SESSION['message'] = '
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                Пользователь с таким логином существует!
            </div>
            ';
        }elseif(!($_POST['password'] === $_POST['password2'])){
            $_SESSION['message'] = '
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                Пароли не совпадают
            </div>
            ';
        }else{
            $_POST['passwd'] = sha1($_POST['password']);
            unset($_POST['password']);
            unset($_POST['password2']);

            $sql = "INSERT INTO users (username, password, first_name, last_name, father_name, user_level) VALUES (:username, :passwd, :first_name, :last_name, :father_name, :user_level)";
            $stm = $db->prepare($sql)->execute($_POST);
            if($stm){
                $_SESSION['message'] = '
                <div class="alert alert-primary" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                    Успешно
                </div>
                ';
                unset($_POST);
            }else{
                $_SESSION['message'] = '
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                    Ошибка
                </div>
                ';
            }
        }
    }
    if($_SESSION['message']){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
    ?>
    <form method="post" action="">


        <div class="row">

            <div class="col-md-6">
                <fieldset>

                    <legend class="font-weight-semibold"><i class="icon-user mr-2"></i> Персональные данные</legend>

                    <div class="form-group">
                        <label>Имя пользователя:</label>
                        <input type="text" class="form-control" name="first_name" placeholder="Введите имя" value="<?= $_POST['first_name']?>">
                    </div>

                    <div class="form-group">
                        <label>Фамилия пользователя:</label>
                        <input type="text" class="form-control" name="last_name" placeholder="Введите Фамилия" value="<?= $_POST['last_name']?>">
                    </div>
                    <div class="form-group">
                        <label>Отчество пользователя:</label>
                        <input type="text" class="form-control" name="father_name" placeholder="Введите Отчество" value="<?= $_POST['father_name']?>">
                    </div>

                    <div class="form-group">
                        <label>Выбирите роль:</label>
                        <select data-placeholder="Выбрать роль" name="user_level" class="form-control form-control-select2" data-fouc>
                            <option></option>
                            <?php
                            foreach ($PERSONAL as $key => $value) {
                                ?><option value="<?= $key ?>"><?= $value ?></option><?php
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
                                <label>Логин:</label>
                                <input type="username" class="form-control" name="username" placeholder="Введите Логин" value="<?= $_POST['username']?>">
                            </div>
                        </div>

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
                    </div>

                    
                </fieldset>
            </div>

        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
        </div>

    </form>

    <?php
};
?>