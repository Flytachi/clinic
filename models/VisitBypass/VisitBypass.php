<?php

class VisitBypassModel extends Model
{
    public $table = 'visit_bypass';
    public $_visits = 'visits';

    public function get_or_404(int $pk)
    {
        global $db;
        // Visit
        $object = $db->query("SELECT * FROM $this->_visits WHERE id = $pk AND direction IS NOT NULL AND completed IS NULL")->fetch(PDO::FETCH_ASSOC);
        if($object){

            // Bypass
            return $this->{$_GET['form']}($pk);
            /* $object2 = $db->query("SELECT * FROM $this->_visit_operations WHERE id = $pk AND completed IS NULL")->fetch(PDO::FETCH_ASSOC);
            if($object2 and ($session->session_id == $object2['grant_id'] or permission([8,11])) ){

                $this->visit_id = $_GET['visit_id'];
                $this->operation_id = $pk;
                $this->is_foreigner = $db->query("SELECT is_foreigner FROM users WHERE id = {$object['user_id']}")->fetchColumn();
                return $this->{$_GET['form']}();
                
            }else{
                Mixin\error('report_permissions_false');
                exit;
            } */

        }else{
            Mixin\error('report_permissions_false');
        }

    }

    public function form($pk = null)
    {
        ?>
        <form method="post" action="<?= add_url() ?>">
            <input type="hidden" name="model" value="<?= __CLASS__ ?>">
            <input type="hidden" name="id" value="<?= $pk ?>">
        </form>
        <?php
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