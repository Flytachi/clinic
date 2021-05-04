<?php

class Storage extends Model
{
    public $table = 'storage';
    public $table_label = array(
        'id' => 'id',
        'code' => 'Код',
        'name' => 'Препарат',
        'supplier' => 'Поставщик',
        'category' => 'Категория(2,3,4)',
        'qty' => 'Кол-во',
        'qty_limit' => 'Лимит',
        'cost' => 'Цена прихода',
        'price' => 'Цена расхода',
        'faktura' => 'Счёт фактура',
        'shtrih' => 'Штрих код',
        'add_date' => 'Дата поставки',
        'die_date' => 'Срок годности',
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
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Внести</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <?php
    }

    public function form($pk = null)
    {
        global $CATEGORY, $classes;
        if($pk){
            $post = $this->post;
        }else{
            $post = array();
        }
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $post['id'] ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="form-group">
               <label>Препарат:</label>
               <input type="text" class="form-control" name="name" placeholder="Введите название препарата" required value="<?= $this->value($post, 'name') ?>">
            </div>

            <div class="form-group row">

                <div class="col-md-3">
                    <label>Код:</label>
                    <input type="text" class="form-control" name="code" placeholder="Введите код" required value="<?= $this->value($post, 'code') ?>">
                </div>

                <div class="col-md-9">
                    <label>Поставщик:</label>
                    <input type="text" class="form-control" name="supplier" placeholder="Введите поставщик" required value="<?= $this->value($post, 'supplier') ?>">
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-4">
                    <label>Кол-во:</label>
                    <input type="text" class="form-control" name="qty" placeholder="Введите колличество" required value="<?= $this->value($post, 'qty') ?>">
                </div>

                <div class="col-md-4">
                    <label>Цена прихода:</label>
                    <input type="text" class="form-control" name="cost" placeholder="Введите цену" required value="<?= $this->value($post, 'cost') ?>">
                </div>

                <div class="col-md-4">
                    <label>Цена расхода:</label>
                    <input type="text" class="form-control" name="price" placeholder="Введите цену" required value="<?= $this->value($post, 'price') ?>">
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-3">
                    <label>Категория:</label>
                    <select data-placeholder="Выбрать этаж" name="category" class="<?= $classes['form-select'] ?>" required>
                        <option></option>
                        <?php foreach ($CATEGORY as $key => $value): ?>
                            <option value="<?= $key ?>" <?= ($this->value($post, 'category') == $key) ? 'selected': '' ?>><?= $value ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-3">
                    <label>Дата прихода:</label>
                    <input type="date" class="form-control" name="add_date" placeholder="Введите дату" required value="<?= $this->value($post, 'add_date') ?>">
                </div>

                <div class="col-md-3">
                    <label>Срок годности:</label>
                    <input type="date" class="form-control" name="die_date" placeholder="Введите дату" required value="<?= $this->value($post, 'die_date') ?>">
                </div>

                <div class="col-md-3">
                    <label>Штрих код:</label>
                    <input type="text" class="form-control" name="shtrih" placeholder="Введите код" required value="<?= $this->value($post, 'shtrih') ?>">
                </div>

            </div>

            <div class="form-group">
               <label>Счёт фактура:</label>
               <input type="text" class="form-control" name="faktura" placeholder="Введите счёт" required value="<?= $this->value($post, 'faktura') ?>">
            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <?php
        if ($pk) {
            $this->jquery_init();
        }
    }

    public function clean()
    {
        if($_FILES['template']){
            // prit('temlate');
            $this->post['template'] = read_excel($_FILES['template']['tmp_name']);
            $this->save_excel();
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function clean_excel()
    {
        if ($this->table_label) {
            foreach ($this->table_label as $key => $value) {
                $post[$key] = $this->post[$value];
            }
            $this->post = $post;
        }
        $this->post['parent_id'] = $_SESSION['session_id'];
        $this->post['cost'] = preg_replace("/,+/", "", $this->post['cost']);
        $this->post['price'] = preg_replace("/,+/", "", $this->post['price']);
        if ($this->post['qty']) {
            return True;
        }
        return False;
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

?>
