<?php


function UserForm($status = null){
    global $db, $PERSONAL;

    if($status){

        if ($_POST) {
    
            $use = $_POST['username'];
            $stmt = $db->query("SELECT * from users where username = '$use'")->fetch(PDO::FETCH_OBJ);
            if ($stmt) {
                $_SESSION['message'] = '
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                    Пользователь с таким логином существует!
                </div>
                ';
                $_SESSION['form'] = $_POST;
                header('location: ../index.php');
            }elseif(!($_POST['password'] === $_POST['password2'])){
                $_SESSION['message'] = '
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                    Пароли не совпадают
                </div>
                ';
                $_SESSION['form'] = $_POST;
                header('location: ../index.php');
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
                    header('location: ../index.php');
                }else{
                    $_SESSION['message'] = '
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        Ошибка
                    </div>
                    ';
                    header('location: ../index.php');
                }
            }
    
        }

    }else{
        if($_SESSION['message']){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="model/create.php">


            <div class="row">

                <div class="col-md-6">
                    <fieldset>

                        <legend class="font-weight-semibold"><i class="icon-user mr-2"></i> Персональные данные</legend>

                        <div class="form-group">
                            <label>Имя пользователя:</label>
                            <input type="text" class="form-control" name="first_name" placeholder="Введите имя" required value="<?= $_SESSION['form']['first_name']?>">
                        </div>

                        <div class="form-group">
                            <label>Фамилия пользователя:</label>
                            <input type="text" class="form-control" name="last_name" placeholder="Введите Фамилия" required value="<?= $_SESSION['form']['last_name']?>">
                        </div>
                        <div class="form-group">
                            <label>Отчество пользователя:</label>
                            <input type="text" class="form-control" name="father_name" placeholder="Введите Отчество" required value="<?= $_SESSION['form']['father_name']?>">
                        </div>

                        <div class="form-group">
                            <label>Выбирите роль:</label>
                            <select data-placeholder="Выбрать роль" name="user_level" class="form-control form-control-select2" required data-fouc>
                                <option></option>
                                <?php
                                foreach ($PERSONAL as $key => $value) {
                                    ?><option value="<?= $key ?>"<?php if($key ==$_SESSION['form']['user_level']){echo'selected';} ?>><?= $value ?></option><?php
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
                                    <input type="username" class="form-control" name="username" placeholder="Введите Логин" required value="<?= $_SESSION['form']['username']?>">
                                </div>
                            </div>

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
                        </div>

                        
                    </fieldset>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
            </div>

        </form>
        <?php
        unset($_SESSION['form']);
    }

};


?>