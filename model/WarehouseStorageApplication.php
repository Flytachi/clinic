<?php

use Mixin\HellCrud;
use Mixin\Model;

class WarehouseStorageApplication extends Model
{
    public $table = 'warehouse_storage_applications';

    public function Axe()
    {
        $this->updateBefore();
        $object = HellCrud::update($this->table, array( 'status' => $this->getGet('status') ), $this->getGet('id'));
        if (!is_numeric($object) and $object <= 0) $this->error($object);
        $this->updateAfter();
    }

}

?>