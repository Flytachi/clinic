<?php

use Mixin\Model;

class VisitFinishStationar extends VisitFinish
{
    public $table_application = "visit_applications";

    public function tempFunc($pk)
    {
        global $session, $db;
        $post = $db->query("SELECT division_id, parent_id 'responsible_id', user_id FROM $this->table WHERE visit_id = $pk AND completed IS NULL AND status = 3 AND parent_id = $session->session_id")->fetch();
        Mixin\insert($this->table_application, $post);
    }
}
        
?>