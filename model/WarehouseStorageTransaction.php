<?php

use Mixin\HellCrud;
use Mixin\Model;

use function Mixin\error;

class WarehouseStorageTransaction extends Model
{
    public $table = 'warehouse_storage_transactions';
    public $tItemManufacturer = 'warehouse_item_manufacturers';
    public $tItemName = 'warehouse_item_names';
    public $tStorage = 'warehouse_storage';

    public function updateBody()
    {
        if ($this->getGet('form') == "writtenOffItem") $this->transactionWrittenOff();
        elseif($this->getGet('form') == "refundItem") $this->transactionRefund();
        else parent::updateBody();
    }

    private function transactionWrittenOff()
    {
        $obj = $this->db->query("SELECT * FROM $this->tStorage WHERE id = " . $this->getPost('item_id'))->fetch();
        if(!$obj) $this->error('Препарат не найден');

        // Update vs Delete storages
        if ($obj['item_qty'] != $this->getPost('item_qty')) {
            $q = HellCrud::update($this->tStorage, array('item_qty' => $obj['item_qty']-$this->getPost('item_qty')), $obj['id']);
            if ( !is_numeric($q) and $q <= 0 ) $this->error('Ошибка при удалении препарата');
        } else {
            if (HellCrud::delete($this->tStorage, $obj['id']) <= 0 ) $this->error('Ошибка при удалении препарата');
        }

        // Create transaction
        $post = array(
            'warehouse_id_from' => $obj['warehouse_id'],
            'item_name' => $this->db->query("SELECT name FROM $this->tItemName WHERE id = {$obj['item_name_id']}")->fetchColumn(),
            'item_manufacturer' => $this->db->query("SELECT manufacturer FROM $this->tItemManufacturer WHERE id = {$obj['item_manufacturer_id']}")->fetchColumn(),
            'item_qty' => $this->getPost('item_qty'),
            'item_price' => $obj['item_price'],
            'is_written_off' => 1,
            'responsible_id' => $this->getPost('responsible_id'),
            'cost' => $this->getPost('item_qty') * $obj['item_price'],
            'comment' => $this->getPost('comment'),
        );
        if (!is_numeric(HellCrud::insert($this->table, $post))) $this->error('Ошибка при создании транзакции');
    }

    private function transactionRefund()
    {
        $obj = $this->db->query("SELECT * FROM $this->tStorage WHERE id = " . $this->getPost('item_id'))->fetch();
        if(!$obj) $this->error('Препарат не найден');

        // Update vs Delete storages (from)
        if ($obj['item_qty'] != $this->getPost('item_qty')) {
            // update
            $q = HellCrud::update($this->tStorage, array('item_qty' => $obj['item_qty']-$this->getPost('item_qty')), $obj['id']);
            if ( !is_numeric($q) and $q <= 0 ) $this->error('Ошибка при удалении препарата');
        } else {
            // delete
            if (HellCrud::delete($this->tStorage, $obj['id']) <= 0 ) $this->error('Ошибка при удалении препарата');
        }

        // Update vs Delete storages (in) 
        importModel('WarehouseStorage');
        $searchObj = array(
            'warehouse_id' => $this->getPost('warehouse_id_in'),
            'item_name_id' => $obj['item_name_id'],
            'item_manufacturer_id' => $obj['item_manufacturer_id'],
            'item_price' => $obj['item_price'],
            'item_die_date' => $obj['item_die_date'],
        );
        if ($item = (new WarehouseStorage)->by($searchObj)) {
            // update
            $q = HellCrud::update($this->tStorage, array('item_qty' => $item->item_qty+$this->getPost('item_qty')), $item->id);
            if ( !is_numeric($q) and $q <= 0 ) $this->error('Ошибка при добавлении препарата');
        } else {
            // create
            $q = HellCrud::insert($this->tStorage, array_merge($searchObj, array('item_qty' => $this->getPost('item_qty'))));
            if ( !is_numeric($q) ) $this->error('Ошибка при создании препарата');
        }

        // Create transaction
        $post = array(
            'warehouse_id_from' => $obj['warehouse_id'],
            'warehouse_id_in' => $this->getPost('warehouse_id_in'),
            'item_name' => $this->db->query("SELECT name FROM $this->tItemName WHERE id = {$obj['item_name_id']}")->fetchColumn(),
            'item_manufacturer' => $this->db->query("SELECT manufacturer FROM $this->tItemManufacturer WHERE id = {$obj['item_manufacturer_id']}")->fetchColumn(),
            'item_qty' => $this->getPost('item_qty'),
            'item_price' => $obj['item_price'],
            'is_moving' => 1,
            'responsible_id' => $this->getPost('responsible_id'),
            'cost' => $this->getPost('item_qty') * $obj['item_price'],
            'comment' => $this->getPost('comment'),
        );
        if (!is_numeric(HellCrud::insert($this->table, $post))) $this->error('Ошибка при создании транзакции');
    }

    private function transactionMoving()
    {
        $obj = $this->db->query("SELECT * FROM $this->tStorage WHERE id = " . $this->getPost('item_id'))->fetch();
        if(!$obj) $this->error('Препарат не найден');

        // Update vs Delete storages (from)
        if ($obj['item_qty'] != $this->getPost('item_qty')) {
            // update
            $q = HellCrud::update($this->tStorage, array('item_qty' => $obj['item_qty']-$this->getPost('item_qty')), $obj['id']);
            if ( !is_numeric($q) and $q <= 0 ) $this->error('Ошибка при удалении препарата');
        } else {
            // delete
            if (HellCrud::delete($this->tStorage, $obj['id']) <= 0 ) $this->error('Ошибка при удалении препарата');
        }

        // Update vs Delete storages (in) 
        importModel('WarehouseStorage');
        $searchObj = array(
            'warehouse_id' => $this->getPost('warehouse_id_in'),
            'item_name_id' => $obj['item_name_id'],
            'item_manufacturer_id' => $obj['item_manufacturer_id'],
            'item_price' => $obj['item_price'],
            'item_die_date' => $obj['item_die_date'],
        );
        if ($item = (new WarehouseStorage)->by($searchObj)) {
            // update
            $q = HellCrud::update($this->tStorage, array('item_qty' => $item->item_qty+$this->getPost('item_qty')), $item->id);
            if ( !is_numeric($q) and $q <= 0 ) $this->error('Ошибка при добавлении препарата');
        } else {
            // create
            $q = HellCrud::insert($this->tStorage, array_merge($searchObj, array('item_qty' => $this->getPost('item_qty'))));
            if ( !is_numeric($q) ) $this->error('Ошибка при создании препарата');
        }

        // Create transaction
        $post = array(
            'warehouse_id_from' => $obj['warehouse_id'],
            'warehouse_id_in' => $this->getPost('warehouse_id_in'),
            'item_name' => $this->db->query("SELECT name FROM $this->tItemName WHERE id = {$obj['item_name_id']}")->fetchColumn(),
            'item_manufacturer' => $this->db->query("SELECT manufacturer FROM $this->tItemManufacturer WHERE id = {$obj['item_manufacturer_id']}")->fetchColumn(),
            'item_qty' => $this->getPost('item_qty'),
            'item_price' => $obj['item_price'],
            'is_moving' => 1,
            'responsible_id' => $this->getPost('responsible_id'),
            'cost' => $this->getPost('item_qty') * $obj['item_price'],
            'comment' => $this->getPost('comment'),
        );
        if (!is_numeric(HellCrud::insert($this->table, $post))) $this->error('Ошибка при создании транзакции');
    }

    public function addTransaction(Int $warehouse_in, Int $responsible, Array $items, $comment = null)
    {
        $this->setPost(array(
            'warehouse_id_in' => $warehouse_in,
            'responsible_id' => $responsible,
            'comment' => $comment
        ));
        foreach ($items as $id => $qty) {
            if ($qty > 0) {
                $this->setPostItem('item_id', $id);
                $this->setPostItem('item_qty', $qty);
                $this->transactionMoving();
            }
        }
    }

}

?>