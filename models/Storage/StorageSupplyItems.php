<?php

class StorageSupplyItemsModel extends Model
{
    public $table = 'storage_supply_items';
    public $number = 0;
    public $not_tr = false;
    public $uniq_key;

    public function form($pk = null)
    {
        global $db, $classes;
        ?>
        <?php if(!$this->not_tr): ?>
            <tr id="table_tr-<?= $this->number ?>">
        <?php endif; ?>
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="uniq_key" value="<?= $this->uniq_key ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">

            <td>
                <select name="item_key" class="<?= $classes['form-select'] ?>" data-placeholder="Выберите Ключ" onchange="UpBtn('btn_save-<?= $this->number ?>')">
                    <option value="0">New key</option>
                    <?php foreach ($db->query("SELECT DISTINCT item_key FROM storage_supply_items") as $row): ?>
                        <option value="<?= $row['item_key'] ?>" <?= ($this->value('item_key') == $row['item_key']) ? 'selected': '' ?>><?= $row['item_key'] ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td>
                <select name="item_name_id" class="<?= $classes['form-select'] ?>" data-placeholder="Выберите Препарат" onchange="UpBtn('btn_save-<?= $this->number ?>')">
                    <option></option>
                    <?php foreach ($db->query("SELECT * FROM storage_item_names") as $row): ?>
                        <option value="<?= $row['id'] ?>" <?= ($this->value('item_name_id') == $row['id']) ? 'selected': '' ?>><?= $row['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td>
                <select name="item_supplier_id" class="<?= $classes['form-select'] ?>" data-placeholder="Выберите Поставщика" onchange="UpBtn('btn_save-<?= $this->number ?>')">
                    <option></option>
                    <?php foreach ($db->query("SELECT * FROM storage_item_suppliers") as $row): ?>
                        <option value="<?= $row['id'] ?>"  <?= ($this->value('item_supplier_id') == $row['id']) ? 'selected': '' ?>><?= $row['suplier'] ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td>
                <select name="item_manufacturer_id" class="<?= $classes['form-select'] ?>" data-placeholder="Выберите Производителя" onchange="UpBtn('btn_save-<?= $this->number ?>')">
                    <?php foreach ($db->query("SELECT * FROM storage_item_manufacturers") as $row): ?>
                        <option value="<?= $row['id'] ?>"  <?= ($this->value('item_manufacturer_id') == $row['id']) ? 'selected': '' ?>><?= $row['manufacturer'] ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
            <td>
                <input type="number" name="item_qty" class="form-control" min="1" placeholder="№" value="<?= $this->value('item_qty') ?>" onkeyup="UpBtn('btn_save-<?= $this->number ?>')">
            </td>
            <td>
                <input type="number" name="item_cost" class="form-control" min="0" placeholder="Введите цену" value="<?= $this->value('item_cost') ?>" onkeyup="UpBtn('btn_save-<?= $this->number ?>')">
            </td>
            <td>
                <input type="number" name="item_price" class="form-control" min="0" placeholder="Введите цену" value="<?= $this->value('item_price') ?>" onkeyup="UpBtn('btn_save-<?= $this->number ?>')">
            </td>
            <td>
                <input type="text" name="item_faktura" class="form-control" placeholder="Введите № фактуры" value="<?= $this->value('item_faktura') ?>" onkeyup="UpBtn('btn_save-<?= $this->number ?>')">
            </td>
            <td>
                <input type="text" name="item_shtrih" class="form-control" placeholder="Введите штрих" value="<?= $this->value('item_shtrih') ?>" onkeyup="UpBtn('btn_save-<?= $this->number ?>')">
            </td>
            <td>
                <input type="date" name="item_die_date" class="form-control daterange-single" value="<?= $this->value('item_die_date') ?>" onchange="UpBtn('btn_save-<?= $this->number ?>')">
            </td>
            <td class="text-center">
                <div class="list-icons">
                    <button onclick="DeleteRowArea(<?= $this->number ?>)" id="btn_delete-<?= $this->number ?>" type="button" class="btn list-icons-item text-danger-600"><i class="icon-trash"></i></button>
                    <?php if($pk): ?>
                        <button onclick="SaveRowArea(<?= $this->number ?>)" id="btn_save-<?= $this->number ?>" type="button" class="btn list-icons-item text-gray-600" disabled="true"><i class="icon-checkmark4"></i></button>
                    <?php else: ?>
                        <button onclick="SaveRowArea(<?= $this->number ?>)" id="btn_save-<?= $this->number ?>" type="button" class="btn list-icons-item text-success-600"><i class="icon-checkmark4"></i></button>
                    <?php endif; ?>
                </div>
            </td>
        <?php if(!$this->not_tr): ?>
            </tr>
        <?php endif; ?>
        <?php
    }

    public function get_or_404(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch(PDO::FETCH_ASSOC);
        if($object){
            $this->set_post($object);
            return $this->form($object['id']);
        }else{
            return $this->form();
        }

    }

    public function clear_post()
    {
        unset($this->post);
        $this->number ++;
    }

    public function save()
    {
        /**
         * Операция создания записи в базе!
         */
        if($this->clean()){
            $object = Mixin\insert($this->table, $this->post);
            if (!intval($object)){
                $this->error($object);
                exit;
            }
            $this->pk = $object;
            $this->success();
        }
    }

    public function update()
    {
        /**
         * Операция обновления записи в базе!
         */
        if($this->clean()){
            $pk = $this->post['id'];
            unset($this->post['id']);
            $object = Mixin\update($this->table, $this->post, $pk);
            if (!intval($object)){
                $this->error($object);
                exit;
            }
            $this->pk = $pk;
            $this->success();
        }
    }

    public function clean()
    {
        if (!$this->post['item_key']) {
            $this->post['item_key'] = uniqid('key-');
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function success()
    {
        echo json_encode(array(
            'status' => 'success',
            'pk' => $this->pk,
        ));
        exit;
    }

    public function error($message)
    {
        echo json_encode(array(
            'status' => 'error',
            'message' => $message,
        ));
        exit;
    }
}
        
?>