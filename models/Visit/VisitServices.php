<?php

class VisitServicesModel extends Model
{
    public $table = 'visit_services';
    public $_visits = 'visits';
    public $_prices = 'visit_prices';

    public function clean()
    {
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        return True;
    }

    public function delete(int $pk)
    {
        global $db;
        $data = $db->query("SELECT * FROM $this->table WHERE id = $pk")->fetch();

        $db->beginTransaction();
        // Visit prices 
        $object = Mixin\delete($this->_prices, $pk, "visit_service_id");
        if(!intval($object)){
            Mixin\error('404');
            $db->rollBack();
        }
        // Visit service 
        $object = Mixin\delete($this->table, $pk);
        if(!intval($object)){
            Mixin\error('404');
            $db->rollBack();
        }

        $result = $this->status_update($data);
        
        $db->commit();
        $this->success($result);

    }

    public function status_update(array $data)
    {
        return (new VisitModel())->is_delete($data['visit_id']);
    }

    public function success($stat = null)
    {
        if ($stat) {
            echo 1;
        }else{
            echo '<div class="alert alert-info" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                Успешно
            </div>';
        }
    }

    public function error($message)
    {
        echo '<div class="alert bg-danger alert-styled-left alert-dismissible">
            <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
            <span class="font-weight-semibold"> '.$message.'</span>
        </div>';
    }
}
        
?>