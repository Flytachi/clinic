<?php

class VisitFinish extends Model
{
    public $table = 'visit';
    public $table1 = 'users';
    public $table2 = 'beds';

    public function get_or_404($pk)
    {
        global $db;
        $this->post['completed'] = date('Y-m-d H:i:s');
        $db->beginTransaction();

        if (!permission([12])) {
            foreach($db->query("SELECT * FROM visit WHERE user_id=$pk AND parent_id= {$_SESSION['session_id']} AND accept_date IS NOT NULL AND completed IS NULL AND (service_id = 1 OR (report_title IS NOT NULL AND report IS NOT NULL))") as $inf){
                $this->status_controller($pk, $inf);
                $this->update();
            }
        }else {
            $this->post['accept_date'] = date('Y-m-d H:i:s');
            foreach($db->query("SELECT * FROM visit WHERE id=$pk AND completed IS NULL AND physio IS NOT NULL") as $inf){
                $this->status_controller($inf['user_id'], $inf);
                $this->update();
            }
        }
        $db->commit();
        $this->success();
    }

    public function status_controller($pk, $inf)
    {
        global $db;
        $this->post['status'] = ($inf['direction']) ? 0 : null;
        if ($inf['grant_id'] == $inf['parent_id'] and ($inf['direction'] or 1 == $db->query("SELECT * FROM visit WHERE user_id=$pk AND status != 5 AND completed IS NULL AND service_id != 1")->rowCount())) {
            if (!$inf['direction']) {
                Mixin\update($this->table1, array('status' => null), $pk);
            }
            if ($inf['direction']) {
                $pk_arr = array('user_id' => $pk);
                $object = Mixin\update($this->table2, array('user_id' => null), $pk_arr);
            }
        }
        if ($inf['assist_id']) {
            if (!$inf['direction']) {
                $this->post['grant_id'] = $_SESSION['session_id'];
                Mixin\update($this->table1, array('status' => null), $pk);
            }
        }
        $this->post['id'] = $inf['id'];
    }

    public function update()
    {
        $pk = $this->post['id'];
        unset($this->post['id']);
        $object = Mixin\update($this->table, $this->post, $pk);
        if ($object != 1){
            $this->error($object);
        }
    }

    public function success()
    {
        render("doctor/index");
    }

}

?>