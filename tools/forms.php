<?php
include 'mixins.php';


function UserForm($status = null, $pk=null){
    global $db, $PERSONAL;
    $table = 'users';
    $form_name = 'UserForm';
    $redirect = '../index.php';
    $succees_message = 'Успешно';


    unset($_SESSION['form_name']);
    $_SESSION['form_name'] = $form_name;

    if($status){

        if($pk and $_POST){
            prit($_POST);
            unset($_POST['id']);
            if ($_POST['password'] and $_POST['password2']) {

                if($_POST['password'] === $_POST['password2']){
                    $_POST['password'] = sha1($_POST['password']);
                    unset($_POST['password2']);
                    $stmt = update($table, $_POST, $pk);
                }else{
                    echo "нет совпадения";
                    $_SESSION['message'] = '
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        Пароли не совпадают
                    </div>
                    ';
                    $_SESSION['form'] = $_POST;
                    $_SESSION['form']['id'] = $pk;
                    header("location: $redirect");
                    exit();
                }
        
            }else {
                unset($_POST['password']);
                unset($_POST['password2']);
                $stmt = update($table, $_POST, $pk);
            }
            
            if($stmt == 1){
                $_SESSION['message'] = '
                    <div class="alert alert-primary" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        '.$succees_message.'
                    </div>
                    ';
                header("location: $redirect");
                exit();
            }else{
                $_SESSION['message'] = '
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                    '.$stmt.'
                </div>
                ';
                header("location: $redirect");
                exit();
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
                $_POST['password'] = sha1($_POST['password']);
                unset($_POST['password2']);
    
                $stmt = insert($table, $_POST);
                if($stmt == 1){
                    $_SESSION['message'] = '
                    <div class="alert alert-primary" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        '.$succees_message.'
                    </div>
                    ';
                    header("location: $redirect");
                }else{
                    $_SESSION['message'] = '
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        '.$stmt.'
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
                exit();
            }else{
                header('location: ../error/404.php');
                exit();
            }
        }else{
            if($_SESSION['form']['id']){
                ?><form method="post" action="model/update.php"><?php
            }else{
                ?><form method="post" action="model/create.php"><?php
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
    $form_name = 'BadForm';
    $table = 'bads';
    $redirect = '../inventory.php';
    $succees_message = 'Успешно';


    unset($_SESSION['form_name']);
    $_SESSION['form_name'] = $form_name;

    if($status){

        if($pk and $_POST){
            unset($_POST['id']);
            $stmt = update($table, $_POST, $pk);
            if($stmt == 1){
                $_SESSION['message'] = '
                    <div class="alert alert-primary" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        '.$succees_message.'
                    </div>
                    ';
                    header("location: $redirect");
                    exit();
            }else{
                $_SESSION['message'] = '
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                    '.$stmt.'
                </div>
                ';
                header("location: $redirect");
                exit();
            }

        }elseif(!$pk and $_POST){

            $stmt = insert($table, $_POST);
            if($stmt == 1){
                $_SESSION['message'] = '
                <div class="alert alert-primary" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                    '.$succees_message.'
                </div>
                ';
                header("location: $redirect");
                exit();
            }else{
                $_SESSION['message'] = '
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                    '.$stmt.'
                </div>
                ';
                header("location: $redirect");
                exit();
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
                exit();
            }else{
                header('location: ../error/404.php');
                exit();
            }
        }else{
            if($_SESSION['form']['id']){
                ?><form method="post" action="model/update.php"><?php
            }else{
                ?><form method="post" action="model/create.php"><?php
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

function PlanetForm($status = null, $pk=null){
    global $db;
    $form_name = 'PlanetForm';
    $table = 'planets';
    $redirect = '../test.php';
    $succees_message = 'Успешно';

    /* --------------------------- */

    unset($_SESSION['form_name']);
    $_SESSION['form_name'] = $form_name;

    if($status){

        if($pk and $_POST){
            unset($_POST['id']);
            $stmt = update($table, $_POST, $pk);
            if($stmt == 1){
                $_SESSION['message'] = '
                    <div class="alert alert-primary" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        '.$succees_message.'
                    </div>
                    ';
                    header("location: $redirect");
                    exit();
            }else{
                $_SESSION['message'] = '
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                    '.$stmt.'
                </div>
                ';
                header("location: $redirect");
                exit();
            }

        }elseif(!$pk and $_POST){

            $stmt = insert($table, $_POST);
            if($stmt == 1){
                $_SESSION['message'] = '
                <div class="alert alert-primary" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                    '.$succees_message.'
                </div>
                ';
                header("location: $redirect");
                exit();
            }else{
                $_SESSION['message'] = '
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                    '.$stmt.'
                </div>
                ';
                header("location: $redirect");
                exit();
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
                exit();
            }else{
                header('location: ../error/404.php');
                exit();
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

                    <div class="col-md-12">
                        <fieldset>
                            <?php
                                if($_SESSION['form']['id']){
                                    ?>
                                    <input type="hidden" name="id" value="<?=$_SESSION['form']['id']?>">
                                    <?php
                                }
                            ?>
                            <div class="form-group">
                                <label>name:</label>
                                <input type="text" class="form-control" name="name" placeholder="Введите кабинет" required value="<?=$_SESSION['form']['name']?>">
                            </div>

                            <div class="form-group">
                                <label>color:</label>
                                <input type="text" class="form-control" name="color" placeholder="Введите номер" required value="<?=$_SESSION['form']['color']?>">
                            </div>

                            <div class="form-group">
                                <label>tip:</label>
                                <input type="text" class="form-control" name="tip" placeholder="Введите номер" required value="<?=$_SESSION['form']['tip']?>">
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

?>