<?php

class StoragesModel extends Model
{
    public $table = 'storages';
    public $_supply = 'storage_supply';
    public $_supply_item = 'storage_supply_items';
    public $table_label = array(
        'item_key' => 'Ключ',
        'item_name' => 'Препарат',
        'item_supplier' => 'Поставщик',
        'item_qty' => 'Кол-во',
        'item_cost' => 'Цена прихода',
        'item_price' => 'Цена расхода',
        'item_faktura' => 'Счёт фактура',
        'item_shtrih' => 'Штрих код',
        'item_die_date' => 'Срок годности',
    );
    // public $table_label = array(
    //     'id' => 'id',
    //     'code' => 'Код',
    //     'name' => 'Препарат',
    //     'supplier' => 'Поставщик',
    //     'category' => 'Категория(2,3,4)',
    //     'qty' => 'Кол-во',
    //     'qty_limit' => 'Лимит',
    //     'cost' => 'Цена прихода',
    //     'price' => 'Цена расхода',
    //     'faktura' => 'Счёт фактура',
    //     'shtrih' => 'Штрих код',
    //     'add_date' => 'Дата поставки',
    //     'die_date' => 'Срок годности',
    // );

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
        if( isset($_SESSION['message']) ){
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
            <input type="hidden" name="parent_id" value="<?= $_SESSION['session_id'] ?>">

            <div class="form-group row">

                <div class="col-md-3">
                    <label>Ключ:</label>
                    <input type="text" class="form-control" name="item_key" placeholder="Введите код" value="<?= $this->value('item_key') ?>">
                </div>

                <div class="col-md-5">
                    <label>Препарат:</label>
                    <input type="text" class="form-control" name="item_name" placeholder="Введите название препарата" required value="<?= $this->value('item_name') ?>">
                </div>

                <div class="col-md-4">
                    <label>Поставщик:</label>
                    <input type="text" class="form-control" name="item_supplier" placeholder="Введите поставщик" required value="<?= $this->value('item_supplier') ?>">
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-4">
                    <label>Срок годности:</label>
                    <input type="date" class="form-control" name="item_die_date" placeholder="Введите дату" required value="<?= $this->value('item_die_date') ?>">
                </div>

                <div class="col-md-2">
                    <label>Кол-во:</label>
                    <input type="number" class="form-control" name="item_qty" placeholder="Введите колличество" required value="<?= $this->value('item_qty') ?>">
                </div>

                <div class="col-md-3">
                    <label>Цена прихода:</label>
                    <input type="text" class="form-control" name="item_cost" placeholder="Введите цену" required value="<?= $this->value('item_cost') ?>">
                </div>

                <div class="col-md-3">
                    <label>Цена расхода:</label>
                    <input type="text" class="form-control" name="item_price" placeholder="Введите цену" required value="<?= $this->value('item_price') ?>">
                </div>

            </div>

            <div class="form-group row">

                <div class="col-md-6">
                    <label>Штрих код:</label>
                    <input type="text" class="form-control" name="item_shtrih" placeholder="Введите код" value="<?= $this->value('item_shtrih') ?>">
                </div>

                <div class="col-md-6">
                    <label>Счёт фактура:</label>
                    <input type="text" class="form-control" name="item_faktura" placeholder="Введите счёт" required value="<?= $this->value('item_faktura') ?>">
                </div>

            </div>

            <div class="text-right">
                <button type="submit" class="btn btn-sm btn-light btn-ladda btn-ladda-spinner ladda-button legitRipple" data-spinner-color="#333" data-style="zoom-out">
                    <span class="ladda-label">Сохранить</span>
                    <span class="ladda-spinner"></span>
                </button>
            </div>

        </form>
        <?php
    }

    public function clean()
    {
        if($_FILES['template']){
            $this->template = read_excel($_FILES['template']['tmp_name']);
            $this->save_excel();
        }else {
            $this->post = Mixin\clean_form($this->post);
            $this->post = Mixin\to_null($this->post);
            return True;
        }
    }

    public function clean_excel()
    {
        if ($this->table_label) {
            foreach ($this->table_label as $key => $value) {
                $post[$key] = $this->post[$value];
            }
            $this->post = $post;
        }
        if ($this->post['item_qty']) {

            if(!$this->post['item_key']) $this->post['item_key'] = uniqid('key-');
            $this->post['item_cost'] = preg_replace("/,+/", "", $this->post['item_cost']);
            $this->post['item_price'] = preg_replace("/,+/", "", $this->post['item_price']);
            return True;
        }
        return False;
    }

    public function excel_label()
    {
        $this->rows = $this->template[0];
        unset($this->template[0]);
    }

    public function save_excel()
    {
        global $db, $session;
        $db->beginTransaction();
        
        $this->supply_key = uniqid('supply-');
        $object = Mixin\insert($this->_supply, array('parent_id' => $session->session_id, 'uniq_key' => $this->supply_key));
        $this->excel_label();
        foreach ($this->template as $key_p => $value_p) {
            foreach ($value_p as $key => $value) {
                $this->post[$this->rows[$key]] = $value;
            }
            if($this->clean_excel()){
                $object = Mixin\insert_or_update($this->table, $this->post);
                if (!intval($object)){
                    $this->error($object);
                    $db->rollBack();
                }
                $this->post['uniq_key']=$this->supply_key;
                $object = Mixin\insert_or_update($this->_supply_item, $this->post);
                if (!intval($object)){
                    $this->error($object);
                    $db->rollBack();
                }
            }
            unset($this->post);
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