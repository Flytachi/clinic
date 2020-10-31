<?php
include 'mixins.php';


function UserForm($status = null, $pk=null){
    global $db, $PERSONAL;
    $table = 'users';
    $form_name = 'UserForm';
    $redirect = '../index.php';
    $succees_message = 'Успешно';


    /* --------------------------- */
    unset($_POST['form_name']);

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
                    $_SESSION[$form_name] = $_POST;
                    $_SESSION[$form_name]['id'] = $pk;
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
                $_SESSION[$form_name] = $_POST;
                header("location: $redirect");
            }elseif(!($_POST['password'] === $_POST['password2'])){
                $_SESSION['message'] = '
                <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                    Пароли не совпадают
                </div>
                ';
                $_SESSION[$form_name] = $_POST;
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
                $_SESSION[$form_name] = $stmt;
                header("location: $redirect");
                exit();
            }else{
                header('location: ../error/404.php');
                exit();
            }
        }else{
            if($_SESSION[$form_name]['id']){
                ?><form method="post" action="model/update.php"><?php
            }else{
                ?><form method="post" action="model/create.php"><?php
            }
            ?>
            <input type="hidden" name="form_name" value="<?= $form_name ?>">
                <div class="row">

                    <div class="col-md-6">
                        <fieldset>

                            <legend class="font-weight-semibold"><i class="icon-user mr-2"></i> Персональные данные</legend>
                            <?php
                                if($_SESSION[$form_name]['id']){
                                    ?>
                                    <input type="hidden" name="id" value="<?= $_SESSION[$form_name]['id']?>">
                                    <?php
                                }
                            ?>
                            <div class="form-group">
                                <label>Имя пользователя:</label>
                                <input type="text" class="form-control" name="first_name" placeholder="Введите имя" required value="<?= $_SESSION[$form_name]['first_name']?>">
                            </div>

                            <div class="form-group">
                                <label>Фамилия пользователя:</label>
                                <input type="text" class="form-control" name="last_name" placeholder="Введите Фамилия" required value="<?= $_SESSION[$form_name]['last_name']?>">
                            </div>
                            <div class="form-group">
                                <label>Отчество пользователя:</label>
                                <input type="text" class="form-control" name="father_name" placeholder="Введите Отчество" required value="<?= $_SESSION[$form_name]['father_name']?>">
                            </div>

                            <div class="form-group">
                                <label>Выбирите роль:</label>
                                <select data-placeholder="Выбрать роль" name="user_level" class="form-control form-control-select2" required data-fouc>
                                    <option></option>
                                    <?php
                                    foreach ($PERSONAL as $key => $value) {
                                        ?><option value="<?= $key ?>"<?php if($key ==$_SESSION[$form_name]['user_level']){echo'selected';} ?>><?= $value ?></option><?php
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
                                        <input type="number" class="form-control" step="0.1" name="share" placeholder="Введите Долю" required value="<?= $_SESSION[$form_name]['share']?>">
                                    </div>
                                </div>
                                    
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Логин:</label>
                                        <input type="text" class="form-control" name="username" placeholder="Введите Логин" required value="<?= $_SESSION[$form_name]['username']?>">
                                    </div>
                                </div>

                                <?php
                                    if(!$_SESSION[$form_name]['id']){
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
            unset($_SESSION[$form_name]);
        }
    }

};

function BadForm($status = null, $pk=null){
    global $db, $FLOOR;
    $form_name = 'BadForm';
    $table = 'bads';
    $redirect = '../inventory.php';
    $succees_message = 'Успешно';

    /* --------------------------- */
    unset($_POST['form_name']);

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
        if($pk){
            $stmt = $db->query("SELECT * from $table where id = '$pk'")->fetch(PDO::FETCH_ASSOC);
            if ($stmt) {
                $_SESSION[$form_name] = $stmt;
                header("location: $redirect");
                exit();
            }else{
                header('location: ../error/404.php');
                exit();
            }
        }else{
            if($_SESSION['message']){
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }if($_SESSION[$form_name]['id']){
                ?><form method="post" action="model/update.php"><?php
            }else{
                ?><form method="post" action="model/create.php"><?php
            }
            if($_SESSION[$form_name]['id']){
                ?>
                <input type="hidden" name="id" value="<?= $_SESSION[$form_name]['id']?>">
                <?php
            }
            prit($_SESSION);
            ?>
                <input type="hidden" name="form_name" value="<?= $form_name ?>">

                <div class="form-group">
                    <label>Выбирите этаж:</label>
                    <select data-placeholder="Выбрать этаж" name="floor" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach ($FLOOR as $key => $value) {
                            ?><option value="<?= $key ?>"<?php if($key ==$_SESSION[$form_name]['floor']){echo'selected';} ?>><?= $value ?></option><?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Палата:</label>
                    <input type="text" class="form-control" name="ward" placeholder="Введите кабинет" required value="<?= $_SESSION[$form_name]['ward']?>">
                </div>

                <div class="form-group">
                    <label>Номер:</label>
                    <input type="text" class="form-control" name="num" placeholder="Введите номер" required value="<?= $_SESSION[$form_name]['num']?>">
                </div>

                <div class="form-group">
                    <label>Тип:</label>
                    <select data-placeholder="Выбрать тип" name="category" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php 
                        foreach($db->query('SELECT * from bad_type') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>"<?php if($row['id'] == $_SESSION[$form_name]['category']){echo'selected';} ?>><?= $row['name'] ?></option>

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
            unset($_SESSION[$form_name]);
        }
    }

};

function BadTypeForm($status = null, $pk=null){
    global $db;
    $form_name = 'BadTypeForm';
    $table = 'bad_type';
    $redirect = '../inventory.php';
    $succees_message = 'Успешно';

    /* --------------------------- */
    unset($_POST['form_name']);

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
        if($pk){
            $stmt = $db->query("SELECT * from $table where id = '$pk'")->fetch(PDO::FETCH_ASSOC);
            if ($stmt) {
                $_SESSION[$form_name] = $stmt;
                header("location: $redirect");
                exit();
            }else{
                header('location: ../error/404.php');
                exit();
            }
        }else{
            if($_SESSION['message']){
                echo $_SESSION['message'];
                unset($_SESSION['message']);
            }if($_SESSION[$form_name]['id']){
                ?><form method="post" action="model/update.php"><?php
            }else{
                ?><form method="post" action="model/create.php"><?php
            }
            if($_SESSION[$form_name]['id']){
                ?>
                <input type="hidden" name="id" value="<?= $_SESSION[$form_name]['id']?>">
                <?php
            }
            ?>
                <input type="hidden" name="form_name" value="<?= $form_name ?>">
                <?php
                    if($_SESSION[$form_name]['id']){
                        ?>
                        <input type="hidden" name="id" value="<?= $_SESSION[$form_name]['id']?>">
                        <?php
                    }
                ?>
                <div class="form-group">
                    <label>Название:</label>
                    <input type="text" class="form-control" name="name" placeholder="Введите название" required value="<?= $_SESSION[$form_name]['name']?>">
                </div>

                <div class="form-group">
                    <label>Цена:</label>
                    <input type="text" class="form-control" name="price" placeholder="Введите цену" required value="<?= $_SESSION[$form_name]['price']?>">
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
                </div>

            </form>
            <?php
            unset($_SESSION[$form_name]);
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
    unset($_POST['form_name']);

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
                $_SESSION[$form_name] = $stmt;
                header("location: $redirect");
                exit();
            }else{
                header('location: ../error/404.php');
                exit();
            }
        }else{
            if($_SESSION[$form_name]['id']){
                ?>
                <form method="post" action="model/update.php">
                <?php
            }else{
                ?>
                <form method="post" action="model/create.php">
                <?php
            }
                    
            ?>
            <input type="hidden" name="form_name" value="<?= $form_name ?>">
                <div class="row">

                    <div class="col-md-12">
                        <fieldset>
                            <?php
                                if($_SESSION[$form_name]['id']){
                                    ?>
                                    <input type="hidden" name="id" value="<?=$_SESSION[$form_name]['id']?>">
                                    <?php
                                }
                            ?>
                            <div class="form-group">
                                <label>name:</label>
                                <input type="text" class="form-control" name="name" placeholder="Введите кабинет" required value="<?=$_SESSION[$form_name]['name']?>">
                            </div>

                            <div class="form-group">
                                <label>color:</label>
                                <input type="text" class="form-control" name="color" placeholder="Введите номер" required value="<?=$_SESSION[$form_name]['color']?>">
                            </div>

                            <div class="form-group">
                                <label>tip:</label>
                                <input type="text" class="form-control" name="tip" placeholder="Введите номер" required value="<?=$_SESSION[$form_name]['tip']?>">
                            </div>


                        </fieldset>
                    </div>

                    </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
                </div>

            </form>
            <?php
            unset($_SESSION[$form_name]);
        }
    }

};

?>