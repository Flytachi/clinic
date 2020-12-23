<?php

include 'functions/model.php';


class UserModel extends Model
{
    public $table = 'users';

    public function form($pk = null)
    {
        global $db, $PERSONAL;
        if($pk){
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
                                if(!$pk){
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

class VisitModel extends Model
{
    public $table = 'visit';
    public $table1 = 'users';
    public $table2 = 'beds';

    public function form_out($pk = null)
    {
        global $db;
        if($_SESSION['message']){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="0">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Пациент:</label>
                    <select data-placeholder="Выбрать пациента" name="user_id" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                            foreach ($db->query('SELECT * FROM users WHERE user_level = 15 AND status IS NULL') as $row) {
                                ?>
                                <option value="<?= $row['id'] ?>"><?= addZero($row['id']) ?> - <?= get_full_name($row['id']) ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Отдел:</label>
                    <select data-placeholder="Выберите отдел" name="division_id" id="division_id" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query("SELECT * from division WHERE level = 5 OR level = 6 OR level = 10 AND (assist IS NULL OR assist = 1)") as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Выберите специалиста:</label>
                    <select data-placeholder="Выберите специалиста" name="parent_id" id="parent_id" class="form-control form-control-select2" data-fouc required>
                        <?php
                        foreach($db->query('SELECT * from users WHERE user_level = 5 OR user_level = 6 OR user_level = 10') as $row) {
                            ?>
                            <option class="d-flex justify-content-between" value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>"><?= get_full_name($row['id']) ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Услуга:</label>
                    <select data-placeholder="Выберите услугу" name="service_id" id="service_id" class="form-control select-price" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from service WHERE user_level = 5 OR user_level = 6 OR user_level = 10') as $row) {
                            ?>
                            <option class="text-danger" value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>" data-price="<?= $row['price'] ?>"><?= $row['name'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <script type="text/javascript">
            $(function(){
                $("#parent_id").chained("#division_id");
                $("#service_id").chained("#division_id");
            });
        </script>
        <?php
    }

    public function form_sta($pk = null)
    {
        global $db, $FLOOR;
        if($_SESSION['message']){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="direction" value="1">
            <input type="hidden" name="status" value="1">
            <input type="hidden" name="route_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="form-group row">

                <div class="col-md-3">
                    <label>Пациет:</label>
                    <select data-placeholder="Выбрать пациета" name="user_id" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                            foreach ($db->query('SELECT * FROM users WHERE user_level = 15 AND status IS NULL') as $row) {
                                ?>
                                <option value="<?= $row['id'] ?>"><?= addZero($row['id']) ?> - <?= get_full_name($row['id']) ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Этаж:</label>
                    <select data-placeholder="Выбрать этаж" name="" id="floor" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach($FLOOR as $key => $value) {
                            ?>
                            <option value="<?= $key ?>"><?= $value ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Палата:</label>
                    <select data-placeholder="Выбрать палату" name="" id="ward" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from wards ') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['floor'] ?>"><?= $row['ward'] ?> палата</option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Койка:</label>
                    <select data-placeholder="Выбрать койку" name="bed" id="bed" class="form-control select-price" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT bd.*, bdt.price, bdt.name from beds bd LEFT JOIN bed_type bdt ON(bd.types=bdt.id)') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['ward_id'] ?>" data-price="<?= $row['price'] ?>" data-name="<?= $row['name'] ?>" <?= ($row['user_id']) ? 'disabled' : '' ?>><?= $row['bed'] ?> койка</option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Отдел:</label>
                    <select data-placeholder="Выберите отдел" name="division_id" id="division_id" class="form-control form-control-select2" required data-fouc>
                        <option></option>
                        <?php
                        foreach($db->query('SELECT * from division WHERE level = 5') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>"><?= $row['title'] ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <label>Специалиста:</label>
                    <select data-placeholder="Выберите специалиста" name="parent_id" id="parent_id" class="form-control form-control-select2" required data-fouc>
                        <?php
                        foreach($db->query('SELECT * from users WHERE user_level = 5') as $row) {
                            ?>
                            <option value="<?= $row['id'] ?>" data-chained="<?= $row['division_id'] ?>"><?= get_full_name($row['id']) ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>

            </div>

            <div class="text-right">
                <button type="submit" onclick="submitAlert()" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <script type="text/javascript">
            $(function(){
                $("#ward").chained("#floor");
                $("#bed").chained("#ward");
                $("#parent_id").chained("#division_id");
            });
            function submitAlert() {
                let obj = JSON.stringify({ type : 'alert_new_patient',  id : $("#parent_id").val(), message: "У вас новый стационарный пациент!" });
                conn.send(obj);
            }
        </script>
        <?php
    }

    public function form_oper($pk = null)
    {
        global $db, $patient;
        if($_SESSION['message']){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $patient->visit_id ?>">

            <div class="form-group row">

                <div class="col-md-4">
                    <label>Дата:</label>
                    <input type="date" class="form-control" name="oper_date">
                </div>

                <div class="col-md-4">
                    <label>Время:</label>
                    <input type="time" class="form-control" name="time">
                </div>

                <div class="col-md-4">
                    <div class="text-right mt-4">
                        <button type="submit" class="btn btn-outline-info btn-sm">Назначить операцию</button>
                    </div>
                </div>

            </div>

        </form>
        <?php
    }

    public function save()
    {
        global $db;
        if($this->clean()){
            if ($this->post['direction']) {
                $object1 = Mixin\update($this->table2, array('user_id' => $this->post['user_id']), $this->post['bed']);
                if (!intval($object1)){
                    $this->error($object1);
                }
                $this->post['bed_id'] = $this->post['bed'];
                unset($this->post['bed']);
                $this->post['service_id'] = 1;
            }
            $this->post['grant_id'] = $this->post['parent_id'];
            $object = Mixin\insert($this->table, $this->post);
            if (intval($object)){
                // Обновление статуса у пациента
                $object1 = Mixin\update($this->table1, array('status' => True), $this->post['user_id']);
                if (intval($object1)){
                    $this->success();
                }else {
                    $this->error($object1);
                }
            }else{
                $this->error($object);
            }

        }
    }

    public function clean()
    {
        global $db;
        if ($this->post['division_id']) {
            $stat = $db->query("SELECT * FROM division WHERE id={$this->post['division_id']} AND level=6")->fetch();
            if ($stat) {
                $this->post['laboratory'] = True;
            }
        }
        if ($this->post['oper_date']) {
            $this->post['oper_date'] .= " ".$this->post['time'];
            unset($this->post['time']);
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function delete(int $pk)
    {
        global $db;
        // Нахождение id визита
        $object_sel = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(PDO::FETCH_OBJ);
        $object = Mixin\delete($this->table, $pk);
        if ($object) {
            $status = $db->query("SELECT * FROM $this->table WHERE user_id = $object_sel->user_id AND priced_date IS NULL AND completed IS NULL")->rowCount();
            if(!$status){
                Mixin\update($this->table1, array('status' => null), $object_sel->user_id);
               $this->success(2);
            }else {
                $this->success(1);
            }
        } else {
            $this->error($object, 1);
        }

    }

    public function success($stat=null)
    {
        if ($stat == 2) {
            echo '<div class="alert alert-info" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                Успешно
            </div>';
        }elseif ($stat == 1) {
            echo 1;
        }else {
            $_SESSION['message'] = '
            <div class="alert alert-info" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                Успешно
            </div>
            ';
            render();
        }
    }

    public function error($message, $stat=null)
    {
        if ($stat) {
            echo '
            <div class="alert bg-danger alert-styled-left alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                <span class="font-weight-semibold"> '.$message.'</span>
            </div>
            ';
        } else {
            $_SESSION['message'] = '
            <div class="alert bg-danger alert-styled-left alert-dismissible">
                <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                <span class="font-weight-semibold"> '.$message.'</span>
            </div>
            ';
            render();
        }
    }
}

class VisitPriceModel extends Model
{
    public $table = 'visit_price';
    public $table1 = 'visit';

    public function form($pk = null)
    {
        global $db;
        ?>
        <form method="post" action="<?= add_url() ?>">

            <div class="modal-body">
                <input type="hidden" name="model" value="<?= __CLASS__ ?>">
                <input type="hidden" name="pricer_id" value="<?= $_SESSION['session_id'] ?>">
                <input type="hidden" name="user_id" id="user_amb_id">

                <div class="form-group row">

                    <div class="col-md-9">
                        <label class="col-form-label">Сумма к оплате:</label>
                        <input type="text" class="form-control" id="total_price" disabled>
                    </div>
                    <div class="col-md-3">
                        <label class="col-form-label">Скидка:</label>
                        <div class="form-group-feedback form-group-feedback-right">
                            <input type="text" class="form-control" name="sale" placeholder="">
                            <div class="form-control-feedback text-success">
                                <span style="font-size: 20px;">%</span>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Наличный</label>
					<div class="col-md-9">
						<div class="input-group">
							<input type="number" name="price_cash" id="input_chek_1" step="0.5" class="form-control" placeholder="расчет" disabled>
                            <span class="input-group-prepend ml-5">
								<span class="input-group-text">
									<input type="checkbox" class="form-control-switchery" data-fouc id="chek_1" onchange="Checkert(this)">
								</span>
							</span>
						</div>
					</div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Пластиковый</label>
					<div class="col-md-9">
						<div class="input-group">
							<input type="number" name="price_card" id="input_chek_2" step="0.5" class="form-control" placeholder="расчет" disabled>
                            <span class="input-group-prepend ml-5">
								<span class="input-group-text">
									<input type="checkbox" class="form-control-switchery" data-fouc id="chek_2" onchange="Checkert(this)">
								</span>
							</span>
						</div>
					</div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Перечисление</label>
					<div class="col-md-9">
						<div class="input-group">
							<input type="number" name="price_transfer" id="input_chek_3" step="0.5" class="form-control" placeholder="расчет" disabled>
                            <span class="input-group-prepend ml-5">
								<span class="input-group-text">
									<input type="checkbox" class="form-control-switchery" data-fouc id="chek_3" onchange="Checkert(this)">
								</span>
							</span>
						</div>
					</div>
                </div>

            </div>

    		<div class="modal-footer">
    			<button type="button" class="btn btn-link" data-dismiss="modal">Отмена</button>
                <button type="submit" onclick="submitAlert()" class="btn btn-outline-info btn-sm">Печать</button>
                <!-- <button type="button" onclick="checkBody('<?= viv('prints/check') ?>?id='+$('#user_amb_id').val())" class="btn btn-outline-info"><i class="icon-printer2"></i> Печать</button> -->
    		</div>

        </form>
        <script type="text/javascript">
            function checkBody(urls) {
                window.location = urls;
                // $.ajax({
                // 	type: "GET",
                // 	url: urls,
                // 	success: function (result) {
                //         checkPrint(result);
                // 	},
                // });
            }

            function Checkert(event) {
                var input = $('#input_'+event.id);
                if(!input.prop('disabled')){
                    input.attr("disabled", "disabled");
                    Downsum(input);
                }else {
                    input.removeAttr("disabled");
                    Upsum(input);
                }
            }
            function submitAlert() {
                var parent_id =  Array.prototype.slice.call(document.querySelectorAll('.parent_class'));
                parent_id.forEach(function(events) {
                    let obj = JSON.stringify({ type : 'alert_new_patient',  id : $(events).val(), message: "У вас новый амбулаторный пациент!" });
                    conn.send(obj);
                });
            }
        </script>
        <?php
    }

    public function clean()
    {
        global $db;
        $this->user_pk = $this->post['user_id'];
        unset($this->post['user_id']);
        $tot = $db->query("SELECT SUM(sc.price) 'total_price' FROM $this->table1 vs LEFT JOIN service sc ON(vs.service_id=sc.id) WHERE priced_date IS NULL AND user_id = $this->user_pk")->fetch();
        $result = $tot['total_price'] - ($this->post['price_cash'] + $this->post['price_card'] + $this->post['price_transfer']);
        if ($result < 0) {
            $this->error("Есть остаток ".$result);
        }elseif ($result > 0) {
            $this->error("Недостаточно средств! ". $result);
        }else {
            $this->post = Mixin\clean_form($this->post);
            $this->post = Mixin\to_null($this->post);
            return True;
        }
    }

    public function price()
    {
        global $db;
        // parad("Услуги", $db->query("SELECT vs.id, sc.price FROM $this->table1 vs LEFT JOIN service sc ON(vs.service_id=sc.id) WHERE priced_date IS NULL AND user_id = $this->user_pk ORDER BY sc.price")->fetchAll());
        foreach ($db->query("SELECT vs.id, sc.price, sc.name FROM $this->table1 vs LEFT JOIN service sc ON(vs.service_id=sc.id) WHERE vs.priced_date IS NULL AND vs.user_id = $this->user_pk ORDER BY sc.price") as $row) {
            $post = array(
                'pricer_id' => $this->post['pricer_id'],
                'sale' => $this->post['sale'],
            );

            if ($this->post['price_cash'])
            {
                if ($this->post['price_cash'] >= $row['price']) {
                    $this->post['price_cash'] -= $row['price'];
                    $post['price_cash'] = $row['price'];
                }else {
                    $post['price_cash'] = $this->post['price_cash'];
                    $this->post['price_cash'] = 0;
                    $temp = $row['price'] - $post['price_cash'];
                    if ($this->post['price_card'] >= $temp) {
                        $this->post['price_card'] -= $temp;
                        $post['price_card'] = $temp;
                    }else {
                        $post['price_card'] = $this->post['price_card'];
                        $this->post['price_card'] = 0;
                        $temp = $temp - $post['price_card'];
                        if ($this->post['price_transfer'] >= $temp) {
                            $this->post['price_transfer'] -= $temp;
                            $post['price_transfer'] = $temp;
                        }else {
                            $this->error("Ошибка в price transfer");
                        }
                    }
                }
            }
            elseif ($this->post['price_card'])
            {
                if ($this->post['price_card'] >= $row['price']) {
                    $this->post['price_card'] -= $row['price'];
                    $post['price_card'] = $row['price'];
                }else {
                    $post['price_card'] = $this->post['price_card'];
                    $this->post['price_card'] = 0;
                    $temp = $row['price'] - $post['price_card'];
                    if ($this->post['price_transfer'] >= $temp) {
                        $this->post['price_transfer'] -= $temp;
                        $post['price_transfer'] = $temp;
                    }else {
                        $this->error("Ошибка в price transfer");
                    }
                }
            }
            else
            {
                if ($this->post['price_transfer'] >= $row['price']) {
                    $this->post['price_transfer'] -= $row['price'];
                    $post['price_transfer'] = $row['price'];
                }else {
                    $this->error("Ошибка в price transfer");
                }
            }
            $post['item_id'] = $row['id'];
            $post['item_type'] = 1;
            $post['item_cost'] = $row['price'];
            $post['item_name'] = $row['name'];
            $object = Mixin\update($this->table1, array('status' => 1, 'priced_date' => date('Y-m-d H:i:s')), $row['id']);
            if(intval($object)){
                $post['visit_id'] = $row['id'];
                $object1 = Mixin\insert($this->table, $post);
                if (!intval($object1)){
                    $this->error($object1);
                }
            }else {
                $this->error($object);
            }

        }
    }

    public function save()
    {
        global $db;
        if($this->clean()){
            $this->price();
            $this->success();
        }
    }

    public function success()
    {
        $_SESSION['message'] = '
        <div class="alert alert-info" role="alert">
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

class VisitInspectionModel extends Model
{
    public $table = 'visit_inspection';

    public function form($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="modal-body">

                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <label class="col-form-label">Описание:</label>
                        <textarea rows="8" cols="3" name="description" class="form-control" placeholder="Описание"></textarea>
                    </div>

                    <div class="col-md-10 offset-md-1">
                        <label class="col-form-label">Диагноз:</label>
                        <textarea rows="3" cols="3" name="diagnostic" class="form-control" placeholder="Диагноз"></textarea>
                    </div>

                    <div class="col-md-10 offset-md-1">
                        <label class="col-form-label">Рекомендации:</label>
                        <textarea rows="3" cols="3" name="recommendation" class="form-control" placeholder="Рекомендации"></textarea>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <?php
    }

    public function form_anest($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="status" value="1">

            <div class="modal-body">

                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <label class="col-form-label">Описание:</label>
                        <textarea rows="8" cols="3" name="description" class="form-control" placeholder="Описание"></textarea>
                    </div>

                    <div class="col-md-10 offset-md-1">
                        <label class="col-form-label">Диагноз:</label>
                        <textarea rows="3" cols="3" name="diagnostic" class="form-control" placeholder="Диагноз"></textarea>
                    </div>

                    <div class="col-md-10 offset-md-1">
                        <label class="col-form-label">Рекомендации:</label>
                        <textarea rows="3" cols="3" name="recommendation" class="form-control" placeholder="Рекомендации"></textarea>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <?php
    }

    public function form_oper($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="status" value="2">

            <div class="modal-body">

                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <label class="col-form-label">Описание:</label>
                        <textarea rows="8" cols="3" name="description" class="form-control" placeholder="Описание"></textarea>
                    </div>

                    <div class="col-md-10 offset-md-1">
                        <label class="col-form-label">Диагноз:</label>
                        <textarea rows="3" cols="3" name="diagnostic" class="form-control" placeholder="Диагноз"></textarea>
                    </div>

                    <div class="col-md-10 offset-md-1">
                        <label class="col-form-label">Рекомендации:</label>
                        <textarea rows="3" cols="3" name="recommendation" class="form-control" placeholder="Рекомендации"></textarea>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <?php
    }

    public function success()
    {
        $_SESSION['message'] = '
        <div class="alert alert-info" role="alert">
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

class InvestmentModel extends Model
{
    public $table = 'investment';

    public function form($pk = null)
    {
        global $db;
        ?>
        <form method="post" action="<?= add_url() ?>" onsubmit="Subi()">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="pricer_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="user_id" id="user_st_id">
            <input type="hidden" name="price_type" id="price_type">

            <div class="modal-body">
                <table class="table table-hover mb-2">
                    <tbody>
                        <tr class="table-secondary">
                            <td id="balance_name"></td>
                            <td class="text-right" id="input_balance"></td>
                        </tr>
                    </tbody>
                </table>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Наличный</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="number" name="balance_cash" id="input_chek_1" step="0.5" class="form-control input_check" placeholder="расчет" disabled>
                            <span class="input-group-prepend ml-5">
                                <span class="input-group-text">
                                    <input type="checkbox" class="form-control-switchery swit_check" data-fouc id="chek_1" onchange="Checkert(this)">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Пластиковый</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="number" name="balance_card" id="input_chek_2" step="0.5" class="form-control input_check" placeholder="расчет" disabled>
                            <span class="input-group-prepend ml-5">
                                <span class="input-group-text">
                                    <input type="checkbox" class="form-control-switchery swit_check" data-fouc id="chek_2" onchange="Checkert(this)">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-form-label col-md-3">Перечисление</label>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="number" name="balance_transfer" id="input_chek_3" step="0.5" class="form-control input_check" placeholder="расчет" disabled>
                            <span class="input-group-prepend ml-5">
                                <span class="input-group-text">
                                    <input type="checkbox" class="form-control-switchery swit_check" data-fouc id="chek_3" onchange="Checkert(this)">
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
    			<button type="button" class="btn btn-link" data-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-outline-info btn-sm">Печать</button>
    		</div>

        </form>
        <script type="text/javascript">

            $('.input_check').keyup(function (num) {
                var n = $(this).val().length;
                // if (n % 3 == 0) {
                //     $(this).val($(this).val()+" ");
                // }
            });

            function Subi() {
                event.preventDefault();
                $.ajax({
                    type: $(event.target).attr("method"),
                    url: $(event.target).attr("action"),
                    data: $(event.target).serializeArray(),
                    success: function (result) {
                        if (result == 1) {
                            new Noty({
                                text: 'Успешно!',
                                type: 'success'
                            }).show();
                        }else {
                            new Noty({
                                text: result,
                                type: 'error'
                            }).show();
                        }
                        $('#modal_invest').modal('hide');
                        Check('get_mod.php?pk='+$('#user_st_id').val() ,$('#user_st_id').val());
                    },
                });
            }

            function Checkert(event) {
                var input = $('#input_'+event.id);
                if(!input.prop('disabled')){
                    input.attr("disabled", "disabled");
                }else {
                    input.removeAttr("disabled");
                }
            }

        </script>
        <?php
    }

    public function clean()
    {
        if ($this->post['price_type'] == 0) {
            if ($this->post['balance_cash']) {
                $this->post['balance_cash'] *= -1;
            }
            if ($this->post['balance_card']) {
                $this->post['balance_card'] *= -1;
            }
            if ($this->post['balance_transfer']) {
                $this->post['balance_transfer'] *= -1;
            }
        }
        unset($this->post['price_type']);
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function success()
    {
        echo 1;
    }

    public function error($message)
    {
        echo $message;
    }
}

class DivisionModel extends Model
{
    public $table = 'division';

    public function form($pk = null)
    {
        global $db, $PERSONAL;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        if($_SESSION['message']){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <script src="<?= stack("global_assets/js/plugins/forms/styling/switchery.min.js") ?>"></script>
        <script src="<?= stack("vendors/js/custom.js") ?>"></script>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">

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

            <div class="form-group row">
                <label class="col-form-label col-md-1">Ассистент</label>
                <div class="col-md-3">
                    <input type="checkbox" class="swit" name="assist" <?= ($post['assist']==1) ? "checked" : "" ?>>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-form-label col-md-1">Радиолог</label>
                <div class="col-md-3">
                    <input type="checkbox" class="swit" name="assist" <?= ($post['assist']==2) ? "checked" : "" ?>>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-primary">Сохранить <i class="icon-paperplane ml-2"></i></button>
            </div>

        </form>
        <?php
    }

    public function clean()
    {
        if ($this->post['assist']) {
            $this->post['assist'] = True;
        }else {
            $this->post['assist'] = False;
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
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
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            '.$message.'
        </div>
        ';
        render();
    }
}

class WardModel extends Model
{
    public $table = 'wards';

    public function form($pk = null)
    {
        global $FLOOR;
        if($pk){
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

class BedModel extends Model
{
    public $table = 'beds';

    public function form($pk = null)
    {
        global $db, $FLOOR;
        if($pk){
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
                <select data-placeholder="Выбрать этаж" id="floor" class="form-control form-control-select2" required>
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
               <select data-placeholder="Выбрать палату" name="ward_id" id="ward_id" class="form-control form-control-select2" required>
                   <option></option>
                   <?php
                   foreach($db->query('SELECT * from wards') as $row) {
                       ?>
                       <option value="<?= $row['id'] ?>" data-chained="<?= $row['floor'] ?>" <?php if($row['id'] == $post['ward_id']){echo'selected';} ?>><?= $row['ward'] ?> палата</option>
                       <?php
                   }
                   ?>
               </select>
            </div>

            <div class="form-group">
                <label>Койка:</label>
                <input type="text" class="form-control" name="bed" placeholder="Введите номер" required value="<?= $post['num']?>">
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
        <script type="text/javascript">
            $(function(){
                $("#ward_id").chained("#floor");
            });
        </script>
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

class BedTypeModel extends Model
{
    public $table = 'bed_type';

    public function form($pk = null)
    {
        global $db;
        if($pk){
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

class ServiceModel extends Model
{
    public $table = 'service';


    public function form_template($pk = null)
    {
        ?>
        <form method="post" action="<?= add_url() ?>" onsubmit="//TempFunc()" enctype="multipart/form-data">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="form-group">
                <label>Шаблон:</label>
                <input type="file" class="form-control" name="template" required id="url_template">
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-primary">Сохранить</button>
            </div>

        </form>
        <?php
    }

    public function form($pk = null)
    {
        global $db, $PERSONAL;
        if($pk){
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
                <label>Код:</label>
                <input type="text" class="form-control" name="code" placeholder="Введите код" required value="<?= $post['code']?>">
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
        if($_FILES['template']){
            $this->post['template'] = read_excel($_FILES['template']['tmp_name']);
            $this->save_excel();
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        if($this->post['user_level'] and !$this->post['division_id']){
            $this->post['division_id'] = null;
        }
        return True;
    }

    public function clean_excel()
    {
        if ($this->post['user_level']) {
            switch ($this->post['user_level']) {
                case 'A':
                    $this->post['user_level'] = 1;
                    break;
                case 'B':
                    $this->post['user_level'] = 5;
                    break;
                case 'D':
                    $this->post['user_level'] = 10;
                    break;
                case 'L':
                    $this->post['user_level'] = 6;
                    break;
            }
        }
        return True;
    }

    public function save_excel()
    {
        foreach ($this->post['template'] as $key_p => $value_p) {
            if ($key_p) {
                foreach ($value_p as $key => $value) {
                    $pick = $pirst[$key];
                    switch ($pick) {
                        case 'role':
                            $pick = "user_level";
                            break;
                        case 'service':
                            $pick = "name";
                            break;
                    }
                    $this->post[$pick] = $value;
                }
                if($this->clean_excel()){
                    prit($this->post);
                    $object = Mixin\insert($this->table, $this->post);
                    if (!intval($object)){
                        $this->error($object);
                    }
                }
            }else {
                $pirst = $value_p;
                unset($this->post['template']);
            }
        }
        $this->success();
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

class StorageTypeModel extends Model
{
    public $table = 'storage_type';

    public function form($pk = null)
    {
        global $db;
        if($pk){
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

class LaboratoryAnalyzeTypeModel extends Model
{
    public $table = 'laboratory_analyze_type';

    public function form($pk = null)
    {
        global $db;
        if($pk){
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
            <input type="hidden" name="id" value="<?= $pk ?>">

            <div class="form-group">
                <label>Услуга:</label>
                <select data-placeholder="Выбрать услугу" name="service_id" class="form-control form-control-select2" required>
                    <option></option>
                    <?php
                    foreach($db->query('SELECT * from service WHERE user_level = 6') as $row) {
                        ?>
                        <option value="<?= $row['id'] ?>"<?php if($row['id'] == $post['service_id']){echo'selected';} ?>><?= $row['name'] ?></option>
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
                <label>Код:</label>
                <input type="text" class="form-control" name="code" placeholder="Введите код" required value="<?= $post['code']?>">
            </div>

            <div class="form-group">
                <label>Норматив:</label>
                <textarea rows="4" cols="4" name="standart" class="form-control" placeholder="Введите норматив ..."><?= $post['standart']?></textarea>
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-info">Сохранить</button>
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
        render();
    }

    public function error($message)
    {
        $_SESSION['message'] = '
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            '.$message.'
        </div>
        ';
        render();
    }
}

class LaboratoryAnalyzeModel extends Model
{
    public $table = 'laboratory_analyze';

    public function table_form($pk = null)
    {
        global $db;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        ?>
        <form method="post" action="<?= add_url() ?>" id="<?= __CLASS__ ?>_form">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="user_id" value="<?= $_GET['id'] ?>">

            <div class="modal-body">
                <div id="modal_message">
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-sm table-bordered">
                        <thead>
                            <tr class="bg-info">
                                <th style="width:3%">№</th>
                                <th>Название услуги</th>
                                <th>Анализ</th>
                                <th style="width:10%">Норматив</th>
                                <th style="width:10%">Результат</th>
                                <th class="text-center" style="width:10%">Отклонение</th>
                                <th class="text-center" style="width:25%">Примечание</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $s = 1;
                            foreach ($db->query("SELECT id, service_id FROM visit WHERE completed IS NULL AND laboratory IS NOT NULL AND status = 2 AND user_id = {$_GET['id']} AND parent_id = {$_SESSION['session_id']} ORDER BY add_date ASC") as $row_parent) {
                                foreach ($db->query("SELECT la.id, la.result, la.deviation, la.description, lat.id 'analyze_id', lat.name, lat.standart, sc.name 'ser_name' FROM laboratory_analyze_type lat LEFT JOIN service sc ON(lat.service_id=sc.id) LEFT JOIN laboratory_analyze la ON(la.user_id={$_GET['id']} AND la.analyze_id=lat.id AND la.visit_id ={$row_parent['id']}) WHERE lat.service_id = {$row_parent['service_id']}") as $row) {
                                    ?>
                                    <tr id="TR_<?= $i ?>" class="<?= ($row['deviation']) ? "table-danger" : "" ?>">
                                        <td><?= $s++ ?></td>
                                        <td><?= $row['ser_name'] ?></td>
                                        <td><?= $row['name'] ?></td>
                                        <td><?= $row['standart'] ?></td>
                                        <td>
                                            <input type="hidden" name="<?= $i ?>[id]" value="<?= $row['id'] ?>">
                                            <input type="hidden" name="<?= $i ?>[analyze_id]" value="<?= $row['analyze_id'] ?>">
                                            <input type="hidden" name="<?= $i ?>[visit_id]" value="<?= $row_parent['id'] ?>">
                                            <input type="text" class="form-control" name="<?= $i ?>[result]" value="<?= $row['result'] ?>">
                                        </td>
                                        <td>
                                            <div class="form-check">
        										<label class="form-check-label">
        											<input data-id="TR_<?= $i ?>" type="checkbox" name="<?= $i ?>[deviation]" class="form-check-input cek_a" <?= ($row['deviation']) ? "checked" : "" ?>>
        										</label>
        									</div>
                                        </td>
                                        <th class="text-center" style="width:25%">
                                            <textarea class="form-control" placeholder="Введите примечание" name="<?= $i ?>[description]" rows="1" cols="80"><?= $row['description'] ?></textarea>
                                        </th>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>

            <div class="modal-footer">
                <input class="btn btn-outline-danger btn-sm" type="submit" value="Завершить" name="end"></input>
                <button type="submit" class="btn btn-outline-info btn-sm">Сохранить</button>
            </div>

        </form>
        <script type="text/javascript">

            $('.cek_a').on('click', function(event) {
                if ($(this).is(':checked')) {
                    $('#'+this.dataset.id).addClass("table-danger");
                }else {
                    $('#'+this.dataset.id).removeClass("table-danger");
                }
            });
        </script>
        <?php
    }

    public function save()
    {
        global $db;
        $end = ($this->post['end']) ? true : false;
        unset($this->post['end']);
        $user_pk = $this->post['user_id'];
        unset($this->post['user_id']);
        foreach ($this->post as $val) {
            if ($val['id']) {
                $pk = $val['id'];
                unset($val['id']);
                if ($val['deviation']) {
                    $val['deviation'] = 1;
                }else {
                    $val['deviation'] = null;
                }
                $object = Mixin\update($this->table, $val, $pk);
            }else {
                $val['user_id'] = $user_pk;
                unset($val['id']);
                if ($val['deviation']) {
                    $val['deviation'] = 1;
                }else {
                    $val['deviation'] = null;
                }
                $val['service_id'] = $db->query("SELECT service_id FROM visit WHERE id = {$val['visit_id']}")->fetch()['service_id'];
                $object = Mixin\insert('laboratory_analyze', $val);
            }
        }
        if (intval($object)){
            if ($end) {
                foreach ($db->query("SELECT id, grant_id, parent_id FROM visit WHERE completed IS NULL AND laboratory IS NOT NULL AND status = 2 AND user_id = $user_pk AND parent_id = {$_SESSION['session_id']} ORDER BY add_date ASC") as $row) {
                    if ($row['grant_id'] == $row['parent_id']) {
                        Mixin\update('users', array('status' => null), $user_pk);
                    }
                    $this->clear_post();
                    $this->set_table('visit');
                    $this->set_post(array(
                        'id' => $row['id'],
                        'status' => 0,
                        'completed' => date('Y-m-d H:i:s')
                    ));
                    $this->update();
                }
                $this->success();

            }else {
                $this->success();
            }
        }else{
            $this->error($object);
        }
    }

    public function update()
    {
        if($this->clean()){
            $pk = $this->post['id'];
            unset($this->post['id']);
            $object = Mixin\update($this->table, $this->post, $pk);
            if (!intval($object)){
                $this->error($object);
            }
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
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            '.$message.'
        </div>
        ';
        render();
    }
}

class BypassModel extends Model
{
    public $table = 'bypass';

    public function form($pk = null)
    {
        global $db, $patient, $methods;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="user_id" value="<?= $patient->id ?>">
            <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="modal-body">

                <div class="form-group row">

                    <div class="col-md-9">

                        <label>Препарат:</label>
                        <select class="form-control multiselect-full-featured" data-placeholder="Выбрать препарат" name="preparat[]" multiple="multiple" required data-fouc>
                            <?php foreach ($db->query("SELECT product_id, product_code, qty FROM products WHERE catg = 2") as $row2): ?>
                                <option value="<?= $row2['product_id'] ?>"><?= $row2['product_code'] ?> (<?= $row2['qty'] ?>)</option>
                            <?php endforeach; ?>
						</select>
                    </div>

                </div>

                <div class="form-group row">

                    <div class="col-md-6">
                        <label>Метод:</label>
                        <select data-placeholder="Выбрать метод" name="method" class="form-control form-control-select2" required>
                            <option></option>
                            <?php foreach ($methods as $key => $value): ?>
                                <option value="<?= $key ?>"><?= $value ?></option>
                            <?php endforeach; ?>
                        </select>

                    </div>

                    <div class="col-md-6">
                        <label>Описание:</label>
                        <input type="text" class="form-control" name="description" placeholder="Введите описание" required>
                    </div>

                </div>

                <div class="form-group row">

                    <div class="col-md-1 text-right">
                        <button onclick="AddinputTime()" type="button" class="btn btn-outline-success btn-sm" style="margin-top:20px"><i class="icon-plus22 mr-2"></i>Добавить время</button>
                    </div>

                </div>

                <div class="form-group row" id="time_div">
                    <div class="col-md-3" id="time_input_0">
                        <label>Время принятия:</label>
                        <input type="time" name="time[0]" class="form-control">
                    </div>
                </div>

            </div>

    		<div class="modal-footer">
                <button class="btn btn-outline-info btn-sm legitRipple" type="submit">Сохранить</button>
            </div>

        </form>
        <script type="text/javascript">
            var i = 0;
            function AddinputTime() {
                i++;
                $('#time_div').append(`
                    <div class="col-md-3" id="time_input_`+ i +`">
                        <label>Время принятия:</label>
                        <input type="time" name="time[`+ i +`]" class="form-control">
                    </div>
                `);
            }
        </script>
        <?php
    }

    public function save()
    {
        if($this->clean()){
            $object = Mixin\insert($this->table, $this->post);
            if (intval($object)){
                $this->set_table('bypass_preparat');
                foreach ($this->post_preparat as $value) {
                    $object1 = Mixin\insert($this->table, array(
                        'bypass_id' => $object,
                        'preparat_id' => $value,
                    ));
                    if (!intval($object1)) {
                        $this->error($object1);
                    }
                }
                $this->set_table('bypass_time');
                foreach ($this->post_time as $value) {
                    $object1 = Mixin\insert($this->table, array(
                        'bypass_id' => $object,
                        'time' => $value,
                    ));
                    if (!intval($object1)) {
                        $this->error($object1);
                    }
                }
                $this->success();
            }else{
                $this->error($object);
            }
        }
    }

    public function clean()
    {
        $this->post_preparat = $this->post['preparat'];
        $this->post_time = $this->post['time'];
        unset($this->post['preparat']);
        unset($this->post['time']);
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
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
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            '.$message.'
        </div>
        ';
        render();
    }
}

class PatientStatsModel extends Model
{
    public $table = 'user_stats';

    public function form($pk = null)
    {
        global $db, $patient;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="modal-body">

                <div class="form-group row">

                    <div class="col-md-6">
                        <label>Состояние:</label>
                        <select placeholder="Введите состояние" name="stat" class="form-control form-control-select2">
                            <option value="">Норма</option>
                            <option value="1">Актив</option>
                            <option value="2">Пассив</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Давление:</label>
                        <input type="text" class="form-control" name="pressure" placeholder="Введите давление">
                    </div>

                </div>

                <div class="form-group row">

                    <div class="col-md-4">
                        <label>Пульс:</label>
                        <input type="number" class="form-control" name="pulse" min="40" step="1" max="150" value="85" placeholder="Введите пульс" required>
                    </div>

                    <div class="col-md-4">
                        <label>Температура:</label>
                        <input type="number" class="form-control" name="temperature" min="35" step="0.1" max="42" value="36.6" placeholder="Введите температура" required>
                    </div>

                    <div class="col-md-4">
                        <label>Сатурация:</label>
                        <input type="number" class="form-control" name="saturation" min="25" max="100" placeholder="Введите cатурация" required>
                    </div>

                </div>

                <div class="form-group row">

                    <div class="col-md-6">
                        <label>Дыхание:</label>
                        <input type="number" class="form-control" name="breath" min="10" step="1" max="50" placeholder="Введите дыхание">
                    </div>

                    <div class="col-md-6">
                        <label>Моча:</label>
                        <input type="number" class="form-control" name="urine" min="0" step="0.1" max="5">
                    </div>

                </div>

                <div class="form-group row">

                    <div class="col-md-12">
                        <label class="col-form-label">Примечание:</label>
                        <textarea rows="3" cols="3" name="description" class="form-control" placeholder="Описание"></textarea>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-link legitRipple" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
                <button class="btn btn-outline-info btn-sm legitRipple" type="submit" ><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
            </div>

        </form>
        <?php
    }

    public function form_oper($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">
            <input type="hidden" name="status" value="2">

            <div class="modal-body">

                <div class="form-group row">

                    <div class="col-md-6">
                        <label>Время:</label>
                        <input type="time" class="form-control" name="time">
                    </div>

                    <div class="col-md-6">
                        <label>Давление:</label>
                        <input type="text" class="form-control" name="pressure" placeholder="Введите давление">
                    </div>

                </div>

                <div class="form-group row">

                    <div class="col-md-4">
                        <label>Пульс:</label>
                        <input type="number" class="form-control" name="pulse" min="40" step="1" max="150" value="85" placeholder="Введите пульс" required>
                    </div>

                    <div class="col-md-4">
                        <label>Температура:</label>
                        <input type="number" class="form-control" name="temperature" min="35" step="0.1" max="42" value="36.6" placeholder="Введите температура" required>
                    </div>

                    <div class="col-md-4">
                        <label>Сатурация:</label>
                        <input type="number" class="form-control" name="saturation" min="25" max="100" placeholder="Введите cатурация" required>
                    </div>

                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-link legitRipple" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
                <button class="btn btn-outline-info btn-sm legitRipple" type="submit" ><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
            </div>

        </form>
        <?php
    }

    public function clean()
    {
        if ($this->post['status'] and $this->post['time']) {
            $this->post['add_date'] = date('Y-m-d ') . $this->post['time'];
            unset($this->post['time']);
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
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
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            '.$message.'
        </div>
        ';
        render();
    }
}

class StoragePreparatModel extends Model
{
    public $table = 'storage_preparat';

    public function form($pk = null)
    {
        global $db, $pk;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="card border-1 border-info">

                <div class="card-header text-dark header-elements-inline alpha-info">
                    <h5 class="card-title">Список лекарств пациента</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                            <select data-placeholder="Выберите специалиста" name="parent_id" onchange="CallMed(this.value)" class="form-control form-control-select2" required>
                                <option></option>
                                <?php
                                foreach($db->query('SELECT * from users WHERE user_level = 7') as $row) {
                                    ?>
                                    <option value="<?= $row['id'] ?>" ><?= get_full_name($row['id']) ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="table-responsive card">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr class="bg-blue">
                                    <th style="width: 100px">№</th>
                                    <th>Лекарства</th>
                                    <th>Количество</th>
                                    <th>Цена ед.</th>
                                    <th>Сумма</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total_cost=0;$i=1; foreach ($db->query("SELECT sr.id, pt.product_code 'preparat_code', sr.qty, pt.price, sr.qty*pt.price 'total_price' FROM storage_orders sr LEFT JOIN products pt ON(pt.product_id=sr.preparat_id) WHERE sr.date = CURRENT_DATE() AND sr.user_id = $pk ORDER BY sr.preparat_id") as $row): ?>
                                    <tr>
                                        <input type="hidden" name="orders[<?=$row['id'] ?>]" value="<?= $row['qty'] ?>">
                                        <td><?= $i++ ?></td>
                                        <td><?= $row['preparat_code'] ?></td>
                                        <td><?= $row['qty'] ?></td>
                                        <td><?= number_format($row['price']) ?></td>
                                        <td class="text-left">
                                            <?php
                                            $total_cost += $row['total_price'];
                                            echo number_format($row['total_price']);
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="4" class="text-right"><b>Итого:</b></td>
                                    <td class="text-left"><b><?= number_format($total_cost) ?></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-outline-success btn-sm">Отправить</button>
                    </div>

                </div>

            </div>

        </form>
        <?php
    }

    public function form_order($pk = null)
    {
        global $db, $pk;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="parent_id" value="<?= $pk ?>">

            <div class="card border-1 border-info">

                <div class="card-header text-dark header-elements-inline alpha-info">
                    <h5 class="card-title">Список лекарств</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                            <button type="button" class="btn list-icons-item text-danger" onclick="CallMed(<?= $pk ?>)">Вызвать</button>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="table-responsive card">
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr class="bg-blue">
                                    <th style="width: 100px">№</th>
                                    <th>Лекарства</th>
                                    <th>Количество</th>
                                    <th>Цена ед.</th>
                                    <th>Сумма</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total_cost=0;$i=1; foreach ($db->query("SELECT sr.id, pt.product_code 'preparat_code', sr.qty, pt.price, sr.qty*pt.price 'total_price' FROM storage_orders sr LEFT JOIN products pt ON(pt.product_id=sr.preparat_id) WHERE sr.date = CURRENT_DATE() AND sr.parent_id = $pk ORDER BY sr.preparat_id") as $row): ?>
                                    <tr>
                                        <input type="hidden" name="orders[<?=$row['id'] ?>]" value="<?= $row['qty'] ?>">
                                        <td><?= $i++ ?></td>
                                        <td><?= $row['preparat_code'] ?></td>
                                        <td><?= $row['qty'] ?></td>
                                        <td><?= number_format($row['price']) ?></td>
                                        <td class="text-left">
                                            <?php
                                            $total_cost += $row['total_price'];
                                            echo number_format($row['total_price']);
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="4" class="text-right"><b>Итого:</b></td>
                                    <td class="text-left"><b><?= number_format($total_cost) ?></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="text-right">
                        <button type="submit" class="btn btn-outline-success btn-sm">Отправить</button>
                    </div>

                </div>

            </div>

        </form>
        <?php
    }

    public function clean()
    {
        global $db;
        foreach ($this->post['orders'] as $order_pk => $qty) {
            $order = $db->query("SELECT * FROM storage_orders WHERE id=$order_pk")->fetch();
            $post = $db->query("SELECT {$this->post['parent_id']} 'user_id', product_id 'product', qty, profit, product_code, gen_name, product_name 'name', price FROM products WHERE product_id = {$order['preparat_id']}")->fetch();
            $post['amount'] = $qty * $post['price'];
            $post['profit'] = $qty * $post['profit'];
            if($post['qty'] < $qty){
                $this->error("В аптеке не хватает \"{$post['product_code']}\"!");
            }
            $object = Mixin\update('products', array('qty' => $post['qty']-$qty), array('product_id' => $order['preparat_id']));
            if (intval($object)) {
                $post['qty'] = $qty;
                $object1 = Mixin\insert('sales_order', $post);
                if (!intval($object1)) {
                    $this->error('sales_order'.$object1);
                }
            }else {
                $this->error('products'.$object);
            }
            $post2['parent_id'] = $this->post['parent_id'];
            $post2['preparat_id'] = $post['product'];
            $post2['preparat_code'] = $post['product_code'];
            $post2['first_qty'] = $qty;
            $post2['qty'] = $qty;
            $post2['price'] = $post['price'];
            $post2['amount'] = $qty * $post['price'];
            $infod = $db->query("SELECT id, first_qty, qty, amount FROM storage_preparat WHERE preparat_id = {$order['preparat_id']} AND price = {$post['price']}")->fetch();
            if ($infod) {
                $infod_pk = $infod['id'];
                unset($infod['id']);
                $infod['first_qty'] += $qty;
                $infod['qty'] += $qty;
                $infod['amount'] += $qty * $post['price'];
                $object = Mixin\update('storage_preparat', $infod, $infod_pk);
            } else {
                $object = Mixin\insert('storage_preparat', $post2);
            }
            if (!intval($object)) {
                $this->error($object);
            }
            $object = Mixin\delete('storage_orders', $order_pk);
        }
        $this->success();
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
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            '.$message.'
        </div>
        ';
        render();
    }
}

class VisitMemberModel extends Model
{
    public $table = 'visit_member';

    public function form($pk = null)
    {
        global $db, $patient;
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="visit_id" value="<?= $patient->visit_id ?>">

            <div class="modal-body">

                <div class="form-group">
                    <label>Член персонала:</label>
                    <select placeholder="Введите состояние" name="member_id" class="form-control form-control-select2">
                        <?php foreach ($db->query("SELECT us.id, IFNULL(vm.id, NULL) 'vm_id' FROM users us LEFT JOIN visit_member vm ON(vm.member_id=us.id AND vm.status IS NULL AND vm.visit_id=$patient->visit_id) WHERE us.user_level = 5 AND us.id != {$_SESSION['session_id']}") as $row): ?>
                            <option value="<?= $row['id'] ?>" <?= ($row['vm_id']) ? "disabled" : "" ?>><?= get_full_name($row['id']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-link legitRipple" data-dismiss="modal"><i class="icon-cross2 font-size-base mr-1"></i> Close</button>
                <button class="btn btn-outline-info btn-sm legitRipple" type="submit" ><i class="icon-checkmark3 font-size-base mr-1"></i> Save</button>
            </div>

        </form>
        <?php
    }

    public function clean()
    {
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
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
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
            '.$message.'
        </div>
        ';
        render();
    }
}

?>
