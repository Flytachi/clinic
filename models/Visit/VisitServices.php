<?php

class VisitServicesModel extends Model
{
    public $table = 'visit_services';
    public $_visits = 'visits';
    public $_prices = 'visit_prices';

    public function clean()
    {
        if ( isset($this->post['service_report']) ) {
            $report = $this->post['service_report'];
        }
        $this->post = Mixin\clean_form($this->post);
        $this->post = Mixin\to_null($this->post);
        if ( isset($report) ) {
            $this->post['service_report'] = $report;
        }
        return True;
    }

    public function update()
    {
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

    public function delete(int $pk)
    {
        global $db;
        $this->visit_pk = $db->query("SELECT visit_id FROM $this->table WHERE id = $pk")->fetchColumn();

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

        $this->status_update();
        
        $db->commit();
        $this->success($db->query("SELECT * FROM $this->table WHERE visit_id = $this->visit_pk AND status = 1")->rowCount());

    }

    public function status_update()
    {
        return (new VisitModel())->is_delete($this->visit_pk);
    }

    public function success($stat = null)
    {
        $mess = 'Успешно';
        echo json_encode(array(
            'status' => 'success',
            'count' => $stat,
            'visit_pk' => ( isset($this->visit_pk) ) ? $this->visit_pk : null,
            'pk' => ( isset($this->pk) ) ? $this->pk : null,
            'message' => $mess,
        ));
        exit;
    }

    public function error($message)
    {
        // $mess = '<div class="alert bg-danger alert-styled-left alert-dismissible">
        //     <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
        //     <span class="font-weight-semibold"> '.$message.'</span>
        // </div>';

        $mess = $message;
        echo json_encode(array(
            'status' => 'error',
            'message' => $mess,
        ));
        exit;
    }
}
        
?>