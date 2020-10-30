<?php


function UserForm($status = null, $pk=null){
    global $db, $PERSONAL;
    $table = 'users';
    $form_name = 'UserForm';
    $redirect = '../index.php';


    unset($_SESSION['form_name']);
    $_SESSION['form_name'] = $form_name;

    if($status){

        if($pk and $_POST){
            // prit($_POST);
            unset($_POST['id']);
            if ($_POST['password'] != null and $_POST['password2'] != null) {
                prit($_POST);
                if(!($_POST['password'] === $_POST['password2'])){
                    $_SESSION['message'] = '
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        Пароли не совпадают
                    </div>
                    ';
                    $_SESSION['form'] = $_POST;
                    $_SESSION['form']['id'] = $pk;
                    header("location: $redirect");
                }else{
                    $_POST['passwd'] = sha1($_POST['password']);
                    unset($_POST['password']);
                    unset($_POST['password2']);
                    $sql = "UPDATE $table SET username=:username, first_name=:first_name, last_name=:last_name, father_name=:father_name, user_level=:user_level, password=:passwd WHERE id = $pk";
                }
        
            }else {
                unset($_POST['password']);
                unset($_POST['password2']);
                $sql = "UPDATE $table SET username=:username, first_name=:first_name, last_name=:last_name, father_name=:father_name, user_level=:user_level WHERE id = $pk";
            }
            $stm = $db->prepare($sql)->execute($_POST);
            if($stm){
                $_SESSION['message'] = '
                    <div class="alert alert-primary" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        Изменения внесены! 
                    </div>
                    ';
                header("location: $redirect");
            }

        }elseif(!$pk and $_POST){
    
            $use = $_POST['username'];
            $stmt = $db->query("SELECT * from $table where username = '$use'")->fetch(PDO::FETCH_OBJ);
            if ($stmt) {
                $_SESSION['message'] = '
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                    Пользователь с таким логином существует!
                </div>
                ';
                $_SESSION['form'] = $_POST;
                header("location: $redirect");
            }elseif(!($_POST['password'] === $_POST['password2'])){
                $_SESSION['message'] = '
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                    Пароли не совпадают
                </div>
                ';
                $_SESSION['form'] = $_POST;
                header("location: $redirect");
            }else{
                $_POST['passwd'] = sha1($_POST['password']);
                unset($_POST['password']);
                unset($_POST['password2']);
    
                $sql = "INSERT INTO $table (username, password, first_name, last_name, father_name, user_level) VALUES (:username, :passwd, :first_name, :last_name, :father_name, :user_level)";
                $stm = $db->prepare($sql)->execute($_POST);
                if($stm){
                    $_SESSION['message'] = '
                    <div class="alert alert-primary" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        Успешно
                    </div>
                    ';
                    header("location: $redirect");
                }else{
                    $_SESSION['message'] = '
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        Ошибка
                    </div>
                    ';
                    header("location: $redirect");
                }
            }
    
        }

    }else{
        if($_SESSION['message']){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        if($pk){
            $stmt = $db->query("SELECT * from $table where id = '$pk'")->fetch(PDO::FETCH_ASSOC);
            if ($stmt) {
                $_SESSION['form'] = $stmt;
                header("location: $redirect");
            }else{
                header('location: ../error/404.php');
            }
        }else{
                if($_SESSION['form']['id']){
                    ?>
                    <form method="post" action="model/update.php">
                    <?php
                }else{
                    ?>
                    <form method="post" action="model/create.php">
                    <?php
                }
            ?>
                <div class="row">

                    <div class="col-md-6">
                        <fieldset>

                            <legend class="font-weight-semibold"><i class="icon-user mr-2"></i> Персональные данные</legend>
                            <?php
                                if($_SESSION['form']['id']){
                                    ?>
                                    <input type="hidden" name="id" value="<?= $_SESSION['form']['id']?>">
                                    <?php
                                }
                            ?>
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

                                <?php
                                    if(!$_SESSION['form']['id']){
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

            </form>
            <?php
            unset($_SESSION['form']);
        }
    }

};


function BadForm($status = null, $pk=null){
    global $db, $FLOOR;
    $table = 'bads';
    $form_name = 'BadForm';
    $redirect = '../inventory.php';


    unset($_SESSION['form_name']);
    $_SESSION['form_name'] = $form_name;

    if($status){

        if($pk and $_POST){
            unset($_POST['id']);
            $sql = "UPDATE $table SET floor=:floor, ward=:ward, num=:num, category=:category WHERE id = $pk";
            $stm = $db->prepare($sql)->execute($_POST);
            if($stm){
                $_SESSION['message'] = '
                    <div class="alert alert-primary" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        Изменения внесены! 
                    </div>
                    ';
                    header("location: $redirect");
            }

        }elseif(!$pk and $_POST){
            $flor = $_POST['floor'];
            $ward = $_POST['ward'];
            $num = $_POST['num'];
            $stmt = $db->query("SELECT * from $table where floor='$flor' and ward = '$ward' and num='$num'")->fetch(PDO::FETCH_OBJ);
            if ($stmt) {
                $_SESSION['message'] = '
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                    Такая койка уже существует!
                </div>
                ';
                $_SESSION['form'] = $_POST;
                header("location: $redirect");
            }else{
                // prit($_POST);
    
                $sql = "INSERT INTO $table (floor, ward, num, category) VALUES (:floor, :ward, :num, :category)";
                $stm = $db->prepare($sql)->execute($_POST);
                if($stm){
                    $_SESSION['message'] = '
                    <div class="alert alert-primary" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        Успешно
                    </div>
                    ';
                    header("location: $redirect");
                }else{
                    $_SESSION['message'] = '
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        Ошибка
                    </div>
                    ';
                    header("location: $redirect");
                }
            }
    
        }

    }else{
        if($_SESSION['message']){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        if($pk){
            $stmt = $db->query("SELECT * from $table where id = '$pk'")->fetch(PDO::FETCH_ASSOC);
            if ($stmt) {
                $_SESSION['form'] = $stmt;
                header("location: $redirect");
            }else{
                header('location: ../error/404.php');
            }
        }else{
                if($_SESSION['form']['id']){
                    ?>
                    <form method="post" action="model/update.php">
                    <?php
                }else{
                    ?>
                    <form method="post" action="model/create.php">
                    <?php
                }
            ?>
                <div class="row">

                    <div class="col-md-6">
                        
                        <fieldset>
                            <?php
                                if($_SESSION['form']['id']){
                                    ?>
                                    <input type="hidden" name="id" value="<?= $_SESSION['form']['id']?>">
                                    <?php
                                }
                            ?>
                            <div class="form-group">
                                <label>Выбирите этаж:</label>
                                <select data-placeholder="Выбрать этаж" name="floor" class="form-control form-control-select2" required data-fouc>
                                    <option></option>
                                    <?php
                                    foreach ($FLOOR as $key => $value) {
                                        ?><option value="<?= $key ?>"<?php if($key ==$_SESSION['form']['floor']){echo'selected';} ?>><?= $value ?></option><?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Палата:</label>
                                <input type="text" class="form-control" name="ward" placeholder="Введите кабинет" required value="<?= $_SESSION['form']['ward']?>">
                            </div>

                            <div class="form-group">
                                <label>Номер:</label>
                                <input type="text" class="form-control" name="num" placeholder="Введите номер" required value="<?= $_SESSION['form']['num']?>">
                            </div>

                            <div class="form-group">
                                <label>Тип:</label>
                                <select data-placeholder="Выбрать этаж" name="category" class="form-control form-control-select2" required data-fouc>
                                    <option></option>
                                    <option value="0">Обычная</option>
                                    <option value="1">VIP</option>
                                </select>
                            </div>


                        </fieldset>
                    </div>

                    <!-- <div class="col-md-6">
                        <fieldset>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Логин:</label>
                                        <input type="username" class="form-control" name="username" placeholder="Введите Логин" required value="<?= $_SESSION['form']['username']?>">
                                    </div>
                                </div>

                                <?php
                                    if(!$_SESSION['form']['id']){
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
                                ?>
                            </div>

                            
                        </fieldset>
                    </div> -->

                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
                </div>

            </form>
            <?php
            unset($_SESSION['form']);
        }
    }

};


?>