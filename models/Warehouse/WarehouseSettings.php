<?php

class WarehouseSettingsModel extends Model
{
    public $table = 'warehouse_settings';
    public $_warehouse = 'warehouses';

    public function get_or_404(int $pk)
    {
        global $db;
        $object = $db->query("SELECT * FROM $this->_warehouse WHERE id = $pk AND is_active IS NOT NULL")->fetch(PDO::FETCH_ASSOC);
        if($object){
            $this->set_post($object);
            return $this->{$_GET['form']}($object['id']);
        }else{
            Mixin\error('report_permissions_false');
            exit;
        }

    }

    public function form($pk = null)
    {
        dd($this);
    }

    public function clean()
    {
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function success()
    {
        echo "Успешно";
    }

    public function error($message)
    {
        echo $message;
    }
}
        
?>