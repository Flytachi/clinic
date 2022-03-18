<?php

use Mixin\HellCrud;
use Mixin\Model;

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
        
        // Update vs Delete storages
        if ($obj['item_qty'] != $this->getPost('item_qty')) {
            $q = HellCrud::update($this->tStorage, array('item_qty' => $obj['item_qty']-$this->getPost('item_qty')), $obj['id']);
            if ( !is_numeric($q) and $q <= 0 ) $this->error('Ошибка удаления препарата');
        } else {
            if (HellCrud::delete($this->tStorage, $obj['id']) <= 0 ) $this->error('Ошибка удаления препарата');
        }

        // Create transaction
        $post = array(
            'warehouse_id_from' => $obj['warehouse_id'],
            'item_id' => $obj['id'],
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
        $this->error('операция не позволена');
    }
}

?>