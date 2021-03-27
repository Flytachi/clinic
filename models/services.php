<?php

class ServiceModel extends Model
{
    public $table = 'service';
    public $table_label = array(
        'id' => 'id',
        'division_id' => 'Отдел',
        'code' => 'Код',
        'name' => 'Услуга',
        'price' => 'Цена',
        'type' => 'Тип(1,2,3)',
    );

    public function form_template($pk = null)
    {
        ?>
        <form method="post" action="<?= add_url() ?>" enctype="multipart/form-data">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">

            <div class="form-group">
                <label>Шаблон:</label>
                <input type="file" class="form-control" name="template" accept="application/vnd.ms-excel" required>
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

            <div class="form-group row">

                <div class="col-md-5">
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

                <div class="col-md-4">
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

                <div class="col-3">
                    <label>Тип:</label>
                    <select name="type" class="form-control form-control-select2" required >
                        <option value="1" <?= ($post['type']==1) ? 'selected': '' ?>>Обычная</option>
                        <option value="2" <?= ($post['type']==2) ? 'selected': '' ?>>Консультация</option>
                        <option value="3" <?= ($post['type']==3) ? 'selected': '' ?>>Операционная</option>
                    </select>
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Название:</label>
                    <input type="text" class="form-control" name="name" placeholder="Введите название" required value="<?= $post['name']?>">
                </div>

                <div class="col-md-3">
                    <label>Код:</label>
                    <input type="text" class="form-control" name="code" placeholder="Введите код" value="<?= $post['code']?>">
                </div>

                <div class="col-md-3">
                    <label>Цена:</label>
                    <input type="number" class="form-control" step="0.1" name="price" placeholder="Введите цену" required value="<?= $post['price']?>">
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-outline-primary">Сохранить</button>
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
        // parad("_FILES",$_FILES['template']);
        if($_FILES['template']){
            // prit('template');
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
        global $db;
        if ($this->table_label) {
            foreach ($this->table_label as $key => $value) {
                $post[$key] = $this->post[$value];
            }
            $this->post = $post;
        }
        $this->post['price'] = preg_replace("/,+/", "", $this->post['price']);
        $this->post['user_level'] = $db->query("SELECT level FROM division WHERE id = {$this->post['division_id']}")->fetchColumn();
        return True;
    }

    public function save_excel()
    {
        global $db;
        $db->beginTransaction();
        foreach ($this->post['template'] as $key_p => $value_p) {
            if ($key_p) {
                foreach ($value_p as $key => $value) {
                    $pick = $pirst[$key];
                    $this->post[$pick] = $value;
                }
                if($this->clean_excel()){
                    $object = Mixin\insert_or_update($this->table, $this->post);
                    if (!intval($object)){
                        $this->error($object);
                        $db->rollBack();
                    }
                }
            }else {
                $pirst = $value_p;
                unset($this->post['template']);
            }
        }
        $db->commit();
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

class ServiceAnalyzeModel extends Model
{
    public $table = 'service_analyze';

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
                    <?php foreach ($db->query("SELECT * from service WHERE user_level = 6") as $row): ?>
                        <option value="<?= $row['id'] ?>" <?php if($row['id'] == $post['service_id']){echo'selected';} ?>><?= $row['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-8">
                            <label>Норматив:</label>
                            <textarea class="form-control" name="standart" rows="3" cols="2" placeholder="Норматив"><?= $post['standart']?></textarea>
                        </div>
                        <div class="col-md-4">
                            <label>Ед:</label>
                            <textarea class="form-control" name="unit" rows="3" cols="2" placeholder="Единица"><?= $post['unit']?></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Название:</label>
                            <input type="text" class="form-control" name="name" placeholder="Введите название" required value="<?= $post['name']?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label>Код:</label>
                            <input type="text" class="form-control" name="code" placeholder="Введите код" value="<?= $post['code']?>">
                        </div>
                    </div>
                </div>

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

class ServicePreparatModel extends Model
{
    public $table = 'service_preparat';

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
                    <?php foreach ($db->query("SELECT * from service WHERE type = 3") as $row): ?>
                        <option value="<?= $row['id'] ?>" <?php if($row['id'] == $post['service_id']){echo'selected';} ?>><?= $row['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group row">

                <div class="col-md-10">
                    <div class="form-group">
                        <label>Препарат:</label>
                        <select data-placeholder="Выбрать услугу" name="preparat_id" class="form-control form-control-select2" required>
                            <option></option>
                            <?php foreach ($db->query("SELECT * from storage") as $row): ?>
                                <option value="<?= $row['id'] ?>" data-price="<?= $row['price'] ?>" <?php if($row['id'] == $post['preparat_id']){echo'selected';} ?>><?= $row['name'] ?> | <?= $row['supplier'] ?> (годен до <?= date("d.m.Y", strtotime($row['die_date'])) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        <label>Кол-во:</label>
                        <input type="number" class="form-control" name="qty" placeholder="Введите кол-во" value="<?= $post['qty']?>">
                    </div>
                </div>

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

?>
