<?php

use Mixin\HellCrud;
use Mixin\Model;

class VisitFinish extends Model
{
    public $table = 'visit_services';
    public $_visits = 'visits';
    public $_client = 'clients';
    public $_beds = 'beds';

    public function get_or_404($pk)
    {
        global $db, $session;
        $this->post['status'] = 7;
        $this->post['completed'] = date('Y-m-d H:i:s');
        
        $db->beginTransaction();
        
        if ($_GET['form'] == "service") {
            $this->update_service($pk);
            $pk = $db->query("SELECT visit_id FROM $this->table WHERE id = $pk")->fetchColumn();
        }else {
            $data = $db->query("SELECT * FROM $this->_visits WHERE id = $pk")->fetch();
            
            if ($data['direction'] and $data['grant_id'] == $session->session_id) {

                // Выписка
                $vis_service = $db->query("SELECT id FROM $this->table WHERE visit_id = $pk AND completed IS NULL AND status = 3 AND service_id = 1")->fetchColumn();
                HellCrud::update($this->_visits, array('is_active' => null), $data['id']);
                HellCrud::update($this->table, array('status' => 1, 'completed' => date('Y-m-d H:i:s')), $vis_service);
                $bed = $db->query("SELECT * FROM visit_beds WHERE visit_id = $pk AND end_date IS NULL")->fetch();
                HellCrud::update($this->_beds, array('client_id' => null), $bed['bed_id']);
                HellCrud::update("visit_beds", array('end_date' => date("Y-m-d H:i:s")), $bed['id']);
                HellCrud::delete("visit_bypass_event_applications", $pk, "visit_id");

            }else {

                // Завершение
                foreach($db->query("SELECT * FROM $this->table WHERE visit_id = $pk AND completed IS NULL AND status = 3 AND responsible_id = $session->session_id") as $row){
                    $this->update_service($row['id']);
                }

            }
        }
        
        $this->status_update($pk);

        $db->commit();
        $this->success();
    }

    public function status_update($pk)
    {
        return (new VisitModel())->is_delete($pk);
    }

    public function update_service($pk)
    {
        $object = HellCrud::update($this->table, $this->post, $pk);
        if ($object != 1){
            $this->error($object);
        }
    }

    public function success()
    {
        if ($_GET['form'] == "service") {
            $_SESSION['message'] = '
            <div class="alert alert-primary" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                Успешно
            </div>
            ';
            render();
        }else{
            render("doctor/index");
        }
    }

}

?>