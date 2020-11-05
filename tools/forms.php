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
                                <select data-placeholder="Выбрать роль" name="user_level" id="user_level" class="form-control form-control-select2" required data-fouc>
                                    <option></option>
                                    <?php
                                    foreach ($PERSONAL as $key => $value) {
                                        ?>
                                        <option value="<?= $key ?>"<?= ($_SESSION[$form_name]['user_level'] == $key) ? 'selected': '' ?>><?= $value ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Отдел:</label>
                                <select data-placeholder="Выбрать категорию" name="division_id" id="division_id" class="form-control form-control-select2" required data-fouc>
                                    <option></option>
                                    <?php
                                    foreach($db->query('SELECT * from division') as $row) {
                                        ?>
                                        <option value="<?= $row['id'] ?>" data-chained="<?= $row['level'] ?>" <?= ($_SESSION[$form_name]['division_id'] == $row['id']) ? 'selected': '' ?>><?= $row['title'] ?></option>
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

            <script type="text/javascript">
                $(function(){
                    $("#division_id").chained("#user_level");
                });
            </script>
            <?php
            unset($_SESSION[$form_name]);
        }
    }

};


function BedForm($status = null, $pk=null){
    global $db, $FLOOR;
    $form_name = 'BedForm';
    $table = 'beds';
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

                <div class="form-group">
                    <label>Выбирите этаж:</label>
                    <select data-placeholder="Выбрать этаж" name="floor" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach ($FLOOR as $key => $value) {
                            ?><option value="<?= $key ?>"<?= ($_SESSION[$form_name]['floor'] == $key) ? 'selected': '' ?>><?= $value ?></option><?php
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
                    <select data-placeholder="Выбрать тип" name="types" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from bed_type') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>"<?= ($_SESSION[$form_name]['types'] == $row['id']) ? 'selected' : '' ?>><?= $row['name'] ?></option>
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


function BedTypeForm($status = null, $pk=null){
    global $db;
    $form_name = 'BedTypeForm';
    $table = 'bed_type';
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


function ServiceGroupForm($status = null, $pk=null){
    global $db;
    $form_name = 'ServiceGroupForm';
    $table = 'service_group';
    $redirect = '../service_group.php';
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

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
                </div>

            </form>
            <?php
            unset($_SESSION[$form_name]);
        }
    }

};


function ServiceCategoryForm($status = null, $pk=null){
    global $db;
    $form_name = 'ServiceCategoryForm';
    $table = 'service_category';
    $redirect = '../service_category.php';
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
                    <label>Группа:</label>
                    <select data-placeholder="Выбрать группу" name="group_id" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from service_group') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>"<?= ($_SESSION[$form_name]['group_id'] == $row['id']) ? 'selected': '' ?>><?= $row['name'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Название:</label>
                    <input type="text" class="form-control" name="name" placeholder="Введите название" required value="<?= $_SESSION[$form_name]['name']?>">
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


function ServiceForm($status = null, $pk=null){
    global $db, $PERSONAL;
    $form_name = 'ServiceForm';
    $table = 'service';
    $redirect = '../service.php';
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
                    <label>Группа:</label>
                    <select data-placeholder="Выбрать группу" name="group_id" id="group_id" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from service_group') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>"<?= ($_SESSION[$form_name]['group_id'] == $row['id']) ? 'selected': '' ?>><?= $row['name'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Категория:</label>
                    <select data-placeholder="Выбрать категорию" name="category_id" id="category_id" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from service_category') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['group_id'] ?>" <?= ($_SESSION[$form_name]['category_id'] == $row['id']) ? 'selected': '' ?>><?= $row['name'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Роль:</label>
                    <select data-placeholder="Выбрать роль" name="user_level" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach ($PERSONAL as $key => $value) {
                            ?><option value="<?= $key ?>"<?= ($_SESSION[$form_name]['user_level'] == $key) ? 'selected': '' ?>><?= $value ?></option><?php
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Название:</label>
                    <input type="text" class="form-control" name="name" placeholder="Введите название" required value="<?= $_SESSION[$form_name]['name']?>">
                </div>

                <div class="form-group">
                    <label>Цена:</label>
                    <input type="number" class="form-control" step="0.1" name="price" placeholder="Введите цену" required value="<?= $_SESSION[$form_name]['price']?>">
                </div>

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
                </div>

            </form>
            <script type="text/javascript">
                $(function(){
                    $("#category_id").chained("#group_id");
                });
            </script>
            <?php
            unset($_SESSION[$form_name]);
        }
    }

};


function PatientRegistration($status = null, $pk=null){
    global $db, $PERSONAL;
    $table = 'users';
    $form_name = 'PatientRegistration';
    $redirect = '../index.php';
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

            // $use = $_POST['username'];
            // $stmt = $db->query("SELECT * from $table where username = '$use'")->fetch(PDO::FETCH_OBJ);
            // if ($stmt) {
            //     $_SESSION['message'] = '
            //     <div class="alert alert-danger" role="alert">
            //         <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            //         Пользователь с таким логином существует!
            //     </div>
            //     ';
            //     $_SESSION[$form_name] = $_POST;
            //     header("location: $redirect");
            // }elseif(!($_POST['password'] === $_POST['password2'])){
            //     $_SESSION['message'] = '
            //     <div class="alert alert-danger" role="alert">
            //         <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            //         Пароли не совпадают
            //     </div>
            //     ';
            //     $_SESSION[$form_name] = $_POST;
            //     header("location: $redirect");
            // }else{
                // $_POST['password'] = sha1($_POST['password']);
                // unset($_POST['password2']);

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
            // }

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
            <input type="hidden" name="user_level" value="15">
            <input type="hidden" name="form_name" value="<?= $form_name ?>">
                <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Добавить пациента</legend>
                <div class="row">
                    <div class="col-md-4">
                        <fieldset>

                            <div class="form-group">
                                <label>Имя пациента:</label>
                                <input type="text" name="first_name" class="form-control" placeholder="Введите имя" value="<?= $_SESSION[$form_name]['first_name']?>">
                            </div>

                            <div class="form-group">
                                <label>Фамилия пациента:</label>
                                <input type="text" name="last_name" class="form-control" placeholder="Введите Фамилия" value="<?= $_SESSION[$form_name]['last_name']?>">
                            </div>
                            <div class="form-group">
                                <label>Отчество пациента:</label>
                                <input type="text" name="father_name" class="form-control" placeholder="Введите Отчество" value="<?= $_SESSION[$form_name]['father_name']?>">
                            </div>
                            <div class="form-group">
                                <label>Дата рождение:</label>
                              <div class="input-group">
                                <span class="input-group-prepend">
                                 <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                 </span>
                                <input type="date" name="dateBith" class="form-control daterange-single" value="<?= $_SESSION[$form_name]['dateBith']?>">
                            </div>
                            </div>

                            <div class="form-group">
                               <label class="d-block font-weight-semibold">Пол</label>

                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="radio" name="gender" <?php if(1 == $_SESSION[$form_name]['gender']){echo "checked";} ?> value="1" class="form-check-input" name="unstyled-radio-left" checked>
                                            Мужчина
                                        </label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                            <input type="radio" name="gender" <?php if(0 == $_SESSION[$form_name]['gender']){echo "checked";} ?> value="0" class="form-check-input" name="unstyled-radio-left">
                                            Женщина
                                        </label>
                                    </div>
                            </div>

                        </fieldset>
                    </div>

                    <div class="col-md-8">
                        <fieldset>

                            <div class="row">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Выбирите регион:</label>
                                            <select data-placeholder="Выбрать регион" name="region" class="form-control form-control-select2" data-fouc>
                                                <option><?= $_SESSION[$form_name]['region']?></option>
                                                <optgroup label="Бухоро вилояти">
                                                    <option value="Бухоро">Бухоро ш</option>
                                                    <option value="Жондор">Жондор</option>
                                                    <option value="Вобкент">Вобкент</option>
                                                    <option value="Шофиркон">Шофиркон</option>
                                                    <option value="Гиждувон">Гиждувон</option>
                                                    <option value="Бухоро">Бухоро т</option>
                                                    <option value="Когон">Когон т</option>
                                                    <option value="Когон">Когон ш</option>
                                                    <option value="Қаравулбозор">Қаравулбозор</option>
                                                    <option value="Қоракўл">Қоракўл</option>
                                                    <option value="Олот">Олот</option>
                                                    <option value="Ромитан">Ромитан</option>
                                                </optgroup>
                                                <optgroup label="Тошкент вилояти">
                                                    <option value="Чилонзор">Чилонзор</option>
                                                    <option value="Миробод">Миробод</option>
                                                    <option value="Олмазор">Олмазор</option>
                                                    <option value="Юнусобод">Юнусобод</option>
                                                </optgroup>
                                                <optgroup label="Наманган вилояти">
                                                    <option value="Наманган">Наманган</option>
                                                    <option value="Наманган">Наманган</option>
                                                    <option value="Наманган">Наманган</option>
                                                </optgroup>
                                                <optgroup label="Фарғона вилояти">
                                                    <option value="Фарғона">Фарғона</option>
                                                    <option value="Фарғона">Фарғона</option>
                                                    <option value="Фарғона">Фарғона</option>
                                                </optgroup>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Адрес проживание:</label>
                                        <input type="text" name="residenceAddress" class="form-control" placeholder="Введите адрес" value="<?= $_SESSION[$form_name]['residenceAddress']?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Адрес по прописке:</label>
                                        <input type="text" name="registrationAddress" class="form-control" placeholder="Введите адрес" value="<?= $_SESSION[$form_name]['registrationAddress']?>">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Серия и номер паспорта:</label>
                                        <input type="text" name="passport" placeholder="Серия паспорта" class="form-control" value="<?= $_SESSION[$form_name]['passport']?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Место работы:</label>
                                        <input type="text" name="placeWork" placeholder="Введите место работ" class="form-control" value="<?= $_SESSION[$form_name]['placeWork']?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Должность:</label>
                                        <input type="text" name="position" placeholder="Введите должность" class="form-control" value="<?= $_SESSION[$form_name]['position']?>">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Телефон номер:</label>
                                        <input type="number" name="numberPhone" placeholder="+9989" class="form-control" value="<?= $_SESSION[$form_name]['numberPhone']?>">
                                    </div>
                                </div>


                                <!-- <div class="form-group col-12">
                                    <label>Добавить фото:</label>
                                    <input type="file" class="form-control-uniform-custom">
                                </div> -->

                        </fieldset>
                    </div>

                    <!-- <div class="col-md-3">
                        <div class="form-group">
                            <label>ID:</label>
                            <input type="id" placeholder="ID номер" class="form-control">
                        </div>
                    </div> -->
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


function StorageTypeForm($status = null, $pk=null){
    global $db;
    $form_name = 'StorageTypeForm';
    $table = 'storage_type';
    $redirect = '../storage.php';
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

                <div class="text-right">
                    <button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
                </div>

            </form>
            <?php
            unset($_SESSION[$form_name]);
        }
    }

};


function DivisionForm($status = null, $pk=null){
    global $db, $PERSONAL;
    $form_name = 'DivisionForm';
    $table = 'division';
    $redirect = '../division.php';
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
                    <label>Выбирите роль:</label>
                    <select data-placeholder="Выбрать роль" name="level" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach ($PERSONAL as $key => $value) {
                            ?>
                            <option value="<?= $key ?>"<?= ($_SESSION[$form_name]['level'] == $key) ? 'selected': '' ?>><?= $value ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Название отдела:</label>
                    <input type="text" class="form-control" name="title" placeholder="Введите название отдела" required value="<?= $_SESSION[$form_name]['title']?>">
                </div>

                <div class="form-group">
                    <label>Название специолиста:</label>
                    <input type="text" class="form-control" name="name" placeholder="Введите название специолиста" required value="<?= $_SESSION[$form_name]['name']?>">
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
